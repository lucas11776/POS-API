<?php

namespace Tests\Feature\Api\Users;

use App\Role;
use App\User;
use Illuminate\Http\Response;
use Tests\TestCase;

class RemoveRoleTest extends TestCase
{
    /**
     * @var User
     */
    public $user;

    public function setUp(): void
    {
        parent::setUp();

        Role::insert(array_map(function($item) {
            return ['name' => $item];
        }, Role::ROLES));

        $this->user = factory(User::class)->create();

        $this->user->roles()
            ->attach(Role::where(['name' => 'administrator'])->firstOrFail());
    }

    public function testRemoveRole()
    {
        $user = factory(User::class)->create();
        $role = ['name' => 'administrator'];
        $employeeRole = Role::where($role)->firstOrFail();

        $user->roles()->attach($employeeRole);

        $this->removeRole($user, $role)
            ->assertOk()
            ->assertJsonStructure(array_keys($user->toArray()));

        $this->assertDatabaseMissing('users_roles', [
            'user_id' => $user->id, 'role_id' => $employeeRole->id]);
    }

    public function testRemoveRoleWithEmptyRole()
    {
        $user = factory(User::class)->create();
        $role = [];
        $employeeRole = Role::where($role)->firstOrFail();

        $user->roles()->attach($employeeRole);

        $this->removeRole($user, $role)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['name']);
    }

    public function testRemoveRoleWithUserRoleThatIsNotContainedByUser()
    {
        $user = factory(User::class)->create();
        $role = ['name' => 'employee'];

        $this->removeRole($user, $role)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['name']);
    }

    public function testRemoveRoleWithNonExistingUserRole()
    {
        $user = factory(User::class)->create();
        $role = ['name' => 'manager'];
        $employeeRole = Role::where(['name' => 'employee'])->firstOrFail();

        $user->roles()->attach($employeeRole);

        $this->removeRole($user, $role)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['name']);
    }

    private function removeRole(User $user, array $role)
    {
        return $this->json('DELETE', "api/users/{$user->id}/role", $role, [
           'authorization' => auth('api')->login($this->user)
        ]);
    }
}
