<?php

namespace Tests\Feature\Api\Services;

use App\ServicesCategory;
use App\User;
use Faker\Factory;
use Illuminate\Http\Response;
use Tests\TestCase;
use Tests\Tools\Users;

class CreateServiceCategoryTest extends TestCase
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

    public function testCreateServiceCategory()
    {
        $category = ['name' => 'Printout'];

        $this->createCategory($category)
            ->assertOk()
            ->assertJsonStructure(['name', 'url']);
    }

    public function testCreateServiceCategoryWithEmptyData()
    {
        $category = [];

        $this->createCategory($category)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['name']);
    }

    public function testCreateServiceCategoryWithShortName()
    {
        $category = ['name' => 'Prin'];

        $this->createCategory($category)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['name']);
    }

    public function testCreateServiceCategoryWithLongName()
    {
        $category = ['name' => Factory::create()->words(51, true)];

        $this->createCategory($category)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['name']);
    }

    public function testCreateServiceCategoryWithExistingServiceCategory()
    {
        $category = ['name' => 'Printout'];

        factory(ServicesCategory::class)->create($category);

        $this->createCategory($category)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['name']);

    }

    private function createCategory(array $category)
    {
        return $this->json('POST', 'api/services/categories', $category, [
            'authorization' => auth('api')->login($this->user)
        ]);
    }
}
