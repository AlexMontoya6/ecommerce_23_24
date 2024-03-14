<?php

namespace Tests\Feature\Semana2;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use App\Http\Livewire\AddCartItem;
use Tests\TestCaseWithSetup;
use Livewire\Livewire;
use Tests\DataHelper;
use Tests\TestCase;

class ProductDetailContentTest extends TestCase
{
    use RefreshDatabase, DataHelper;
    public function test_product_detail_displays_images_description_name_price_stock_with_quantity_buttons_and_add_to_cart()
    {



        $this->getProduct();

        $response = $this->get(route('products.show', $this->product));

        $response->assertStatus(200);

        foreach ($this->product->images as $image) {
            $response->assertSee(Storage::url($image->url));
        }

        $response->assertSee($this->product->name);
        $response->assertSee($this->product->price);

        Livewire::test(AddCartItem::class, ['product' => $this->product])

            ->call('increment')
            ->assertSet('qty', 2)
            ->call('decrement')
            ->assertSet('qty', 1);


    }

}
