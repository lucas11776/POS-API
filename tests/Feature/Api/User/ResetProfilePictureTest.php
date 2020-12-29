<?php

namespace Tests\Feature\Api\User;

use App\Logic\Image;
use App\User;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Tests\Tools\Users;

class ResetProfilePictureTest extends TestCase
{
    /**
     * @var User
     */
    protected $user;

    /**
     * @var Image
     */
    protected $image;

    use Users;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = $this->getUser();
        $this->image = new Image();
    }

    public function testResetProfilePicture(): void
    {
        $uploadedProfilePicturePath = UploadedFile::fake()
            ->create('image.png')
            ->storePublicly(User::PROFILE_PICTURE_STORAGE);

        $this->image->updateImage($this->user->image, Storage::url($uploadedProfilePicturePath));

        $this->resetProfilePicture()
            ->assertOk()
            ->assertJson(['image' => ['url' => url(User::DEFAULT_PROFILE_PICTURE), 'path' => null]]);
    }

    public function resetProfilePicture(): TestResponse
    {
        return $this->json('DELETE', 'api/user/profile/picture', [
            'authorization' => auth('api')->login($this->user)
        ]);
    }
}
