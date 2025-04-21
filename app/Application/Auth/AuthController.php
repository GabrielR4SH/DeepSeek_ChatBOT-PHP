<?php

namespace App\Application\Auth;

use App\Domain\Auth\AuthService;
use App\Domain\User\User;
use App\Infrastructure\User\UserRepository;
use App\Infrastructure\Database\DB;

class AuthController
{
    private UserRepository $userRepository;
    private AuthService $authService;

    public function __construct()
    {
        $db = new DB();
        $this->userRepository = new UserRepository($db);
        $this->authService = new AuthService();
    }

    public function register(string $username, string $email, string $password): array
    {
        // Validação básica
        if (empty($username) || empty($email) || empty($password)) {
            throw new \InvalidArgumentException("Todos os campos são obrigatórios.");
        }

        if ($this->userRepository->findByUsername($username)) {
            throw new \InvalidArgumentException("Nome de usuário já em uso.");
        }

        $user = new User(
            null,
            $username,
            $email,
            password_hash($password, PASSWORD_BCRYPT),
            new \DateTimeImmutable(),
            new \DateTimeImmutable()
        );

        $this->userRepository->create($user);
        
        return [
            'success' => true,
            'message' => 'Registro realizado com sucesso!'
        ];
    }

    public function login(string $username, string $password): ?array
    {
        $user = $this->userRepository->findByUsername($username);
        
        if (!$user || !password_verify($password, $user->passwordHash)) {
            return null;
        }

        $token = $this->authService->generateToken($user);
        
        return [
            'user' => [
                'id' => $user->id,
                'username' => $user->username,
                'email' => $user->email
            ],
            'token' => $token->token,
            'expires' => $token->expiresAt
        ];
    }
}