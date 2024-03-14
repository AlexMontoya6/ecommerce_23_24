<?php

namespace Tests\Feature\Semana2;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Livewire\AddCartItem;
use Tests\{TestCase, DataHelper};
use Livewire\Livewire;

class ProductDetailButtonLimitsTest extends TestCase
{
    use RefreshDatabase, DataHelper;

    // Comprobar los límites de los botones + y - en la vista detalle del producto.
    public function test_product_detail_button_limits()
    {


        $this->newAttributesProduct(['quantity' => 3]);
        $response = $this->get(route('products.show', $this->product));
        $response->assertStatus(200);


        Livewire::test(AddCartItem::class, ['product' => $this->product])
            ->assertSet('qty', 1)
            ->call('increment')
            ->assertSet('qty', 2)
            ->call('increment')
            ->assertSet('qty', 3)
            ->tap(function ($component) {
                //x-bind:disabled="$wire.qty > $wire.quantity"
                if ($component->get('qty') < $component->get('quantity')) {
                    $component->call('increment');
                }
            })
            ->assertSet('qty', 3)
            ->call('decrement')
            ->assertSet('qty', 2)
            ->call('decrement')
            ->assertSet('qty', 1)
            ->tap(function ($component) {
                // x-bind:disabled="$wire.qty <= 1"

                if ($component->get('qty') > 1) {
                    $component->call('decrement');
                }
            })
            ->assertSet('qty', 1);



    }
}
