<?php

namespace Tests\Feature\Semana2;

use App\Http\Livewire\{AddCartItem, AddCartItemColor, AddCartItemSize};
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\{TestCase, DataHelper};
use Livewire\Livewire;

class ProductAttributesTest extends TestCase
{
    use RefreshDatabase, DataHelper;

    // Comprobar que vemos los desplegables de talla y color según el producto elegido.
    public function test_dropdowns_for_size_and_color_appear_based_on_selected_product()
    {

        $this->getProduct();
        $this->getProductWithSize();
        $this->getProductWithColor();

        Livewire::test(AddCartItem::class, ['product' => $this->product])
            ->assertDontSeeHtml('<select wire:model="size_id" class="form-control w-full">')
            ->assertDontSeeHtml('<select wire:model="color_id" class="form-control w-full">')
            ->assertDontSee('Seleccionar un color')
            ->assertDontSee('Seleccione una talla')
            ->assertDontSee('Seleccione un color');

        Livewire::test(AddCartItemColor::class, ['product' => $this->productWithColor])
            ->assertSeeHtml('<select wire:model="color_id" class="form-control w-full">')
            ->assertSee('Seleccionar un color')
            ->assertDontSeeHtml('<select wire:model="size_id" class="form-control w-full">')
            ->assertDontSee('Seleccione una talla');

        Livewire::test(AddCartItemSize::class, ['product' => $this->productWithSize])
            ->assertSeeHtml('<select wire:model="size_id" class="form-control w-full">')
            ->assertSeeHtml('<select wire:model="color_id" class="form-control w-full">')
            ->assertSee('Seleccione una talla')
            ->assertSee('Seleccione un color');
    }
}
