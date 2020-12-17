<?php

namespace App\Logic\Interfaces;

use App\User;

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
     * @param array $accountDetails
     * @return User
     */
    public function updateAccountDetails(User $user, array $accountDetails): User;

    /**
     * Update user account description.
     *
     * @param User $user
     * @param array $accountDescription
     * @return User
     */
    public  function updateAccountDescription(User $user, array $accountDescription): User;
}
