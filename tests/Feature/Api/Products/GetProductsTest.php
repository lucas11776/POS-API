<?php

namespace Tests\Feature\Api\Products;

use App\Product;
use Illuminate\Foundation\Testing\TestResponse;
use Tests\TestCase;
use Tests\Tools\Params;

class GetProductsTest extends TestCase
{
    use Params;

    public function setUp(): void
    {
        parent::setUp();
        factory(Product::class)->times(5)->create();
    }

    public function testGetProducts()
    {
        $totalProducts = Product::query()->count();
        $defaultPerPage = 24;

        $this->getProducts()
            ->assertOk()
            ->assertJson(['per_page' => $defaultPerPage, 'total' => $totalProducts]);
    }

    public function testGetProductsWithLimit()
    {
        $this->getProducts(['limit' => 10])
            ->assertOk()
            ->assertJson(['per_page' => 10]);
    }

    public function testGetProductWithSearch()
    {
        $product = Product::query()->first();

        $this->getProducts(['search' => $product->name])
            ->assertOk()
            ->assertJsonCount(1, 'data');
    }

    private function getProducts(array $params = []): TestResponse
    {
        return $this->json('GET', 'api/products' . $this->urlParams($params));
    }
}
