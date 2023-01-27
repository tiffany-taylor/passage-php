<?php

namespace Passage\SDK\Repository;

use Passage\SDK\Entity\User;
use Passage\HasUserId;

class Users
{
    public function get(HasUserId $user): User
    {
        // TODO: Implement get() method.
    }

    public function update(HasUserId $userId, UserAttributes $userAttributes): User
    {
        // TODO: Implement update() method.
    }

    public function create(UserAttributes $userAttributes): User
    {
        // TODO: Implement create() method.
    }

    public function delete(HasUserId $userId): bool
    {
        // TODO: Implement delete() method.
    }

    public function deactivate(HasUserId $user): void
    {
        // TODO: Implement deactivate() method.
    }

    public function activate(HasUserId $user): void
    {
        // TODO: Implement deactivate() method.
    }

    public function signOut(HasUserId $userId): bool
    {
        // TODO: Implement signOut() method.
    }

    public function listDevices(HasUserId $userId)
    {
        // TODO: Implement listDevices() method.
    }

    public function revokeDevice(HasUserId $userId, string $deviceId): bool
    {
        // TODO: Implement revokeDevice() method.
    }
}
