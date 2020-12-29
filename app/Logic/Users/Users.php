<?php


namespace App\Logic\Users;

use App\Country;
use App\User;
use App\User as UserModel;
use App\Logic\Interfaces\UsersInterface;

class Users implements UsersInterface
{
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
            $country = $this->getCountry($address['country_id']);
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

    /**
     * Get country by id.
     *
     * @param int $id
     * @return Country
     */
    private function getCountry(int $id): Country
    {
        return Country::find($id);
    }
}
