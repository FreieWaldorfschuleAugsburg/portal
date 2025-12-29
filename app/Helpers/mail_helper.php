<?php

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

/**
 * @throws Exception
 */
function sendMail(string $to, string $subject, string $message): void
{
    $mailer = createMailer();
    $mailer->addAddress($to);
    $mailer->Subject = $subject;
    $mailer->Body = $message;
    $mailer->send();
}

/**
 * @throws Exception
 */
function sendTechMail(string $subject, string $headline, string $message): void
{
    sendMail(getenv('mail.techContact'), $subject, view('mail/GenericTechMail', ['headline' => $headline, 'message' => $message]));
}

/**
 * Create a new mailer instance.
 *
 * @return PHPMailer
 * @throws Exception
 */
function createMailer(): PHPMailer
{
    $mailer = new PHPMailer();

    $mailer->isSMTP();
    $mailer->Host = getenv('mail.host');
    $mailer->SMTPAuth = true;
    $mailer->Username = getenv('mail.username');
    $mailer->Password = getenv('mail.password');
    $mailer->SMTPSecure = 'tls';
    $mailer->Port = 587;

    $mailer->setFrom(getenv('mail.from.address'), getenv('mail.from.name'));
    $mailer->isHTML();
    $mailer->CharSet = PHPMailer::CHARSET_UTF8;

    return $mailer;
}