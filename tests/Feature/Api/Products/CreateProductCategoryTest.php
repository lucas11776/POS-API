<?php

namespace Tests\Feature\Api\Products;

use App\User;
use App\ProductsCategory;
use Faker\Factory;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Tests\TestCase;

class CreateProductCategoryTest extends TestCase
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

    public function testCreateProductCategory()
    {
        $category = ['name' => 'Smartphone & Tablets'];

        $this->createProductCategory($category)
            ->assertOk()
            ->assertJson($category);

        $this->assertDatabaseHas('products_categories', $category);
    }

    public function testCreateProductCategoryWithEmptyCategory()
    {
        $category = [];

        $this->createProductCategory($category)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['name']);
    }

    public function testCreateProductCategoryWithExistingCategory()
    {
        $category = ['name' => 'Computers & Laptops'];

        ProductsCategory::create(array_merge($category, ['url' => Str::slug($category['name'])]));

        $this->createProductCategory($category)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['name']);
    }

    public function testCreateProductCategoryWithShortCategoryName()
    {
        $category = ['name' => 'Phon'];

        $this->createProductCategory($category)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['name']);
    }

    public function testCreateProductCategoryWithLongCategoryName()
    {
        $category = ['name' => Factory::create()->sentence(50)];

        $this->createProductCategory($category)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['name']);
    }

    private function createProductCategory(array $category): TestResponse
    {
        return $this->json('POST', 'api/products/categories', $category, [
            'authorization' => auth('api')->login($this->user)
        ]);
    }
}
