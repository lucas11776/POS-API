<?php


namespace App\Logic\Users;

use App\Country;
use App\Logic\Image;
use App\Logic\Upload;
use App\User;
use App\User as UserModel;
use App\Logic\Interfaces\UsersInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

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

    public function account(int $id): UserModel
    {
        return UserModel::with(['address', 'image', 'roles'])
            ->where('id', $id)
            ->firstOrFail();
    }

    public function updateAccountDetails(UserModel $user, array $details): UserModel
    {
        foreach (['first_name', 'last_name', 'gender'] as $key)
            $user->{$key} = isset($details[$key]) ? $details[$key] : null;
        $user->save();
        return $this->account($user->getKey());
    }

    public function updateAccountDescription(UserModel $user, array $description): UserModel
    {
        $user->description = $description['description'];
        $user->save();
        return $this->account($user->getKey());
    }

    public function updateAccountAddress(UserModel $user, array $address): UserModel
    {
        if(isset($address['country_id'])) {
            $country =  Country::find($address['country_id']);
            $address['country'] = $country->name;
            $this->updateAccountCountry($user, $country);
        }
        $user->address = $user->address()->updateOrCreate($address);
        return $user;
    }

    public function updateAccountCountry(UserModel $user, Country $country): User
    {
        $user->country_id = $country->id;
        $user->save();
        return $user;
    }

    public function uploadAccountProfilePicture(UserModel $user, UploadedFile $image): UserModel
    {
        $path = $this->upload->upload($image, User::PROFILE_PICTURE_STORAGE);
        $user->image = $this->image->createImage($user->image(), $path);
        return $user;
    }

    public function resetAccountProfilePicture(User $user): User
    {
        $defaultProfilePictureUrl = url(User::DEFAULT_PROFILE_PICTURE);

        if($user->image->url != User::DEFAULT_PROFILE_PICTURE)
            $user->image()->update(['url' => $defaultProfilePictureUrl, 'path' => null]);
        else
            $this->image->createImage($user->image(), $defaultProfilePictureUrl);

        return $user->refresh();
    }
}
