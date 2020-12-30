<?php

namespace Tests\Feature\Api\User;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;
use Tests\Tools\Users;
use function foo\func;

class VerifyEmailAddressTest extends TestCase
{
    protected $user;

    use Users;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = $this->getUser();
    }

    public function testVerifyEmailAndSendEmailVerificationMailToUser()
    {
        Notification::fake();

        $this->verifyEmail()
            ->assertOk()
            ->assertJsonStructure(['message']);

        Notification::assertSentTo($this->user, VerifyEmail::class);
    }

    private function verifyEmail(): TestResponse
    {
        return $this->json('POST', 'api/user/verify/email', [], [
            'authorization' => auth('api')->login($this->user)
        ]);
    }
}
