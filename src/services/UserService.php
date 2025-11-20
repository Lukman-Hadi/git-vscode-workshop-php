<?php
declare(strict_types=1);

namespace App\Services;

use App\Utils\EmailValidator;

class UserService
{
    // Simulasi storage in-memory (latihan: nanti refactor ke Repository terpisah).
    private array $users = [
        ['id' => '1', 'name' => 'Ayla', 'email' => 'ayla@example.com'],
        ['id' => '2', 'name' => 'Bimo', 'email' => 'bimo@example.com'],
    ];

    public function listUsers(): array
    {
        // Refactor candidate: tambahkan opsi sortBy (commit refactor).
        return $this->users;
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

    // Latihan Fitur: tambah method validateAndAddUser(array $data) (commit feat terpisah).
}