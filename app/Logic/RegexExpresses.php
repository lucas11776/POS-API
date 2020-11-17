<?php


namespace App\Logic;


class RegexExpresses
{
    public const CELLPHONE_NUMBER = '/\+[0-9]{11,11}/';
    public const PASSWORD = '/(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&])/';
}
