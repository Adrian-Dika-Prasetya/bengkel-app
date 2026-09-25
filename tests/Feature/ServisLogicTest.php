<?php

namespace Tests\Feature;

use App\Http\Controllers\DashboardController;
use App\Models\DetailServis;
use App\Models\Kendaraan;
use App\Models\Pembayaran;
use App\Models\Servis;
use App\Models\Sparepart;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ServisLogicTest extends TestCase
{
    use RefreshDatabase;

    public function test_mekanik_cannot_view_servis_assigned_to_others(): void
    {
        $mekanik = User::factory()->create();
        $servisLain = Servis::factory()->create();

        $this->actingAs($mekanik)
            ->get(route('servises.show', $servisLain))
            ->assertForbidden();
    }

    public function test_mekanik_can_view_servis_assigned_to_them(): void
    {
        $mekanik = User::factory()->create();
        $servis = Servis::factory()->create(['mekanik_id' => $mekanik->id]);

        $this->actingAs($mekanik)
            ->get(route('servises.show', $servis))
            ->assertOk();
    }

    public function test_batal_servis_cannot_receive_payment(): void
    {
        $servis = Servis::factory()->create(['status' => 'batal', 'total_bayar' => 100000]);

        $this->actingAs(User::factory()->kasir()->create())
            ->post(route('servises.pembayaran', $servis), [
                'jumlah_bayar' => 50000,
                'metode' => 'tunai',
            ])
            ->assertSessionHasErrors('pembayaran');

        $this->assertDatabaseCount('pembayarans', 0);
    }

    public function test_batal_servis_cannot_be_lunasi(): void
    {
        $servis = Servis::factory()->create(['status' => 'batal', 'total_bayar' => 100000]);

        $this->actingAs(User::factory()->kasir()->create())
            ->post(route('servises.lunasi', $servis))
            ->assertSessionHasErrors('pembayaran');

        $this->assertDatabaseCount('pembayarans', 0);
    }

    public function test_paid_servis_cannot_be_cancelled(): void
    {
        $servis = Servis::factory()->create(['status' => 'selesai', 'total_bayar' => 100000]);
        Pembayaran::factory()->create([
            'servis_id' => $servis->id,
            'jumlah_bayar' => 100000,
        ]);

        $this->actingAs(User::factory()->kasir()->create())
            ->patch(route('servises.status', $servis), ['status' => 'batal'])
            ->assertSessionHasErrors('status');

        $this->assertDatabaseHas('servises', ['id' => $servis->id, 'status' => 'selesai']);
    }

    public function test_sparepart_that_was_used_cannot_be_deleted(): void
    {
        $servis = Servis::factory()->create();
        $sparepart = Sparepart::factory()->create();
        DetailServis::create([
            'servis_id' => $servis->id,
            'sparepart_id' => $sparepart->id,
            'jumlah' => 1,
            'harga_satuan' => $sparepart->harga_jual,
            'subtotal' => $sparepart->harga_jual,
        ]);

        $this->actingAs(User::factory()->admin()->create())
            ->delete(route('spareparts.destroy', $sparepart))
            ->assertSessionHasErrors('sparepart');

        $this->assertDatabaseHas('spareparts', ['id' => $sparepart->id]);
    }

    public function test_kendaraan_with_servis_history_cannot_be_deleted(): void
    {
        $servis = Servis::factory()->create();
        $kendaraan = $servis->kendaraan;

        $this->actingAs(User::factory()->admin()->create())
            ->delete(route('kendaraans.destroy', $kendaraan))
            ->assertSessionHasErrors('kendaraan');

        $this->assertDatabaseHas('kendaraans', ['id' => $kendaraan->id]);
    }

    public function test_servis_can_be_created_without_sparepart(): void
    {
        $kendaraan = Kendaraan::factory()->create();

        $this->actingAs(User::factory()->admin()->create())
            ->post(route('servises.store'), [
                'kendaraan_id' => $kendaraan->id,
                'mekanik_id' => '',
                'keluhan' => 'Ganti oli',
                'biaya_jasa' => 50000,
                'sparepart_ids' => [''],
                'jumlahs' => [''],
            ])
            ->assertRedirect(route('servises.index'));

        $this->assertDatabaseHas('servises', ['kendaraan_id' => $kendaraan->id, 'total_bayar' => 50000]);
        $this->assertDatabaseCount('detail_servises', 0);
    }

    public function test_duplicate_sparepart_in_one_transaction_is_rejected(): void
    {
        $kendaraan = Kendaraan::factory()->create();
        $sparepart = Sparepart::factory()->create(['stok' => 10]);

        $this->actingAs(User::factory()->admin()->create())
            ->post(route('servises.store'), [
                'kendaraan_id' => $kendaraan->id,
                'mekanik_id' => '',
                'keluhan' => 'Tune up',
                'biaya_jasa' => 25000,
                'sparepart_ids' => [(string) $sparepart->id, (string) $sparepart->id],
                'jumlahs' => ['1', '1'],
            ])
            ->assertSessionHasErrors('sparepart_ids');

        $this->assertDatabaseCount('servises', 0);
        $this->assertDatabaseHas('spareparts', ['id' => $sparepart->id, 'stok' => 10]);
    }

    public function test_dashboard_tagihan_belum_lunas_excludes_batal_servis(): void
    {
        Servis::factory()->create(['status' => 'batal', 'total_bayar' => 100000]);
        $belumLunas = Servis::factory()->create(['status' => 'selesai', 'total_bayar' => 100000]);

        $this->actingAs(User::factory()->admin()->create())
            ->get(route('dashboard'))
            ->assertOk();

        $this->assertEquals(
            1,
            $this->tagihanBelumLunas()
        );

        $this->assertNotNull($belumLunas);
    }

    private function tagihanBelumLunas(): int
    {
        $controller = new DashboardController;
        $method = new \ReflectionMethod($controller, 'tagihanBelumLunas');

        return $method->invoke($controller);
    }
}
