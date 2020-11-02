<?php

namespace Tests\Feature\Api\Products;

use App\User;
use App\Product;
use Illuminate\Foundation\Testing\TestResponse;
use Tests\TestCase;
use Tests\Tools\Users;

class DeleteProductTest extends TestCase
{
    /**
     * @var User
     */
    protected $user;

    use Users;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = $this->getAdministrator();
    }

    public function testDeleteProduct()
    {
        $product = factory(Product::class)->create();

        $this->deleteProduct($product)
            ->assertOk()
            ->assertJsonStructure(['message']);

        $this->assertSoftDeleted($product);
    }

    private function deleteProduct(Product $product): TestResponse
    {
        return $this->json('DELETE', "api/products/{$product->id}", [
            'authorization' => auth('api')->login($this->user)
        ]);
    }
}
