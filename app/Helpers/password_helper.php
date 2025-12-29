<?php

namespace App\Helpers;

use App\Models\InvalidEmailException;
use App\Models\InvalidUsernameException;

/**
 * @throws InvalidEmailException
 * @throws InvalidUsernameException
 */
function initPasswordReset(string $username, string $email): void
{
    $username = strtolower($username);

    if (!preg_match("/fwa\d[a-zA-Z]{4}$/", $username)) {
        throw new InvalidUsernameException();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new InvalidEmailException();
    }
}