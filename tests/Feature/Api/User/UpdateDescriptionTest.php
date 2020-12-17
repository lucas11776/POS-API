<?php

namespace Tests\Feature\Api\User;

use App\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;
use Tests\Tools\Users;

class UpdateDescriptionTest extends TestCase
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

    public function testUpdateUserDescription(): void
    {
        $data = ['description' => $this->faker->words(600, true)];

        $this->updateDescription($data)
            ->assertOk()
            ->assertJson($data);
    }

    public function testUpdateDescriptionWithEmptyData(): void
    {
        $this->updateDescription([])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['description']);
    }

    public function testUpdateDescriptionWithLongWords(): void
    {
        $data = ['description' => $this->faker->words(1501, true)];

        $this->updateDescription($data)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['description']);
    }

    protected function updateDescription(array $data): TestResponse
    {
        return $this->json('PATCH', 'api/user/description', $data, [
           'authorization' => auth('api')->login($this->user)
        ]);
    }
}
