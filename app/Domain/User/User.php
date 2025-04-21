<?php 

namespace App\Domain\User;

class User
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $username,
        public readonly string $email,
        public readonly string $passwordHash,
        public readonly \DateTimeImmutable $createdAt,
        public readonly \DateTimeImmutable $upddatedAt
    ) { }

}