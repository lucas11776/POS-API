<?php

namespace Tests\Feature\Api\User;

use App\Role;
use App\User;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Http\Response;
use Tests\TestCase;

class AddRoleTest extends TestCase
{
    /**
     * @var User
     */
    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        Role::insert(array_map(function ($item) {
            return ['name' => $item];
        }, Role::ROLES));

        $this->user = factory(User::class)->create();

        $this->user->roles()
            ->attach(Role::where(['name' => 'administrator'])->first());
    }

    public function testAddRole()
    {
        $user = factory(User::class)->create();
        $role = ['name' => 'employee'];

        $this->addRole($user, $role)
            ->assertOk()
            ->assertJsonStructure(['roles']);

        $role = Role::where($role)->firstOrFail();

        $this->assertDatabaseHas('users_roles', ['user_id' => $user->id, 'role_id' => $role->id]);
    }

    public function testAddRoleWithEmptyRole()
    {
        $user = factory(User::class)->create();
        $role = [];

        $this->addRole($user, $role)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['name']);
    }

    public function testAddExistingUserRole()
    {
        $user = factory(User::class)->create();
        $role = ['name' => 'employee'];

        $user->roles()->attach(Role::where($role)->firstOrFail());

        $this->addRole($user, $role)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['name']);
    }

    public function addRole(User $user, array $role): TestResponse
    {
        return $this->json('POST', "api/users/{$user->id}/role", $role, [
           'authorization' => auth('api')->login($this->user)
        ]);
    }
}
