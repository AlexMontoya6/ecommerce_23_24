<?php

namespace Tests\Feature\Semana2;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Tests\DataHelper;
use Tests\TestCase;

class NavigationLinksVisibilityTest extends TestCase
{
    use RefreshDatabase, DataHelper;

    public function test_navigation_links_visible_based_on_authentication_status()
    {
        $response = $this->get('/');

        $response->assertSee('Iniciar sesión')
            ->assertSee('Registrarse')
            ->assertDontSee('Perfil')
            ->assertDontSee('Finalizar sesión');

        $user = User::factory()->create();

        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $response = $this->get('/');

        $response->assertDontSee('Iniciar sesión')
            ->assertDontSee('Registrarse')
            ->assertSee('Perfil')
            ->assertSee('Finalizar sesión');

    }

}
