<?php

namespace App\Helpers;

use App\Models\InvalidEmailException;
use App\Models\InvalidUsernameException;
use Firebase\JWT\JWT;
use PHPMailer\PHPMailer\Exception;

/**
 * @throws InvalidEmailException
 * @throws InvalidUsernameException
 */
function initPasswordReset(string $username, string $email): void
{
    // Lowercase username for better regex matching
    $username = strtolower($username);

    // Check for valid username
    if (!preg_match("/fwa\d[a-zA-Z]{4}$/", $username)) {
        throw new InvalidUsernameException();
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
    if ($emailFound != $email) {
        // Check contact person email addresses
        $contactPersonIds = getContactPersonIdsByPersonId($personId);
        $match = false;
        foreach ($contactPersonIds as $contactPersonId) {
            $emailAddresses = findContactInformationByMediumAndPersonId($contactPersonId, 'email');
            if (in_array($email, $emailAddresses)) {
                $match = true;
            }
        }

        if (!$match) {
            return;
        }
    }

    // Send info to tech contact
    try {
        sendTechMail('[' . $username . '] Passwortzurücksetzung gestartet', 'Passwortzurücksetzung gestartet', "Die Passwortzurücksetzung für den Benutzername $username wurde über die E-Mail-Adresse $email gestartet.");
    } catch (Exception) {
    }

    // Generate JWT for reset link
    $jwtPayload = [
        'username' => $username
    ];
    $jwt = JWT::encode($jwtPayload, getenv('app.jwtSecret'), 'HS256');
    $resetLink = base_url('reset_password/reset') . '?token=' . $jwt;

    // Send info to email
    try {
        sendMail($email, 'Passwortzurücksetzung', view('mail/PasswordResetMail', ['name' => '', 'username' => $username, 'link' => $resetLink]));
    } catch (Exception) {
    }
}