<?php

namespace Tests\Feature\Api\Product;

use App\User;
use App\Product;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class DeleteProductTest extends TestCase
{
    /**
     * @var User
     */
    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();

        $this->user->roles()->create(['name' => 'administrator']);
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
