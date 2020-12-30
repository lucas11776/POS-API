<?php

namespace App\Logic\Interfaces;

use App\Role;
use App\User;
use Illuminate\Http\UploadedFile;

interface UserInterface
{
    /**
     * Get user with address and image.
     *
     * @return User
     */
    public function account(): User;

    /**
     * Update user account personal details (first_name, last_name, gender).
     *
     * @param array $personalDetails
     * @return User
     */
    public function updatePersonalDetails(array $personalDetails): User;

    /**
     * Update user description.
     *
     * @param array $description
     * @return User
     */
    public function updateDescription(array $description): User;

    /**
     * Update user address.
     *
     * @param array $address
     * @return User
     */
    public function updateAddress(array $address): User;

    /**
     * Upload user profile picture.
     *
     * @param UploadedFile $image
     * @return User
     */
    public function uploadProfilePicture(UploadedFile $image): User;

    /**
     * Reset user profile picture to default profile picture
     *
     * @return User
     */
    public function resetProfilePicture(): User;

    /**
     * Send email verification link to user email address.
     *
     * @return bool
     */
    public function verifyEmail(): void;
}
