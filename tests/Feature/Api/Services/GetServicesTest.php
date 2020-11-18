<?php

namespace Tests\Feature\Api\Services;

use App\Service;
use Illuminate\Foundation\Testing\TestResponse;
use Tests\TestCase;
use Tests\Tools\Params;

class GetServicesTest extends TestCase
{
    use Params;

    public function setUp(): void
    {
        parent::setUp();
        factory(Service::class)->times(5)->create();
    }

    public function testGetServices()
    {
        $totalServices = Service::query()->count();
        $defaultPerPage = 24;

        $this->getServices()
            ->assertOk()
            ->assertJson(['per_page' => $defaultPerPage, 'total' => $totalServices]);
    }

    public function testGetServicesWithLimit()
    {
        $this->getServices(['limit' => 30])
            ->assertOk()
            ->assertJson(['per_page' => 30]);
    }

    public function testGetServicesWithSearch()
    {
        $service = Service::first();

        $this->getServices(['search' => $service->name])
            ->assertOk()
            ->assertJsonCount(1, 'data');
    }

    public function getServices(array $params = []): TestResponse
    {
        return $this->json('GET', 'api/services' . $this->urlParams($params));
    }
}
