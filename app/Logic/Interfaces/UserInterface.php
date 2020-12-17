<?php

namespace App\Logic\Interfaces;

use App\Role;
use App\User;

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
}
