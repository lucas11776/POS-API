<?php

namespace Tests\Feature\Api\Products;

use App\User;
use Faker\Factory;
use App\Logic\Products\Product;
use App\ProductsCategory;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Tests\TestCase;
use Tests\Tools\Users;

class CreateProductTest extends TestCase
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

    public function testCreateProduct()
    {
        Storage::fake(Product::IMAGE_STORAGE);

        $category = factory(ProductsCategory::class)->create([
            'name' => 'Cellphone & Tablets',
            'url' => Str::slug('Cellphone & Tablets')
        ]);
        $product = [
            'category_id' => $category->id,
            'image' => UploadedFile::fake()->image('picture.png')->size(1024),
            'images' => [
                UploadedFile::fake()->image('picture_1.png')->size(1024 * 2),
                UploadedFile::fake()->image('picture_2.png')->size(1024 * 1),
                UploadedFile::fake()->image('picture_3.png')->size(1024 * 3)
            ],
            'name' => 'Huawei MediaPad 7',
            'price' => $this->faker->numberBetween(1800, 2200),
            'discount' => $this->faker->numberBetween(1200, 1600),
            'in_stock' => $this->faker->numberBetween(3, 20),
            'barcode' => '6004931010446',
            'description' => $this->faker->sentence(150)
        ];

        $this->createProduct($product)
            ->assertOk()
            ->assertJsonStructure(array_keys($product));

        $this->assertDatabaseHas('products', ['name' => $product['name']]);

        Storage::assertExists(Product::IMAGE_STORAGE . '/' . $product['image']->hashName());

        foreach ($product['images'] as $image)
            Storage::assertExists(Product::IMAGE_STORAGE . '/' . $image->hashName());

    }

    public function testCreateProductWithEmptyData()
    {
        $product = [];

        $this->createProduct($product)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['image', 'name', 'price', 'in_stock', 'description']);
    }

    public function testCreateProductWithInvalidProductCategory()
    {
        $product = [
            'category_id' => rand(10, 50),
            'image' => UploadedFile::fake()->image('picture.png')->size(1024 * 4),
            'name' => 'Huawei MediaPad 7',
            'price' => $this->faker->numberBetween(1800, 2200),
            'in_stock' => $this->faker->numberBetween(3, 20),
            'description' => $this->faker->sentence(150)
        ];

        $this->createProduct($product)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['category_id']);
    }

    public function testCreateProductWithMaximumImageSize()
    {
        $product = [
            'image' => UploadedFile::fake()->image('picture.png')->size(1024 * 4),
            'name' => 'Huawei MediaPad 7',
            'price' => $this->faker->numberBetween(1800, 2200),
            'discount' => $this->faker->numberBetween(1200, 1600),
            'in_stock' => $this->faker->numberBetween(3, 20),
            'description' => $this->faker->sentence(150)
        ];

        $this->createProduct($product)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['image']);
    }

    public function testCreateProductInvalidImageType()
    {
        $product = [
            'image' => UploadedFile::fake()->image('picture.gif')->size(1024 * 2),
            'name' => 'Huawei MediaPad 7',
            'price' => $this->faker->numberBetween(1800, 2200),
            'in_stock' => $this->faker->numberBetween(3, 20),
            'description' => $this->faker->sentence(150)
        ];

        $this->createProduct($product)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['image']);
    }

    public function testCreateProductWithOneMaximumImageSizeInImages()
    {
        $product = [
            'image' => UploadedFile::fake()->image('picture.png')->size(1024),
            'images' => [
                UploadedFile::fake()->image('picture_3.png')->size(1024 * 4),
                UploadedFile::fake()->image('picture_1.png')->size(1024 * 2),
                UploadedFile::fake()->image('picture_2.png')->size(1024 * 1)
            ],
            'name' => 'Huawei MediaPad 7',
            'price' => $this->faker->numberBetween(1800, 2200),
            'in_stock' => $this->faker->numberBetween(3, 20),
            'description' => $this->faker->sentence(150)
        ];

        $this->createProduct($product)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['images.0']);
    }

    public function testCreateProductWithShortProductName()
    {
        $product = [
            'image' => UploadedFile::fake()->image('picture.png')->size(1024),
            'name' => 'Huaw',
            'price' => $this->faker->numberBetween(1800, 2200),
            'in_stock' => $this->faker->numberBetween(3, 20),
            'description' => $this->faker->sentence(150)
        ];

        $this->createProduct($product)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['name']);
    }

    public function testCreateProductWithLongProductName()
    {
        $product = [
            'image' => UploadedFile::fake()->image('picture.png')->size(1024),
            'name' => $this->faker->words(51),
            'price' => $this->faker->numberBetween(1800, 2200),
            'in_stock' => $this->faker->numberBetween(3, 20),
            'description' => $this->faker->sentence(150)
        ];

        $this->createProduct($product)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['name']);
    }

    public function testCreateProductWithPriceThatIsNotNumeric()
    {
        $product = [
            'image' => UploadedFile::fake()->image('picture.png')->size(1024),
            'name' => 'Huawei MediaPad 7',
            'price' => 'R2000',
            'in_stock' => $this->faker->numberBetween(3, 20),
            'description' => $this->faker->sentence(150)
        ];

        $this->createProduct($product)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['price']);
    }

    public function testCreateProductWithDiscountThatIsNotNumeric()
    {
        $product = [
            'image' => UploadedFile::fake()->image('picture.png')->size(1024),
            'name' => 'Huawei MediaPad 7',
            'price' => $this->faker->numberBetween(1800, 2200),
            'discount' => 'R1500',
            'in_stock' => $this->faker->numberBetween(3, 20),
            'description' => $this->faker->sentence(150)
        ];

        $this->createProduct($product)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['discount']);
    }

    public function testCreateProductWithInStockThatIsNotNumeric()
    {
        $product = [
            'image' => UploadedFile::fake()->image('picture.png')->size(1024),
            'name' => 'Huawei MediaPad 7',
            'price' => $this->faker->numberBetween(1800, 2200),
            'in_stock' => '10 items',
            'description' => $this->faker->sentence(150)
        ];

        $this->createProduct($product)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['in_stock']);
    }

    public function testCreateProductWithBarcodeThatIsNotNumeric()
    {
        $product = [
            'image' => UploadedFile::fake()->image('picture.png')->size(1024),
            'name' => 'Huawei MediaPad 7',
            'price' => $this->faker->numberBetween(1800, 2200),
            'discount' => $this->faker->numberBetween(1200, 1600),
            'in_stock' => $this->faker->numberBetween(3, 20),
            'barcode' => '6004931010446b',
            'description' => $this->faker->sentence(150)
        ];

        $this->createProduct($product)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['barcode']);
    }

    public function testCreateProductWithLongDescription()
    {
        $product = [
            'image' => UploadedFile::fake()->image('picture.png')->size(1024),
            'name' => 'Huawei MediaPad 7',
            'price' => $this->faker->numberBetween(1800, 2200),
            'discount' => $this->faker->numberBetween(1200, 1600),
            'in_stock' => $this->faker->numberBetween(3, 20),
            'description' => $this->faker->sentence(3800)
        ];

        $this->createProduct($product)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['description']);
    }

    private function createProduct(array $product): TestResponse
    {
        return $this->json('POST', 'api/products', $product, [
            'authorization' => auth('api')->login($this->user)
        ]);
    }
}
