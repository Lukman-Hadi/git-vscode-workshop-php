<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Services\UserService;
use InvalidArgumentException;

class UserController
{
    private UserService $service;

    public function __construct()
    {
        $this->service = new UserService();
    }

    public function listUsers(array $options = []): array
    {
        return $this->service->listUsers($options);
    }

    public function addUser(array $data): array
    {
        return $this->service->validateAndAddUser($data);
    }
}