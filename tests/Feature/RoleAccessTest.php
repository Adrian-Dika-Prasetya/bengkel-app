<?php

namespace Tests\Feature;

use App\Models\Servis;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_access_sparepart_management(): void
    {
        $this->actingAs(User::factory()->admin()->create())
            ->get(route('spareparts.index'))
            ->assertOk();
    }

    public function test_kasir_cannot_access_sparepart_management(): void
    {
        $this->actingAs(User::factory()->kasir()->create())
            ->get(route('spareparts.index'))
            ->assertForbidden();
    }

    public function test_mekanik_cannot_access_sparepart_management(): void
    {
        $this->actingAs(User::factory()->create())
            ->get(route('spareparts.index'))
            ->assertForbidden();
    }

    public function test_kasir_can_access_kendaraan_management(): void
    {
        $this->actingAs(User::factory()->kasir()->create())
            ->get(route('kendaraans.index'))
            ->assertOk();
    }

    public function test_admin_can_access_kendaraan_management(): void
    {
        $this->actingAs(User::factory()->admin()->create())
            ->get(route('kendaraans.index'))
            ->assertOk();
    }

    public function test_mekanik_cannot_access_kendaraan_management(): void
    {
        $this->actingAs(User::factory()->create())
            ->get(route('kendaraans.index'))
            ->assertForbidden();
    }

    public function test_mekanik_can_access_servis_list(): void
    {
        $this->actingAs(User::factory()->create())
            ->get(route('servises.index'))
            ->assertOk();
    }

    public function test_mekanik_only_sees_servis_assigned_to_them(): void
    {
        $mekanik = User::factory()->create();
        $servisSendiri = Servis::factory()->create([
            'mekanik_id' => $mekanik->id,
            'kode_transaksi' => 'SRV-SENDIRI',
        ]);
        $servisLain = Servis::factory()->create(['kode_transaksi' => 'SRV-LAIN']);

        $response = $this->actingAs($mekanik)->get(route('servises.index'));

        $response->assertOk()
            ->assertSee($servisSendiri->kode_transaksi)
            ->assertDontSee($servisLain->kode_transaksi);
    }

    public function test_mekanik_can_mark_own_servis_as_selesai(): void
    {
        $mekanik = User::factory()->create();
        $servis = Servis::factory()->create([
            'mekanik_id' => $mekanik->id,
            'status' => 'proses',
        ]);

        $response = $this->actingAs($mekanik)
            ->patch(route('servises.status', $servis), ['status' => 'selesai']);

        $response->assertRedirect();
        $this->assertDatabaseHas('servises', ['id' => $servis->id, 'status' => 'selesai']);
    }

    public function test_mekanik_cannot_set_status_batal(): void
    {
        $mekanik = User::factory()->create();
        $servis = Servis::factory()->create([
            'mekanik_id' => $mekanik->id,
            'status' => 'proses',
        ]);

        $this->actingAs($mekanik)
            ->patch(route('servises.status', $servis), ['status' => 'batal'])
            ->assertForbidden();

        $this->assertDatabaseHas('servises', ['id' => $servis->id, 'status' => 'proses']);
    }

    public function test_mekanik_cannot_change_status_of_servis_assigned_to_others(): void
    {
        $mekanik = User::factory()->create();
        $servisLain = Servis::factory()->create(['status' => 'proses']);

        $this->actingAs($mekanik)
            ->patch(route('servises.status', $servisLain), ['status' => 'selesai'])
            ->assertForbidden();
    }

    public function test_kasir_can_set_status_batal(): void
    {
        $servis = Servis::factory()->create(['status' => 'selesai']);

        $this->actingAs(User::factory()->kasir()->create())
            ->patch(route('servises.status', $servis), ['status' => 'batal'])
            ->assertRedirect();

        $this->assertDatabaseHas('servises', ['id' => $servis->id, 'status' => 'batal']);
    }

    public function test_kasir_can_record_pembayaran(): void
    {
        $servis = Servis::factory()->create(['status' => 'selesai', 'total_bayar' => 100000]);
        $kasir = User::factory()->kasir()->create();

        $this->actingAs($kasir)
            ->post(route('servises.pembayaran', $servis), [
                'jumlah_bayar' => 100000,
                'metode' => 'tunai',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('pembayarans', [
            'servis_id' => $servis->id,
            'kasir_id' => $kasir->id,
            'jumlah_bayar' => 100000,
        ]);

        $this->assertTrue($servis->fresh()->lunas);
    }

    public function test_mekanik_cannot_record_pembayaran(): void
    {
        $servis = Servis::factory()->create(['status' => 'selesai']);

        $this->actingAs(User::factory()->create())
            ->post(route('servises.pembayaran', $servis), [
                'jumlah_bayar' => 50000,
                'metode' => 'tunai',
            ])
            ->assertForbidden();
    }

    public function test_pembayaran_tidak_boleh_melebihi_sisa_tagihan(): void
    {
        $servis = Servis::factory()->create(['total_bayar' => 100000]);

        $this->actingAs(User::factory()->kasir()->create())
            ->post(route('servises.pembayaran', $servis), [
                'jumlah_bayar' => 150000,
                'metode' => 'tunai',
            ])
            ->assertSessionHasErrors('jumlah_bayar');

        $this->assertDatabaseCount('pembayarans', 0);
    }

    public function test_guest_cannot_access_dashboard(): void
    {
        $this->get(route('dashboard'))
            ->assertRedirect(route('login', absolute: false));
    }
}
