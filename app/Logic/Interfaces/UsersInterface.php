<?php

namespace App\Logic\Interfaces;

use App\Country;
use App\User;
use Illuminate\Http\UploadedFile;

interface UsersInterface
{
    /**
     * Get user account full account including address, image and roles.
     *
     * @param int $id
     * @return User
     */
    public function account(int $id): User;

    /**
     * Update account first_name, last_name and gender.
     *
     * @param User $user
     * @param array $details
     * @return User
     */
    public function updateAccountDetails(User $user, array $details): User;

    /**
     * Update user account description.
     *
     * @param User $user
     * @param array $description
     * @return User
     */
    public  function updateAccountDescription(User $user, array $description): User;

    /**
     * Update user account address.
     *
     * @param User $user
     * @param array $address
     * @return User
     */
    public function updateAccountAddress(User $user, array $address): User;

    /**
     * Update user country address.
     *
     * @param User $user
     * @param Country $country
     * @return User
     */
    public function updateAccountCountry(User $user, Country $country): User;

    /**
     * Change profile picture.
     *
     * @param User $user
     * @param UploadedFile $image
     * @return User
     */
    public function uploadProfilePicture(User $user, UploadedFile $image): User;
}
