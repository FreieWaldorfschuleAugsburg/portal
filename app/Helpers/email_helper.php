<?php

namespace App\Helpers;

use PHPMailer\PHPMailer\PHPMailer;

function sendAbsenceNotifications(): void
{
    $mailer = createMailer();

    $lastAbsences = getAbsences('-30 minutes');
    $lastAbsencesCount = count($lastAbsences);
    if ($lastAbsencesCount == 0) {
        return;
    }

    if ($lastAbsencesCount > 1) {
        $mailer->Subject = $lastAbsencesCount . ' neue Abwesenheiten';
        $mailer->Body = view('absences/AbsencesEmailPlural', ['count' => $lastAbsencesCount]);
    } else {
        $mailer->Subject = 'Eine neue Abwesenheit';
        $mailer->Body = view('absences/AbsencesEmailSingular');
    }

    foreach (getEmailAddresses() as $address) {
        $mailer->clearAddresses();
        $mailer->addAddress($address);
        $mailer->send();
    }
}

function createMailer(): PHPMailer
{
    $mailer = new PHPMailer();

    $mailer->isSMTP();
    $mailer->Host = getenv('absence.email.host');
    $mailer->SMTPAuth = true;
    $mailer->Username = getenv('absence.email.username');
    $mailer->Password = getenv('absence.email.password');
    $mailer->SMTPSecure = 'tls';
    $mailer->Port = 587;

    $mailer->setFrom(getenv('absence.email.from.address'), getenv('absence.email.from.name'));
    $mailer->isHTML();
    $mailer->CharSet = PHPMailer::CHARSET_UTF8;

    return $mailer;
}

/**
 * @return string[]
 */
function getEmailAddresses(): array
{
    $rawAddresses = getenv('absence.email.addresses');
    return explode(",", $rawAddresses);
}