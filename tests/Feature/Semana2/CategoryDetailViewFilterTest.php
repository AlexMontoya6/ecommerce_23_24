<?php

namespace Tests\Feature\Semana2;

use App\Http\Livewire\CategoryFilter;
use App\Models\Brand;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Tests\DataHelper;
use Tests\TestCase;
use Tests\TestCaseWithSetup;

class CategoryDetailViewFilterTest extends TestCase
{
    use RefreshDatabase, DataHelper;
    public function test_left_menu_filter_by_subcategory_or_brand()
    {

        /*
         * Verificar que al pinchar en el menú de la izq.
         * (en la vista de detalle de una categoría)
         * filtra los productos por subcategoría o por marca.
         */

        $this->getProducts(4);

        $this->getSubcategories(2);

        $this->getBrands(2);

        // producto 1 con subcategoria 0 y marca 0
        $this->products[0]->subcategory_id = $this->category->subcategories[0]->id;
        $this->products[0]->brand_id = $this->brands[0]->id;

        // producto 2 con subcategoria 0 y marca 1
        $this->products[1]->subcategory_id = $this->category->subcategories[0]->id;
        $this->products[1]->brand_id = $this->brands[1]->id;

        // producto 3 con subcategoria 1 y marca 0
        $this->products[2]->subcategory_id = $this->category->subcategories[1]->id;
        $this->products[2]->brand_id = $this->brands[0]->id;

        // producto 4 con subcategoria 1 y marca 1
        $this->products[3]->subcategory_id = $this->category->subcategories[1]->id;
        $this->products[3]->brand_id = $this->brands[1]->id;



        Livewire::test(CategoryFilter::class, ['category' => $this->category])
            ->set('subcategoria', $this->subcategory->slug)
            ->assertViewHas('products', function ($products) {
                return $products->every(function ($product) {
                    return $product->subcategory_id == $this->subcategory->id;
                });
            });


        Livewire::test(CategoryFilter::class, ['category' => $this->category])
            ->set('marca', $this->brand->name)
            ->assertViewHas('products', function ($products) {
                return $products->every(function ($product) {
                    return $product->brand_id == $this->brand->id;
                });
            });


    }
}
