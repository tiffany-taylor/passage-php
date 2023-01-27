<?php

namespace Passage\SDK;
class UserId implements HasUserId
{
    private string $userId;

    public function __construct(string $userId)
    {
        $this->userId = $userId;
    }

    public function getId(): string
    {
        return $this->userId;
    }

    public function __toString(): string
    {
        return $this->userId;
    }
}