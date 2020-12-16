<?php

namespace Tests\Feature\Api\User;

use Illuminate\Foundation\Testing\TestResponse;
use Tests\TestCase;
use Tests\Tools\Users;

class GetProfileTest extends TestCase
{
    protected $user;

    use Users;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = $this->getUser();
    }

    public function testGetProfile(): void
    {
        $this->getProfile()
            ->assertOk()
            ->assertJsonStructure([
                'image', 'first_name', 'last_name', 'gender', 'email', 'cellphone_number', 'address', 'roles']);
    }

    private function getProfile(): TestResponse
    {
        return $this->json('GET', 'api/user', [
            'authorization' => auth('api')->login($this->user)
        ]);
    }
}
