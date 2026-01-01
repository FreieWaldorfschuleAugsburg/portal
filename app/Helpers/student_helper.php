<?php

namespace App\Helpers;

use App\Models\InsufficientPasswordException;
use App\Models\InvalidEmailException;
use App\Models\InvalidUsernameException;
use App\Models\LDAPException;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use LdapRecord\LdapRecordException;
use LdapRecord\Models\ActiveDirectory\Group;
use LdapRecord\Models\ActiveDirectory\User;
use LogicException;
use PHPMailer\PHPMailer\Exception;
use UnexpectedValueException;

/**
 * @throws LDAPException
 */
function getStudents(): array
{
    openLDAPConnection();
    $users = User::query()->setBaseDn(getenv('ldap.studentDN'))->get()->toArray();

    usort($users, function ($a, $b) {
        return strcmp($a['sn'][0], $b['sn'][0]);
    });

    return $users;
}