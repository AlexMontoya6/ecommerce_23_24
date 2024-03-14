<?php

namespace Tests\Feature\Semana3;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\DataHelper;
use Tests\TestCase;

// Comprobar que se agregan al carrito los tres tipos de productos que tenemos.
class ProductCartAdditionTest extends TestCase
{
    use RefreshDatabase, DataHelper;
    public function test_adding_all_types_of_products_to_cart()
    {
        $this->getProduct();
        $this->getProductWithColor();
        $this->getProductWithSize();

        $this->getColors();
        $this->getSizes();

        $this->addItemToCart($this->product, 1,);
        $this->addItemToCart($this->productWithColor, 1, [
            'color' => $this->colors[0]->name,
            'color_id' => $this->colors[0]->id,
        ]);
        $this->addItemToCart($this->productWithSize, 1, [
            'size' => $this->sizes[0]->name,
            'size_id' => $this->sizes[0]->id,
            'color' => $this->colors[0]->name,
            'color_id' => $this->colors[0]->id,
        ]);

        $this->assertNotEmpty(Cart::content());
        $this->assertCount(3, Cart::content());

        $cartItems = Cart::content();
        foreach ($cartItems as $item) {
            $this->assertNotNull($item->id);
            $this->assertNotNull($item->name);
            $this->assertNotNull($item->price);
            $this->assertEquals(1, $item->qty);


            if ($item->options->has('color')) {
                $this->assertNotNull($item->options->color);
                $this->assertNotNull($item->options->color_id);
            }

            if ($item->options->has('size')) {
                $this->assertNotNull($item->options->size);
                $this->assertNotNull($item->options->size_id);
            }
        }


        Cart::destroy();

    }
}
