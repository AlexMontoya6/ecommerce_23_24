<?php

namespace Tests\Feature\Semana2;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\DataHelper;
use Tests\TestCase;
use Tests\TestCaseWithSetup;

class ProductDetailViewTest extends TestCase
{
    use RefreshDatabase, DataHelper;
    public function test_user_can_access_product_detail_view()
    {

        $this->getProduct();

        $response = $this->get(route('products.show', $this->product));

        $response->assertStatus(200);


    }
}
