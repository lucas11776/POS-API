<?php

namespace Tests\Feature\Api\Products;

use App\ProductsCategory;
use Illuminate\Foundation\Testing\TestResponse;
use Tests\TestCase;

class GetProductsCategoriesTest extends TestCase
{
    public function testGetProductCategories()
    {
        factory(ProductsCategory::class)->times(10)->create();

        $productsCategories = ProductsCategory::query()
            ->orderBy('name', 'ASC')
            ->get();

        $this->getCategories()
            ->assertOk()
            ->assertJson($productsCategories->toArray());
    }

    private function getCategories(): TestResponse
    {
        return $this->json('GET', 'api/products/categories');
    }
}
