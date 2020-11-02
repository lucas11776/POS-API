<?php

namespace Tests\Feature\Api\Services;

use App\ServicesCategory;
use App\User;
use Tests\TestCase;
use Tests\Tools\Users;

class DeleteServiceCategoryTest extends TestCase
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

    public function testDeleteServiceCategory()
    {
        $category = factory(ServicesCategory::class)->create();

        $this->deleteCategory($category)
            ->assertOk()
            ->assertJsonStructure(['message']);

        $this->assertDatabaseMissing('services_categories', ['name' => $category->name]);
    }

    private function deleteCategory(ServicesCategory $category)
    {
        return $this->json('DELETE', "api/services/categories/{$category->id}", [
            'authorization' => auth('api')->login($this->user)
        ]);
    }
}
