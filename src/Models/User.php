<?php

namespace App\Models;

use App\Core\Model;
use PDO;

class User extends Model
{
    public function create(array $data): bool
    {
        $sql = "INSERT INTO users (name, email, password, role) VALUES (:name, :email, :password, :role)";

        $stmt = self::$pdo->prepare($sql);

        // Hash the password
        $password = password_hash($data['password'], PASSWORD_DEFAULT);

        $stmt->bindValue(':name', $data['name']);
        $stmt->bindValue(':email', $data['email']);
        $stmt->bindValue(':password', $password);
        $stmt->bindValue(':role', $data['role']);

        return $stmt->execute();
    }

    public function findByEmail(string $email)
    {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findById(int $id)
    {
        $sql = "SELECT * FROM users WHERE id = :id";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
