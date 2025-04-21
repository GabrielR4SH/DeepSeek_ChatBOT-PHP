<?php

namespace App\Domain\Auth;

use App\Domain\User\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthService
{
    private string $jwtSecret;
    private int $jwtExpiry;

    public function __construct()
    {
        $this->jwtSecret = $_ENV['JWT_SECRET'] ?? 'default_secret';
        $this->jwtExpiry = $_ENV['JWT_EXPIRY'] ?? 3600;
    }

    public function generateToken(User $user): Token
    {
        $issuedAt = time();
        $expire = $issuedAt + $this->jwtExpiry;

        $payload = [
            'iat' => $issuedAt,
            'exp' => $expire,
            'sub' => $user->id,
            'username' => $user->username
        ];

        $jwt = JWT::encode($payload, $this->jwtSecret, 'HS256');
        
        return new Token($jwt, $expire);
    }

    public function validateToken(string $token): ?array
    {
        try {
            $decoded = JWT::decode($token, new Key($this->jwtSecret, 'HS256'));
            return (array) $decoded;
        } catch (\Exception $e) {
            return null;
        }
    }
}