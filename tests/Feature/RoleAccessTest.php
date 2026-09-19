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

    public function test_mekanik_cannot_set_status_lunas(): void
    {
        $mekanik = User::factory()->create();
        $servis = Servis::factory()->create([
            'mekanik_id' => $mekanik->id,
            'status' => 'proses',
        ]);

        $this->actingAs($mekanik)
            ->patch(route('servises.status', $servis), ['status' => 'lunas'])
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

    public function test_kasir_can_set_status_lunas(): void
    {
        $servis = Servis::factory()->create(['status' => 'selesai']);

        $this->actingAs(User::factory()->kasir()->create())
            ->patch(route('servises.status', $servis), ['status' => 'lunas'])
            ->assertRedirect();

        $this->assertDatabaseHas('servises', ['id' => $servis->id, 'status' => 'lunas']);
    }

    public function test_guest_cannot_access_dashboard(): void
    {
        $this->get(route('dashboard'))
            ->assertRedirect(route('login', absolute: false));
    }
}
