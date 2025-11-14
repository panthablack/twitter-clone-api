<?php

namespace App\Helpers;

use InvalidArgumentException;

class EmailHelpers
{
    public static function getEmailUsername(string $email): string
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
            throw new InvalidArgumentException("Invalid email address.");
        else return substr($email, 0, strpos($email, '@'));
    }
}
