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
     * Upload user account profile picture.
     *
     * @param User $user
     * @param UploadedFile $image
     * @return User
     */
    public function uploadAccountProfilePicture(User $user, UploadedFile $image): User;

    /**
     * Changes account profile picture to default profile picture.
     *
     * @param User $user
     * @return User
     */
    public function resetAccountProfilePicture(User $user): User;

    /**
     * Send email verification mail to account email address.
     *
     * @param User $user
     * @return bool
     */
    public function verifyAccountEmail(User $user): void;
}
