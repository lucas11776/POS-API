<?php


namespace App\Logic;


class RegexExpresses
{
    public const CELLPHONE_NUMBER = '/\+[0-9]{12,12}/';
    public const PASSWORD = '/(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&])/';
}
