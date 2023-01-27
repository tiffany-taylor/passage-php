<?php

namespace Passage\SDK;

class UserAttributes
{
    public ?string $email;
    public ?string $phone;
    public ?Metadata $metadata;

    public function __construct(?string $email, ?string $phone, ?Metadata $metadata)
    {
        if ($email === null && $phone === null) {
            throw new \InvalidArgumentException('A phone number or email address is required to create a user');
        }

        $this->email = $email;
        $this->phone = $phone;
        $this->metadata = $metadata;
    }

    public function __get()
    {
        // TODO build this
    }
}