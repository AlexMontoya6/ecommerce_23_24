<?php

namespace Tests\Feature\Semana2;

use Illuminate\Support\Str;
use App\Http\Livewire\CategoryProducts;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Product;
use Livewire\Livewire;
use Tests\DataHelper;
use Tests\TestCase;

class VisibilityOfProductsTest extends TestCase
{
    use RefreshDatabase, DataHelper;
    public function test_at_least_five_products_are_visible_in_main_view()
    {

        $this->getProducts(5);


        Livewire::test(CategoryProducts::class, ['category' => $this->category, 'products' => $this->products])
            ->assertSee(Str::limit($this->products[0]->name, 20))
            ->assertSee(Str::limit($this->products[1]->name, 20))
            ->assertSee(Str::limit($this->products[2]->name, 20))
            ->assertSee(Str::limit($this->products[3]->name, 20))
            ->assertSee(Str::limit($this->products[4]->name, 20));

    }

    public function test_visible_published_products_in_main_view()
    {
        $this->getProduct();
        $this->newAttributesProducts(['status' => Product::BORRADOR], 4);
        $this->products->add($this->product);

        Livewire::test(CategoryProducts::class, ['category' => $this->category, 'products' => $this->products])
            ->assertViewHas('products', function ($p) {
                return $p[0]->status === Product::BORRADOR;
            })
            ->assertViewHas('products', function ($p) {
                return $p[1]->status === Product::BORRADOR;
            })
            ->assertViewHas('products', function ($p) {
                return $p[2]->status === Product::BORRADOR;
            })
            ->assertViewHas('products', function ($p) {
                return $p[3]->status === Product::BORRADOR;
            })
            ->assertViewHas('products', function ($p) {
                return $p[4]->status === Product::PUBLICADO;
            });
    }



}


