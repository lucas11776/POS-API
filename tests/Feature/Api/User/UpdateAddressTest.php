<?php

namespace Tests\Feature\Api\User;

use App\Country;
use App\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Tests\TestCase;
use Tests\Tools\Users;

class UpdateAddressTest extends TestCase
{
    /**
     * @var User
     */
    protected $user;

    /**
     * @var Factory
     */
    protected $faker;

    /**
     * @var Collection
     */
    protected $countries;

    use Users;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = $this->getUser();
        $this->faker = Factory::create();
    }

    public function testUpdateAddress(): void
    {
        $form = [
            'address' => $this->faker->address,
            'country_id' => ($country = factory(Country::class)->create())->id,
            'city' => $this->faker->city,
            'postal_code' => $this->faker->numberBetween(1000, 13953568)
        ];

        $this->updateAddress($form)
            ->assertOk()
            ->assertJson([
                'country_id' => $form['country_id'],
                'address' => [
                    'address' => $form['address'],
                    'city' => $form['city'],
                    'country' => $country->name,
                    'postal_code' => $form['postal_code']
                ]]);
    }

    public function testUpdateAddressWithEmptyData()
    {
        $this->updateAddress([])
            ->assertOk();
    }

    public function testUpdateAddressWithShortAddress()
    {
        $form = ['address' => '2035'];

        $this->updateAddress($form)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['address']);
    }

    public function testUpdateAddressWithLongName()
    {
        $form = ['address' => $this->faker->words(101, true)];

        $this->updateAddress($form)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['address']);
    }

    public function testUpdateAddressWithInvalidCountryId()
    {
        $form = ['country_id' => rand(10, 100)];

        $this->updateAddress($form)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['country_id']);
    }

    public function testUpdateAddressWithShortCityName()
    {
        $form = ['city' => 'Jo',];

        $this->updateAddress($form)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['city']);
    }

    public function testUpdateAddressWithLongCityName()
    {
        $form = ['city' => $this->faker->words(51, true),];

        $this->updateAddress($form)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['city']);
    }

    public function testUpdateAddressWithPostalCodeThatIsNotNumeric()
    {
        $form = ['postal_code' => '1203 A'];

        $this->updateAddress($form)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['postal_code']);
    }

    public function testUpdateAddressWithShortPostalCode()
    {
        $form = ['postal_code' => '122'];

        $this->updateAddress($form)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['postal_code']);
    }

    public function testUpdateAddressWithLongPostalCode()
    {
        $form = ['postal_code' => '92058930185'];

        $this->updateAddress($form)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['postal_code']);
    }

    private function updateAddress(array $form): TestResponse
    {
        return $this->json('PATCH', 'api/user/address', $form, [
            'authorization' => auth('api')->login($this->user)
        ]);
    }
}
