<?php

namespace Tests\Feature\Api\Products;

use App\ProductsCategory;
use App\User;
use Illuminate\Foundation\Testing\TestResponse;
use Tests\TestCase;
use Tests\Tools\Users;

class DeleteProductCategoryTest extends TestCase
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

    public function testDeleteProductCategory()
    {
        $category = factory(ProductsCategory::class)->create();

        $this->deleteProductCategory($category)
            ->assertOk()
            ->assertJsonStructure(['message']);

        $this->assertDatabaseMissing('products_categories', ['name' => $category->name]);
    }

    private function deleteProductCategory(ProductsCategory $category): TestResponse
    {
        return $this->json('DELETE', "api/products/categories/{$category->id}", [
            'authorization' => auth('api')->login($this->user)
        ]);
    }
}
