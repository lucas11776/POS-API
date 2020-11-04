<?php

namespace Tests\Feature\Api\Services;

use App\Service;
use App\ServicesCategory;
use App\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Http\Response;
use Tests\TestCase;
use Tests\Tools\Users;

class UpdateServiceTest extends TestCase
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

    public function testUpdateService()
    {
        $service = factory(Service::class)->create();
        $data = [
            'category_id' => factory(ServicesCategory::class)->create()->id,
            'name' => 'T-Shirt (Printing)',
            'price' => 100,
            'discount' => 80,
            'description' => $this->faker->words(150, true)
        ];

        $this->updateService($service, $data)
            ->assertOk()
            ->assertJson($data);
    }

    public function testUpdateServiceWithEmptyData()
    {
        $service = factory(Service::class)->create();
        $data = [];

        $this->updateService($service, $data)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['name', 'price', 'description']);
    }

    public function testUpdateServiceWithInvalidCategory()
    {
        $service = factory(Service::class)->create();
        $data = [
            'category_id' => rand(10, 50),
            'name' => 'T-Shirt (Printing)',
            'price' => 100,
            'description' => $this->faker->words(150, true)
        ];

        $this->updateService($service, $data)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['category_id']);
    }

    public function testUpdateServiceWithShortName()
    {
        $service = factory(Service::class)->create();
        $data = [
            'name' => 'T-Sh',
            'price' => 100,
            'description' => $this->faker->words(150, true)
        ];

        $this->updateService($service, $data)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['name']);
    }

    public function testUpdateServiceWithLongName()
    {
        $service = factory(Service::class)->create();
        $data = [
            'name' => $this->faker->words(51, true),
            'price' => 100,
            'description' => $this->faker->words(150, true)
        ];

        $this->updateService($service, $data)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['name']);
    }

    public function testUpdateServiceWithNonNumericPrice()
    {
        $service = factory(Service::class)->create();
        $data = [
            'name' => 'T-shirt (Printing)',
            'price' => 'R100',
            'description' => $this->faker->words(150, true)
        ];

        $this->updateService($service, $data)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['price']);
    }

    public function testUpdateServiceWithNonNumericDiscount()
    {
        $service = factory(Service::class)->create();
        $data = [
            'name' => 'T-shirt (Printing)',
            'price' => 100,
            'discount' => 'R80',
            'description' => $this->faker->words(150, true)
        ];

        $this->updateService($service, $data)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['discount']);
    }

    public function testUpdateServiceWithLongDescription()
    {
        $service = factory(Service::class)->create();
        $data = [
            'name' => 'T-shirt (Printing)',
            'price' => 100,
            'description' => $this->faker->words(3500, true)
        ];

        $this->updateService($service, $data)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['description']);
    }

    private function updateService(Service $service, array $data): TestResponse
    {
        return $this->json('PATCH', "api/services/{$service->id}", $data, [
            'authorization' => auth('api')->login($this->user)
        ]);
    }
}
