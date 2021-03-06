<?php

namespace Tests\Feature\Api\Services;

use App\Service;
use App\User;
use Illuminate\Foundation\Testing\TestResponse;
use Tests\TestCase;
use Tests\Tools\Users;

class DeleteServiceTest extends TestCase
{
    /**
     * @var User
     */
    protected $user;

    use Users;

    public function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        $this->user = $this->getAdministrator();
    }

    public function testDeleteService()
    {
        $service = factory(Service::class)->create();

        $this->deleteService($service)
            ->assertOk()
            ->assertJsonStructure(['message']);

        $this->assertSoftDeleted($service);
    }

    private function deleteService(Service $service): TestResponse
    {
        return $this->json('DELETE', "api/services/{$service->id}", [
            'authorization' => auth('api')->login($this->user)
        ]);
    }
}
