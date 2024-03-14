<?php

namespace Tests\Feature\Semana4;


use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\DataHelper;
use Tests\TestCase;

class AuthenticationRoutesTest extends TestCase
{
    use RefreshDatabase, DataHelper;
    // Verificar que no podemos acceder sin autenticar a las rutas en las que debemos estarlo. Y que si podemos entrar si lo estamos.
    public function test_unauthenticated_cannot_access_protected_routes()
    {

        $response = $this->get('/');

        $response->assertStatus(200);

        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('orders.index'));
        $response->assertStatus(200);
        $response = $this->actingAs($user)->get(route('admin.index'));
        $response->assertStatus(403);

        Role::create(['name' => 'admin']);
        $adminUser = User::factory()->create()->assignRole('admin');

        $response = $this->actingAs($adminUser)->get(route('admin.index'));
        $response->assertStatus(200);

    }
}
