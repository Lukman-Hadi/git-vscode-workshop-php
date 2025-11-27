<?php
declare(strict_types=1);
namespace App\notification;
interface Mailer { public function send(string $to, string $body): bool; }
