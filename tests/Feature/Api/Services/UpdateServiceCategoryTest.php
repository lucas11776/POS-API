<?php

namespace Tests\Feature\Api\Services;

use App\ServicesCategory;
use App\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Http\Response;
use Tests\TestCase;
use Tests\Tools\Users;

class UpdateServiceCategoryTest extends TestCase
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

    public function testUpdateServiceCategory()
    {
        $category = factory(ServicesCategory::class)->create();
        $data = ['name' => 'Printout'];

        $this->updateCategory($category, $data)
            ->assertOk()
            ->assertJson($data)
            ->assertJsonStructure(['name', 'url']);

        $this->assertDatabaseHas('services_categories', $data);
    }

    public function testUpdateProductCategoryWithEmptyData()
    {
        $category = factory(ServicesCategory::class)->create();
        $data = [];

        $this->updateCategory($category, $data)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['name']);
    }

    public function testCreateServiceCategoryWithShortName()
    {
        $category = factory(ServicesCategory::class)->create();
        $data = ['name' => 'Prin'];

        $this->updateCategory($category, $data)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['name']);
    }

    public function testCreateServiceCategoryWithLongName()
    {
        $category = factory(ServicesCategory::class)->create();
        $data = ['name' => Factory::create()->words(51, true)];

        $this->updateCategory($category, $data)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['name']);
    }

    public function testCreateServiceCategoryWithExistingServiceCategory()
    {
        $category = factory(ServicesCategory::class)->create();
        $data = ['name' => 'Printout'];

        factory(ServicesCategory::class)->create($data);

        $this->updateCategory($category, $data)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['name']);

    }

    private function updateCategory(ServicesCategory $category, array $data): TestResponse
    {
        return $this->json('PATCH', "api/services/categories/{$category->id}", $data, [
            'authorization' => auth('api')->login($this->user)
        ]);
    }
}
