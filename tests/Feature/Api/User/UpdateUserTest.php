<?php

namespace Tests\Feature\Api\User;

use App\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Http\Response;
use Tests\TestCase;
use Tests\Tools\Users;

class UpdateUserTest extends TestCase
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

        $this->user = $this->getUser();
        $this->faker = Factory::create();
    }

    public function testUpdateUserDetails(): void
    {
        $form = [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'gender' => $this->faker->randomElement(User::GENDER)
        ];

        $this->updateUser($form)
            ->assertOk()
            ->assertJson($form);
    }

    public function testUpdateUserDetailsWithEmptyData(): void
    {
        $this->updateUser([])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['first_name', 'last_name']);
    }

    public function testUpdateUserDetailsWithShortFirstName(): void
    {
        $form = [
            'first_name' => 'Jo',
            'last_name' => $this->faker->lastName,
            'gender' => $this->faker->randomElement(User::GENDER)
        ];

        $this->updateUser($form)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['first_name']);
    }

    public function testUpdateUserDetailsWithLongFirstName(): void
    {
        $form = [
            'first_name' => $this->faker->words(51, true),
            'last_name' => $this->faker->lastName,
            'gender' => $this->faker->randomElement(User::GENDER)
        ];

        $this->updateUser($form)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['first_name']);
    }

    public function testUpdateUserDetailsWithShortLastName(): void
    {
        $form = [
            'first_name' => $this->faker->lastName,
            'last_name' => 'El',
            'gender' => $this->faker->randomElement(User::GENDER)
        ];

        $this->updateUser($form)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['last_name']);
    }

    public function testUpdateUserDetailsWithLongLastName(): void
    {
        $form = [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->words(51, true),
            'gender' => $this->faker->randomElement(User::GENDER)
        ];

        $this->updateUser($form)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['last_name']);
    }

    public function testUpdateUserDetailsWithInvalidGender(): void
    {
        $form = [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'gender' => 'bird'
        ];

        $this->updateUser($form)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['gender']);
    }

    private function updateUser(array $form): TestResponse
    {
        return $this->json('PATCH', 'api/user', $form, [
            'authorization' => auth('api')->login($this->user)
        ]);
    }
}
