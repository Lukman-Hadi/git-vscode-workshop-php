<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Services\UserService;

class UserController
{
    private UserService $service;

    public function __construct()
    {
        $this->service = new UserService();
    }

    public function listUsers(): array
    {
        // Refactor candidate: parameter opsional sort (commit refactor terpisah).
        return $this->service->listUsers();
    }

    // Latihan Fitur: method addUser(array $data) yang validasi email + nama (commit feat).
}