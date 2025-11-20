<?php
declare(strict_types=1);

namespace App\Services;

use App\Utils\EmailValidator;
use InvalidArgumentException;

class UserService
{
    private array $users = [
        ['id' => '1', 'name' => 'Ayla', 'email' => 'ayla@example.com'],
        ['id' => '2', 'name' => 'Bimo', 'email' => 'bimo@example.com'],
    ];

    public function listUsers(array $options = []): array
    {
        $users = $this->users;
        if (($options['sortBy'] ?? null) === 'name') {
            usort($users, fn($a, $b) => strcmp($a['name'], $b['name']));
        }
        return $users;
    }

    public function getUserById(string $id): ?array
    {
        foreach ($this->users as $u) {
            if ($u['id'] === $id) {
                return $u;
            }
        }
        return null;
    }

    public function validateAndAddUser(array $data): array
    {
        $name = trim($data['name'] ?? '');
        $email = trim($data['email'] ?? '');

        if ($name === '' || $email === '') {
            throw new InvalidArgumentException('Name or email cannot be empty');
        }
        if (!EmailValidator::isValid($email)) {
            throw new InvalidArgumentException('Invalid email format');
        }

        $new = [
            'id' => uniqid('', true),
            'name' => $name,
            'email' => $email,
        ];
        $this->users[] = $new;
        return $new;
    }
}