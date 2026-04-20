<?php

namespace App\DTOs;

class UserDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $phone,
        public readonly string $fullname,
        public readonly string $password,
        public readonly bool $active,
        public readonly ?bool $sudo = false,
        public readonly ?string $avatar = null
    )
    {}

    public static function fromArray(array $data): UserDTO
    {
        return new self(
            name: $data['name'],
            email: $data['email'],
            phone: $data['phone'],
            fullname: $data['fullname'],
            password: $data['password'],
            active: $data['active'],
            sudo: $data['sudo'],
            avatar: $data['avatar']
        );
    }
}
