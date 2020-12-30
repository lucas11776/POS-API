<?php


namespace App\Logic\Users;

use App\User;
use App\Country;
use App\Logic\Image;
use App\Logic\Upload;
use App\Logic\Interfaces\UsersInterface;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Http\UploadedFile;

class Users implements UsersInterface
{
    /**
     * @var Upload
     */
    protected $upload;

    /**
     * @var Image
     */
    protected $image;

    public function __construct(Upload $upload, Image $image)
    {
        $this->upload = $upload;
        $this->image = $image;
    }

    public function account(int $id): User
    {
        return User::query()
            ->with(['address', 'image', 'roles'])
            ->where('id', $id)
            ->firstOrFail();
    }

    public function updateAccountDetails(User $user, array $details): User
    {
        foreach (['first_name', 'last_name', 'gender'] as $key)
            $user->{$key} = isset($details[$key]) ? $details[$key] : null;
        $user->save();
        return $this->account($user->getKey());
    }

    public function updateAccountDescription(User $user, array $description): User
    {
        $user->description = $description['description'];
        $user->save();
        return $this->account($user->getKey());
    }

    public function updateAccountAddress(User $user, array $address): User
    {
        if(isset($address['country_id'])) {
            $country =  Country::find($address['country_id']);
            $address['country'] = $country->name;
            $this->updateAccountCountry($user, $country);
        }
        $user->address = $user->address()->updateOrCreate($address);
        return $user;
    }

    public function updateAccountCountry(User $user, Country $country): User
    {
        $user->country_id = $country->id;
        $user->save();
        return $user;
    }

    public function uploadAccountProfilePicture(User $user, UploadedFile $image): User
    {
        $path = $this->upload->upload($image, User::PROFILE_PICTURE_STORAGE);
        $user->image = $this->image->createImage($user->image(), $path);
        return $user;
    }

    public function resetAccountProfilePicture(User $user): User
    {
        $defaultProfilePictureUrl = url(User::DEFAULT_PROFILE_PICTURE);
        if($user->image->url != $defaultProfilePictureUrl)
            $this->image->createImage($user->image(), $defaultProfilePictureUrl);
        return $user->refresh();
    }

    public function verifyAccountEmail(User $user): void
    {
        $user->notify(new VerifyEmail);
    }
}
