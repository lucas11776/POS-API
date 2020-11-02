<?php

namespace Tests\Feature\Api\Users;

use App\Role;
use App\User;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Http\Response;
use Tests\TestCase;
use Tests\Tools\Users;

class AddRoleTest extends TestCase
{
    /**
     * @var User
     */
    protected $user;

    use Users;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = $this->getAdministrator();
    }

    public function testAddRole()
    {
        $user = $this->getUser();
        $role = ['name' => 'employee'];

        $this->addRole($user, $role)
            ->assertOk()
            ->assertJsonStructure(['roles']);

        $role = Role::where($role)->firstOrFail();

        $this->assertDatabaseHas('users_roles', ['user_id' => $user->id, 'role_id' => $role->id]);
    }

    public function testAddRoleWithEmptyRole()
    {
        $user = $this->getUser();
        $role = [];

        $this->addRole($user, $role)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['name']);
    }

    public function testAddExistingUserRole()
    {
        $user = $this->getEmployee();
        $role = ['name' => 'employee'];

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
