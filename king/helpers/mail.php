<?php

error_reporting(0);

use PHPMailer\PHPMailer\PHPMailer;

require __DIR__.'/PHPMailer/PHPMailer/src/Exception.php';
require __DIR__.'/PHPMailer/PHPMailer/src/PHPMailer.php';
require __DIR__.'/PHPMailer/PHPMailer/src/SMTP.php';

$config = require __DIR__.'/../config/config.php';

function setupMailer()
{
    global $config;
    $mailer = new PHPMailer();

    if ($config['SMTP_HOST']) {
        $mailer = setupSMTP($mailer, $config);
    }
    $mailer->setFrom($config['MAIL_SENDER_ADDRESS']);
    foreach ($config['admin_emails'] as  $email) {
        $mailer->addAddress($email);
    }

    return $mailer;
}

function setupSMTP(PHPMailer $mailer, array $config)
{
    $mailer->isSMTP();
    $mailer->Host = $config['SMTP_HOST'];
    $mailer->SMTPAuth = true;
    $mailer->Username = $config['SMTP_USERNAME'];
    $mailer->Password = $config['SMTP_PASSWORD'];
    $port = $config['SMTP_PORT'];
    $mailer->SMTPSecure = $port == 587 ? PHPMailer::ENCRYPTION_STARTTLS : PHPMailer::ENCRYPTION_SMTPS;
    $mailer->Port = $port;

    return $mailer;
}

function dispatch(string $subject, string $message)
{
    $mailer = setupMailer();
    $mailer->Subject = $subject;
    $mailer->Body = $message;

    $mailer->send();
}
