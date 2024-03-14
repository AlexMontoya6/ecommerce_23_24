<?php

namespace Tests;


use App\Models\{Category, Subcategory, Brand, Color, Product, Image, Size};
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Str;

trait DataHelper
{
    protected $category;
    protected $subcategory;
    protected $subCategoryWithColor;
    protected $subCategoryWithSize;
    protected $subcategories;
    protected $brand;
    protected $brands;
    protected $product;
    protected $productWithColor;
    protected $productWithSize;
    protected $products;
    protected $colors;
    protected $sizes;

    public function setUp(): void
    {
        parent::setUp();
        $this->getCategory();
    }

    private function loadRequiredData()
    {
        $this->getCategory();
        $this->getSubcategory();
        $this->getBrand();
    }

    public function getCategory()
    {
        if (!isset($this->category)) {
            $this->category = Category::factory()->create([
                'name' => 'Ejemplo de categoría',
                'slug' => Str::slug('Ejemplo de categoría'),
                'icon' => '<i class="fas fa-mobile-alt"></i>'
            ]);
        }
        return $this->category;
    }

    public function getSubcategory()
    {
        $this->getCategory();
        if (!isset($this->subcategory)) {
            $this->subcategory = Subcategory::factory()->create([
                'category_id' => $this->category->id,
                'name' => 'Accesorios para celulares',
                'slug' => Str::slug('Ejemplo de subcategoría'),
            ]);
        }

        if (isset($this->subcategory->size) && $this->subcategory->size == true) {
            $this->subcategory->size = false;
        }
        if (isset($this->subcategory->color) && $this->subcategory->color == true) {
            $this->subcategory->color = false;
        }
        return $this->subcategory;
    }


    public function getSubcategories(int $n = 2)
    {
        $this->getCategory();
        if (!isset($this->subcategories)) {
            $this->subcategories = Subcategory::factory($n)->create([
                'category_id' => $this->category->id,
                'name' => 'Ejemplo de subcategoría',
                'slug' => Str::slug('Ejemplo de subcategoría'),
            ]);
        }
        return $this->subcategories;
    }

    public function getSubCategoryWithColor()
    {
        $this->subCategoryWithColor = $this->getSubcategory();

        if (isset($this->subCategoryWithColor->size) && $this->subCategoryWithColor->size == true) {
            $this->subCategoryWithColor->size = false;
        }
        $this->subCategoryWithColor->color = true;
        $this->subCategoryWithColor->save();

        return $this->subCategoryWithColor;
    }

    public function getSubCategoryWithSize()
    {
        $this->subCategoryWithSize = $this->getSubcategory();

        $this->subCategoryWithSize->size = true;
        $this->subCategoryWithSize->color = true;
        $this->subCategoryWithSize->save();

        return $this->subCategoryWithSize;
    }

    public function getBrand()
    {
        $this->getCategory();
        $this->getSubcategory();
        if (!isset($this->brand)) {
            $this->brand = Brand::factory()->create();
            $this->brand->categories()->attach($this->category->id);
        }
        return $this->brand;
    }

    public function getBrands($n)
    {
        $this->getCategory();
        $this->getSubcategory();

        $this->brands = Brand::factory($n)->create();
        foreach ($this->brands as $brand) {
            $brand->categories()->attach($this->category->id);
        }

        return $this->brands;
    }

    public function getProduct()
    {
        $this->loadRequiredData();

        if (!isset($this->product)) {
            $this->product = Product::factory()->create();
            Image::factory(4)->create([
                'imageable_id' => $this->product->id,
                'imageable_type' => Product::class
            ]);
        }
        return $this->product;
    }

    public function getProductWithColor()
    {

        $this->loadRequiredData();
        $this->getSubCategoryWithColor();
        if (!isset($this->productWithColor)) {
            $this->productWithColor = $this->getProduct();
            $this->newAttributesProduct(['subcategory_id' => $this->subCategoryWithColor->id]);
            $this->productWithColor->save();
        }
        return $this->productWithColor;
    }

    public function getProductWithSize()
    {

        $this->loadRequiredData();
        $this->getSubCategoryWithSize();
        if (!isset($this->productWithSize)) {
            $this->productWithSize = $this->getProduct();
            $this->newAttributesProduct(['subcategory_id' => $this->subCategoryWithSize->id]);
            $this->productWithSize->save();
        }
        return $this->productWithSize;
    }

    public function getProducts(int $n = 2)
    {
        $this->loadRequiredData();

        if (!isset($this->products)) {
            $this->products = Product::factory($n)->create();
            foreach ($this->products as $product) {
                Image::factory(4)->create([
                    'imageable_id' => $product->id,
                    'imageable_type' => Product::class
                ]);
            }
        }
        return $this->products;
    }

    public function newAttributesProduct(array $attributes = [])
    {
        $this->loadRequiredData();

        if (!isset($this->product)) {
            $this->getProduct();
        }

        foreach ($attributes as $key => $value) {
            $this->product->$key = $value;
        }
        $this->product->save();
        return $this->product;
    }

    public function newAttributesProducts(array $attributes = [], $n = 2)
    {
        $this->loadRequiredData();

        if (!isset($this->products)) {
            $this->getProducts($n);
        }

        foreach ($this->products as $product) {
            foreach ($attributes as $key => $value) {
                $product->$key = $value;
            }
            $product->save();
        }
        return $this->products;
    }
    public function addItemToCart($product, $qty = 1, $options = ['color_id' => null, 'size_id' => null])
    {
        Cart::add([
            'id' => $product->id,
            'name' => $product->name,
            'qty' => $qty,
            'price' => $product->price,
            'weight' => 550,
            'options' => $options,
        ]);
    }

    public function getColors()
    {
        if (!isset($this->colors)) {
            $this->colors = collect(); // Inicializa $this->colors como una colección
            $colorsNames = ['white', 'blue', 'red', 'black'];

            foreach ($colorsNames as $colorName) {
                // Utiliza firstOrCreate para evitar duplicados
                $color = Color::firstOrCreate(['name' => $colorName]);
                $this->colors->push($color);
            }
        }

        return $this->colors;
    }

    public function getSizes()
    {
        $this->getProductWithSize();
        $this->getColors();
        if (!isset($this->sizes)) {
            $this->sizes = collect();
            $sizesNames = ['Talla S', 'Talla M', 'Talla L'];

            foreach ($sizesNames as $sizeName) {

                $size = Size::firstOrCreate(['name' => $sizeName], ['product_id' => $this->productWithSize->id]);
                $this->sizes->push($size);
            }
            // $this->colorSize();
        }

        return $this->sizes;
    }


    // private function colorSize(){

    //     $this->getColors();
    //     $this->getSizes();

    //     foreach ($this->sizes as $size) {
    //         // Prepara un array de colores para adjuntar
    //         $colorsToAttach = [];
    //         foreach ($this->colors as $color) {
    //             // Asigna cada color a la talla con una cantidad predefinida
    //             $colorsToAttach[$color->id] = ['quantity' => 10]; // La cantidad es solo un ejemplo
    //         }

    //         // Adjunta los colores a la talla
    //         $size->colors()->attach($colorsToAttach);
    //     }
    // }

}
