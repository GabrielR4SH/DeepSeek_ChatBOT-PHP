<?php

namespace App\Domain\Auth;

class Token
{
    public function __construct(
        public readonly string $token,
        public readonly int $expiresAt
    ) {}
}