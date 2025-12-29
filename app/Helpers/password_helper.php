<?php

namespace App\Helpers;

use App\Models\InsufficientPasswordException;
use App\Models\InvalidEmailException;
use App\Models\InvalidUsernameException;
use App\Models\LDAPException;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use LdapRecord\LdapRecordException;
use LdapRecord\Models\ActiveDirectory\User;
use LogicException;
use PHPMailer\PHPMailer\Exception;
use UnexpectedValueException;

/**
 * @throws InvalidEmailException
 * @throws InvalidUsernameException
 * @throws LDAPException
 */
function initPasswordReset(string $username, string $email): void
{
    // Lowercase username for better regex matching
    $username = strtolower($username);

    // Check for valid username
    if (!preg_match("/fwa\d[a-zA-Z]{4}$/", $username)) {
        throw new InvalidUsernameException();
    }

    openLDAPConnection();

    // Check for existing and active user
    $adUser = getADUser($username);
    if (!$adUser || !$adUser->isEnabled()) {
        return;
    }

    // Check for valid email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new InvalidEmailException();
    }

    // Find procurat person
    $personId = findPersonIdByUsername($username);
    if (!$personId) {
        return;
    }

    // Check own private email
    $emailFound = findContactInformationByPersonId($personId, 'private', 'email');
    $person = null;
    if ($emailFound == $email) {
        $person = getProcuratPerson($personId);
    } else {
        // Check contact person email addresses
        $contactPersonIds = getContactPersonIdsByPersonId($personId);
        foreach ($contactPersonIds as $contactPersonId) {
            $emailAddresses = findContactInformationByMediumAndPersonId($contactPersonId, 'email');
            if (in_array($email, $emailAddresses)) {
                $person = getProcuratPerson($contactPersonId);
                break;
            }
        }

        if (!$person) {
            return;
        }
    }

    // Send info to tech contact
    try {
        sendTechMail('[' . $username . '] Passwortzurücksetzung gestartet', 'Passwortzurücksetzung gestartet', "Die Passwortzurücksetzung für den Benutzer <b>$username</b> wurde über die E-Mail-Adresse $email gestartet.");
    } catch (Exception) {
    }

    // Generate JWT for reset link
    $jwtPayload = [
        'username' => $username,
        'exp' => time() + intval(getenv('app.jwtExpirationSeconds')),
    ];
    $jwt = JWT::encode($jwtPayload, getenv('app.jwtSecret'), 'HS256');
    $resetLink = base_url('reset_password') . '?token=' . $jwt;

    // Send info to requester
    try {
        sendMail($email, 'Passwortzurücksetzung', view('mail/PasswordResetRequestMail', ['name' => $person->getFullName(), 'username' => $username, 'link' => $resetLink]));
    } catch (Exception) {
    }
}

/**
 * @throws LDAPException
 * @throws InsufficientPasswordException
 */
function changePassword(string $username, string $newPassword): void
{
    openLDAPConnection();

    $adUser = getADUser($username);
    $adUser->unicodepwd = $newPassword;

    try {
        $adUser->save();
    } catch (LdapRecordException $e) {
        $errorCode = $e->getDetailedError()->getErrorCode();
        if ($errorCode == 53) {
            throw new InsufficientPasswordException();
        }
        throw new LDAPException($errorCode);
    }

    // Send info to tech contact
    try {
        sendTechMail('[' . $username . '] Passwortzurücksetzung erfolgreich', 'Passwortzurücksetzung erfolgreich', "Die Passwortzurücksetzung für den Benutzer <b>$username</b> war erfolgreich.");
    } catch (Exception) {
    }

    // Send info to user
    try {
        sendMail($adUser->mail[0], 'Passwort zurückgesetzt', view('mail/PasswordResetSuccessMail', ['name' => $adUser->displayName[0], 'username' => $username]));
    } catch (Exception) {
    }
}

function decodeToken(string $token): ?object
{
    try {
        return JWT::decode($token, new Key(getenv('app.jwtSecret'), 'HS256'));
    } catch (LogicException|UnexpectedValueException $e) {
        log_message('error', 'Error decoding jwt: ' . $e->getMessage());
        return null;
    }
}

/**
 * @param string $username
 * @return ?User
 */
function getADUser(string $username): ?object
{
    return User::query()->findBy('sAMAccountName', $username);
}