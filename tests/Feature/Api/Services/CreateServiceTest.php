<?php

namespace Tests\Feature\Api\Services;

use App\Logic\Service;
use App\ProductsCategory;
use App\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Tests\Tools\Users;

class CreateServiceTest extends TestCase
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

    public function testCreateService()
    {
        $service = [
            'category_id' => factory(ProductsCategory::class)->create()->id,
            'image' => UploadedFile::fake()->image('picture.png')->size(1024 * 2),
            'images' => [
                UploadedFile::fake()->image('picture_1.png')->size(1024)->size(1024 * 3),
                UploadedFile::fake()->image('picture_2.png')->size(1024)->size(1024 * 2.5),
                UploadedFile::fake()->image('picture_3.png')->size(1024)->size(1024 * 1.5),
            ],
            'name' => $this->faker->name,
            'price' => $price = $this->faker->numberBetween(200, 3500),
            'discount' => $price / 1.5,
            'description' => $this->faker->words(150, true)
        ];

        $this->createService($service)
            ->assertOk()
            ->assertJsonStructure(array_keys($service));

        $this->assertDatabaseHas('services', ['name' => $service['name']]);

        Storage::assertExists(Service::IMAGE_STORAGE . '/' . $service['image']->hashName());

        foreach ($service['images'] as $image)
            Storage::assertExists(Service::IMAGE_STORAGE . '/' . $image->hashName());
    }

    public function testCreateServiceWithEmptyData()
    {
        $service = [];

        $this->createService($service)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['image', 'name', 'price', 'description']);
    }

    public function testCreateProductWithInvalidCategory()
    {
        $service = [
            'category_id' => $this->faker->numberBetween(10, 50),
            'image' => UploadedFile::fake()->image('picture.png')->size(1024 * 2),
            'name' => $this->faker->name,
            'price' => $price = $this->faker->numberBetween(200, 3500),
            'description' => $this->faker->words(150, true)
        ];

        $this->createService($service)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['category_id']);
    }

    public function testCreateProductWithMaxOutImageSize()
    {
        $service = [
            'image' => UploadedFile::fake()->image('picture.png')->size(1024 * 5),
            'name' => $this->faker->name,
            'price' => $price = $this->faker->numberBetween(200, 3500),
            'description' => $this->faker->words(150, true)
        ];

        $this->createService($service)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['image']);
    }

    public function testCreateProductWithNotAllowedImageType()
    {
        $service = [
            'image' => UploadedFile::fake()->image('picture.git')->size(1024 * 3),
            'name' => $this->faker->name,
            'price' => $price = $this->faker->numberBetween(200, 3500),
            'description' => $this->faker->words(150, true)
        ];

        $this->createService($service)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['image']);
    }

    public function testCreateProductWithMaxOutImageSizeInImages()
    {
        $service = [
            'image' => UploadedFile::fake()->image('picture.png')->size(1024 * 2),
            'images' => [
                UploadedFile::fake()->image('picture_1.png')->size(1024)->size(1024 * 5),
                UploadedFile::fake()->image('picture_2.png')->size(1024)->size(1024 * 2.5),
                UploadedFile::fake()->image('picture_3.png')->size(1024)->size(1024 * 1.5),
            ],
            'name' => $this->faker->name,
            'price' => $price = $this->faker->numberBetween(200, 3500),
            'description' => $this->faker->words(150, true)
        ];

        $this->createService($service)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['images.0']);
    }

    public function testCreateProductWithNotAllowedImageTypeInImages()
    {
        $service = [
            'image' => UploadedFile::fake()->image('picture.git')->size(1024 * 3),
            'images' => [
                UploadedFile::fake()->image('picture_1.git')->size(1024)->size(1024 * 3),
                UploadedFile::fake()->image('picture_2.png')->size(1024)->size(1024 * 2.5),
                UploadedFile::fake()->image('picture_3.png')->size(1024)->size(1024 * 1.5),
            ],
            'name' => $this->faker->name,
            'price' => $price = $this->faker->numberBetween(200, 3500),
            'description' => $this->faker->words(150, true)
        ];

        $this->createService($service)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['images.0']);
    }

    public function testCreateServiceWithShortName()
    {
        $service = [
            'image' => UploadedFile::fake()->image('picture.png')->size(1024 * 2.5),
            'name' => 'T-Sh',
            'price' => $price = $this->faker->numberBetween(200, 3500),
            'description' => $this->faker->words(150, true)
        ];

        $this->createService($service)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['name']);
    }

    public function testCreateServiceWithLongName()
    {
        $service = [
            'image' => UploadedFile::fake()->image('picture.png')->size(1024 * 2.5),
            'name' => $this->faker->words(51, true),
            'price' => $price = $this->faker->numberBetween(200, 3500),
            'description' => $this->faker->words(150, true)
        ];

        $this->createService($service)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['name']);
    }

    public function testCreateServiceWithNonNumericPrice()
    {
        $service = [
            'image' => UploadedFile::fake()->image('picture.png')->size(1024 * 2.5),
            'name' => $this->faker->name,
            'price' => 'R50',
            'description' => $this->faker->words(150, true)
        ];

        $this->createService($service)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['price']);
    }

    public function testCreateServiceWithNonNumericDiscount()
    {
        $service = [
            'image' => UploadedFile::fake()->image('picture.png')->size(1024 * 2.5),
            'name' => $this->faker->name,
            'price' => $price = $this->faker->numberBetween(50, 3500),
            'discount' => 'R' . $price / 1.5,
            'description' => $this->faker->words(150, true)
        ];

        $this->createService($service)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['discount']);
    }

    public function testCreateProductWithLongDescription()
    {
        $service = [
            'image' => UploadedFile::fake()->image('picture.png')->size(1024 * 2.5),
            'name' => $this->faker->name,
            'price' => $price = $this->faker->numberBetween(50, 3500),
            'description' => $this->faker->words(3500, true)
        ];

        $this->createService($service)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['description']);
    }

    private function createService(array $service): TestResponse
    {
        return $this->json('POST', 'api/services', $service, [
            'authorization' => auth('api')->login($this->user)
        ]);
    }
}
