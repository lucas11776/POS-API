<?php

namespace Tests\Feature\Api\Authentication;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\Tools\Users;

class LogoutTest extends TestCase
{
    /**
     * @var User
     */
    protected $user;

    use Users;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = $this->getUser();
    }

    public function testLogout()
    {
        $this->logout()
            ->assertOk()
            ->assertJsonStructure(['message']);
    }

    private function logout(): TestResponse
    {
        return $this->json('POST', 'api/auth/logout', [
            'authorization' => auth('api')->login($this->user)
        ]);
    }
}
