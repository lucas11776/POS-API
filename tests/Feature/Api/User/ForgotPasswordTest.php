<?php

namespace Tests\Feature\Api\User;

use App\PasswordReset;
use Faker\Factory;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;
use Tests\Tools\Users;

class ForgotPasswordTest extends TestCase
{
    use Users;

    public function testSendResetPasswordLink()
    {
        Notification::fake();

        $user = $this->getUser();
        $data = ['email' => $user->email];

        $this->forgotPassword($data)
            ->assertOk()
            ->assertJsonStructure(['message']);

        Notification::assertSentTo($user, ResetPassword::class);

        $this->assertDatabaseHas('password_resets', ['email' => $user->email]);
    }

    public function testSendResetPasswordLinkWithEmptyPassword()
    {
        $data = [];

        $this->forgotPassword($data)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['email']);
    }

    public function testSendResetPasswordWithNonExistingPassword()
    {
        $data = ['email' => Factory::create()->email];

        $this->forgotPassword($data)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['email']);
    }

    private function forgotPassword(array $data): TestResponse
    {
        return $this->json('POST', "api/user/forgot/password", $data);
    }
}
