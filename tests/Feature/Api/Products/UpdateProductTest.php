<?php

namespace Tests\Feature\Api\Products;

use App\ProductsCategory;
use App\User;
use App\Product;
use Faker\Factory;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Http\Response;
use Tests\TestCase;
use Tests\Tools\Users;

class UpdateProductTest extends TestCase
{
    /**
     * @var User
     */
    protected $user;

    /**
     * @var Factory
     */
    protected $faker;

    use Users;

    public function setUp(): void
    {
        parent::setUp();

        $this->faker = Factory::create();

        $this->user = $this->getAdministrator();
    }

    public function testUpdateProduct()
    {
        $product = factory(Product::class)->create();
        $data = [
            'category_id' => factory(ProductsCategory::class)->create()->id,
            'name' => 'Huawei MediaPad T10',
            'price' => 1800,
            'discount' => 1300,
            'in_stock' => 5,
            'barcode' => '8397583903',
            'description' => 'Enjoy your movie and series on a 10inch screen with high quality display.'
        ];

        $this->updateProduct($product, $data)
            ->assertOk()
            ->assertJson($data);

        $this->assertDatabaseHas('products', ['name' => $data['name']]);
    }

    public function testUpdateProductWithEmptyData()
    {
        $product = factory(Product::class)->create();
        $data = [];

        $this->updateProduct($product, $data)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['name', 'price', 'in_stock', 'description']);
    }

    public function testUpdateProductWithInvalidCategoryId()
    {
        $product = factory(Product::class)->create();
        $data = $product->toArray();
        $data['category_id'] = rand(10, 50);

        $this->updateProduct($product, $data)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['category_id']);
    }

    public function testUpdateProductWithShortName()
    {
        $product = factory(Product::class)->create();
        $data = $product->toArray();
        $data['name'] = 'Huaw';

        $this->updateProduct($product, $data)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['name']);
    }

    public function testUpdateProductLongName()
    {
        $product = factory(Product::class)->create();
        $data = $product->toArray();
        $data['name'] = $this->faker->words(51);

        $this->updateProduct($product, $data)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['name']);
    }

    public function testUpdateProductWithNotNumericPrice()
    {
        $product = factory(Product::class)->create();
        $data = $product->toArray();
        $data['price'] = 'R' . $data['price'];

        $this->updateProduct($product, $data)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['price']);
    }

    public function testUpdateProductWithNonNumericDiscount()
    {
        $product = factory(Product::class)->create();
        $data = $product->toArray();
        $data['discount'] = 'R' . ($data['price']/1.5);

        $this->updateProduct($product, $data)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['discount']);
    }

    public function testUpdateProductWithNotNumericInStock()
    {
        $product = factory(Product::class)->create();
        $data = $product->toArray();
        $data['in_stock'] = '25 items';

        $this->updateProduct($product, $data)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['in_stock']);
    }

    public function testUpdateProductWithLongDescription()
    {
        $product = factory(Product::class)->create();
        $data = $product->toArray();
        $data['description'] = $this->faker->sentence(3500);

        $this->updateProduct($product, $data)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['description']);
    }

    private function updateProduct(Product $product, array $data): TestResponse
    {
        return $this->json('PATCH', "api/products/{$product->id}", $data, [
            'authorization' => auth('api')->login($this->user)
        ]);
    }
}
