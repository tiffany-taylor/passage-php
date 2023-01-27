<?php

namespace Passage\SDK\Entity;

use Passage\SDK\UserAttributes;
use Passage\SDK\UserId;

class User implements HasUserId
{
    protected ?string $email;
    protected ?string $phone;
    protected ?Metadata $metadata;
    public UserId $userId;
    public function getId(): string
    {
        // TODO: Implement getId() method.
    }

    public function __construct(UserAttributes $userAttributes)
    {
        $this->email = $userAttributes->email;
        $this->phone = $userAttributes->phone;
        $this->metadata = $userAttributes->metadata;
    }
}