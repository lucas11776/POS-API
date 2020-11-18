<?php

namespace Tests\Feature\Api\Services;

use App\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetAllServicesTest extends TestCase
{
    public function testGetAllServices()
    {
        factory(Service::class)->times(5)->create();

        $services = Service::query()
            ->orderBy('name', 'ASC')
            ->get();

        $this->getAllServices()
            ->assertOk()
            ->assertJson($services->toArray());
    }

    private function getAllServices(): TestResponse
    {
        return $this->json('GET', 'api/services/all');
    }
}
