<?php

namespace Tests\Feature\Api\Products;

use App\Product;
use Illuminate\Foundation\Testing\TestResponse;
use Tests\TestCase;

class GetAllProductsTest extends TestCase
{
    public function testGetAllProducts()
    {
        factory(Product::class)->times(5)->create();

        $products = Product::query()
            ->orderBy('name', 'ASC')
            ->get();

        $this->getAllProducts()
            ->assertOk()
            ->assertJson($products->toArray());
    }

    private function getAllProducts(): TestResponse
    {
        return $this->json('GET', 'api/products/all');
    }
}
