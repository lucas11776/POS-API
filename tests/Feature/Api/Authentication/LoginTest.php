<?php

namespace Tests\Feature\Api\Authentication;

use App\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Http\Response;
use Tests\TestCase;
use Tests\Tools\Users;

class LoginTest extends TestCase
{
    /**
     * @var Factory
     */
    protected $faker;

    /**
     * @var User
     */
    protected $user;

    use Users;

    public function setUp(): void
    {
        parent::setUp();

        $this->faker = Factory::create();

        $this->user = $this->getUser();
    }

    public function testLoginWithEmailAddress()
    {
        $credentials = [
            'username' => $this->user->email,
            'password' => $this->user::DEFAULT_PASSWORD
        ];

        $this->login($credentials)
            ->assertOk()
            ->assertJsonStructure(['token', 'expire', 'type']);
    }

    public function testLoginWithCellPhoneNumber()
    {
        $credentials = [
            'username' => $this->user->cellphone_number,
            'password' => $this->user::DEFAULT_PASSWORD
        ];

        $this->login($credentials)
            ->assertOk()
            ->assertJsonStructure(['token', 'expire', 'type']);
    }

    public function testLoginWithEmptyCredentials()
    {
        $this->login([])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['username', 'password']);
    }

    public function testLoginWithUsernameThatDoesNotExist()
    {
        $credentials = [
            'username' => $this->faker->unique()->email,
            'password' => $this->user::DEFAULT_PASSWORD
        ];

        $this->login($credentials)
            ->assertUnauthorized()
            ->assertJsonStructure(['message']);
    }

    public function testLoginWithInvalidPassword()
    {
        $credentials = [
            'username' => $this->user->email,
            'password' => 'test@123'
        ];

        $this->login($credentials)
            ->assertUnauthorized()
            ->assertJsonStructure(['message']);
    }

    private function login(array $credentials): TestResponse
    {
        return $this->json('POST', 'api/auth/login', $credentials);
    }
}
