<?php

namespace Tests\Feature\Semana3;

use App\Http\Livewire\DropdownCart;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\{DataHelper, TestCase};

// Comprobar que al añadir un item al carrito, el número del circulito rojo se incrementa.
class CartItemCountTest extends TestCase
{
    use RefreshDatabase, DataHelper;
    public function test_item_count_increases_on_add_to_cart()
    {

        Livewire::test(DropdownCart::class)
        ->assertSeeHtml('<span class="absolute top-0 right-0 inline-block w-2 h-2 transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full"></span>');

        $this->getProduct();
        $this->addItemToCart($this->product);

        Livewire::test(DropdownCart::class)
        ->assertSeeHtml('<span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full">1</span>');

    }
}
