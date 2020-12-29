<?php

namespace Tests\Feature\Api\User;

use App\User;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Tests\Tools\Users;

class UploadProfilePictureTest extends TestCase
{
    /**
     * @var User
     */
    protected $user;

    use Users;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = $this->getUser();
    }

    public function testUploadProfilePicture()
    {
        Storage::fake(User::PROFILE_PICTURE_STORAGE);

        $form = ['image' => UploadedFile::fake()->create('image.png', 1024 * 2)];

        $this->uploadProfilePicture($form)
            ->assertOk();

        Storage::exists(User::PROFILE_PICTURE_STORAGE . '/' . $form['image']->hashName());
    }

    public function testUploadProfileWithInvalidImage()
    {
        $form = ['image' => UploadedFile::fake()->create('image.gif', 1024 * 2)];

        $this->uploadProfilePicture($form)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['image']);
    }

    public function testUploadProfileWithMaxOutImageSize()
    {
        $form = ['image' => UploadedFile::fake()->create('image.png', 1024 * 4)];

        $this->uploadProfilePicture($form)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['image']);
    }

    private function uploadProfilePicture(array $form): TestResponse
    {
        return $this->json('POST', 'api/user/profile/picture', $form, [
            'authorization' => auth('api')->login($this->user)
        ]);
    }
}
