<?php

namespace Tests\Feature\Api\Products;

use App\User;
use App\ProductsCategory;
use Faker\Factory;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Http\Response;
use Tests\TestCase;
use Tests\Tools\Users;

class UpdateProductCategoryTest extends TestCase
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

    public function testUpdateProductCategory()
    {
        $category = factory(ProductsCategory::class)->create();
        $data = ['name' => 'Computers & Laptops'];

        $this->updateProductCategory($category, $data)
            ->assertOk()
            ->assertJson($data);

        $this->assertDatabaseHas('products_categories', $data);
    }

    public function testUpdateProductCategoryWithEmptyData()
    {
        $category = factory(ProductsCategory::class)->create();
        $data = [];

        $this->updateProductCategory($category, $data)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['name']);
    }

    public function testUpdateProductCategoryWithShortName()
    {
        $category = factory(ProductsCategory::class)->create();
        $data = ['name' => 'Phon'];

        $this->updateProductCategory($category, $data)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['name']);
    }

    public function testUpdateProductCategoryWithLongName()
    {
        $category = factory(ProductsCategory::class)->create();
        $data = ['name' => Factory::create()->sentence(50)];

        $this->updateProductCategory($category, $data)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['name']);
    }

    public function testUpdateProductCategoryWithExistingCategoryName()
    {
        $category = factory(ProductsCategory::class)->create();
        $data = ['name' => $category->name];

        $this->updateProductCategory($category, $data)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['name']);
    }

    private function updateProductCategory(ProductsCategory $category, array $data): TestResponse
    {
        return $this->json('PATCH', "api/products/categories/{$category->id}", $data, [
            'authorization' => auth('api')->login($this->user)
        ]);
    }
}
