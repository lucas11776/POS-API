<?php

namespace Tests\Feature\Api\Authentication;

use App\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Http\Response;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    /**
     * @var Factory
     */
    protected $faker;

    public function setUp(): void
    {
        parent::setUp();

        $this->faker = Factory::create();
    }

    public function testRegister()
    {
        $form = [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'gender' => $this->faker->randomElement(User::GENDER),
            'email' => $this->faker->unique()->email,
            'cellphone_number' => $this->faker->e164PhoneNumber,
            'password' => User::DEFAULT_PASSWORD,
            'password_confirmation' => User::DEFAULT_PASSWORD
        ];

        $this->register($form)
            ->assertOk()
            ->assertJsonStructure(['token', 'expire', 'type']);

        $this->assertDatabaseHas('users', ['email' => $form['email']]);
    }

    public function testRegisterWithEmailOnly()
    {
        $form = [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'gender' => $this->faker->randomElement(['male', 'female']),
            'email' => $this->faker->unique()->email,
            'password' => User::DEFAULT_PASSWORD,
            'password_confirmation' => User::DEFAULT_PASSWORD
        ];

        $this->register($form)
            ->assertOk()
            ->assertJsonStructure(['token', 'expire', 'type']);

        $this->assertDatabaseHas('users', ['email' => $form['email']]);
    }

    public function testRegisterWithCellphoneNumberOnly()
    {
        $form = [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'gender' => $this->faker->randomElement(['male', 'female']),
            'cellphone_number' => $this->faker->e164PhoneNumber,
            'password' => User::DEFAULT_PASSWORD,
            'password_confirmation' => User::DEFAULT_PASSWORD
        ];

        $this->register($form)
            ->assertOk()
            ->assertJsonStructure(['token', 'expire', 'type']);

        $this->assertDatabaseHas('users', ['cellphone_number' => $form['cellphone_number']]);
    }

    public function testRegisterWithEmptyForm()
    {
        $this->register([])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors([
                'first_name', 'last_name', 'email', 'cellphone_number', 'password']);
    }

    public function testRegisterWithShortFirstNameAndLastName()
    {
        $form = [
            'first_name' => 'Jo',
            'last_name' => 'Pe',
            'email' => $this->faker->unique()->email,
            'password' => User::DEFAULT_PASSWORD,
            'password_confirmation' => User::DEFAULT_PASSWORD
        ];

        $this->register($form)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['first_name', 'last_name']);
    }

    public function testRegisterWithInvalidGender()
    {
        $form = [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'gender' => 'men',
            'email' => $this->faker->unique()->email,
            'password' => User::DEFAULT_PASSWORD,
            'password_confirmation' => User::DEFAULT_PASSWORD
        ];

        $this->register($form)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['gender']);
    }

    public function testRegisterWithExistingEmailAddress()
    {
        $form = [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->unique()->email,
            'password' => User::DEFAULT_PASSWORD,
            'password_confirmation' => User::DEFAULT_PASSWORD
        ];

        \factory(User::class)->create(['email' => $form['email']]);

        $this->register($form)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['email']);
    }

    public function testRegisterWithInvalidEmailAddress()
    {
        $form = [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->firstName . $this->faker->numberBetween(1, 100) . '.com',
            'password' => User::DEFAULT_PASSWORD,
            'password_confirmation' => User::DEFAULT_PASSWORD
        ];

        $this->register($form)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['email']);
    }

    public function testRegisterWithExistingCellPhoneNumber()
    {
        $form = [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'cellphone_number' => $this->faker->e164PhoneNumber,
            'password' => User::DEFAULT_PASSWORD,
            'password_confirmation' => User::DEFAULT_PASSWORD
        ];

        \factory(User::class)->create(['cellphone_number' => $form['cellphone_number']]);

        $this->register($form)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['cellphone_number']);
    }

    public function testRegisterWithInvalidPassword()
    {
        $form = [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->unique()->email,
            'password' => 'test1234',
            'password_confirmation' => 'test1234'
        ];

        $this->register($form)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['password']);
    }

    public function testRegisterWithNotMatchingPasswordConfirmation()
    {
        $form = [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->unique()->email,
            'password' => User::DEFAULT_PASSWORD,
            'password_confirmation' => 'test1234'
        ];

        $this->register($form)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['password']);
    }

    private function register(array $form): TestResponse
    {
        return $this->json('POST', 'api/auth/register', $form);
    }
}
