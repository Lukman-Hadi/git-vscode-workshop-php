<?php
declare(strict_types=1);
namespace App\notification;
final class WelcomeService
{
    public function __construct(private Mailer $mailer) {}
    public function welcome(string $email): bool
    {
        $body = "Welcome, {$email}!";
        return $this->mailer->send($email, $body);
    }
}
