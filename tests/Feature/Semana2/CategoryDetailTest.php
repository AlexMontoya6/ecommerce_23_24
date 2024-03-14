<?php

namespace Tests\Feature\Semana2;

use App\Http\Livewire\CategoryFilter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\DataHelper;
use Tests\TestCase;
use Illuminate\Support\Str;

class CategoryDetailTest extends TestCase
{
    use RefreshDatabase, DataHelper;
    public function test_access_category_detail()
    {
        // $response = $this->get(route('categories.show', $this->category));

        // $response->assertStatus(200);

        // $response->assertSee($this->category->name);
        // $response->assertSee($this->subcategory->name);
        // $response->assertSee('Subcategorías');
        // $response->assertSee($this->brand->name);
        // $response->assertSee('Marcas');
        // $response->assertSee($this->product->name);

        $this->getProduct();

        Livewire::test(CategoryFilter::class, ['category' => $this->category])
        ->assertSee($this->category->name)
        ->assertSee($this->subcategory->name)
        ->assertSee('Subcategorías')
        ->assertSee($this->brand->name)
        ->assertSee('Marcas')
        ->assertSee(Str::limit($this->product->name, 20));
    }
}


