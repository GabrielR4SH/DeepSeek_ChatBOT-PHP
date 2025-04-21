<?php 

namespace App\Domain\User\User;
use App\Domain\User\User;
use App\Infrastructure\Database\DB;

class UserRepository
{

    public function __construct(private DB $db) {}

    public function findByUsername(string $username): ?User
    {
        $stmt = $this->db->getConnection()->prepare(
            "SELECT * FROM users WHERE username = ?"
        );
        
        $stmt->execute([$username]);
        $data = $stmt->fetch();

        return $data ? new User(
            $data['id'],
            $data['username'],
            $data['email'],
            $data['password_hash'],
            new \DateTimeImmutable($data['created_at']),
            new \DateTimeImmutable($data['updated_at'])
        ) : null;

    }

    public function create(User $user): void 
    {
        $stmt = $this->db->getConnection()->prepare(
            "INSERT INTO user (username, emai, password_hash) VALUES (?, ?, ?)"
        );

        $stmt->execute([
            $user->username,
            $user->email,
            $user->passwordHash
        ]);

    }


}
