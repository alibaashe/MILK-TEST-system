<?php

namespace App\Models;

use App\Core\Model;
use PDO;

class Farm extends Model
{
    public function getAll(): array
    {
        $stmt = self::$pdo->query("SELECT * FROM farms ORDER BY name");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById(int $id)
    {
        $stmt = self::$pdo->prepare("SELECT * FROM farms WHERE id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create(array $data): bool
    {
        $sql = "INSERT INTO farms (name, location, owner_name, contact_number) VALUES (:name, :location, :owner_name, :contact_number)";
        $stmt = self::$pdo->prepare($sql);

        $stmt->bindValue(':name', $data['name']);
        $stmt->bindValue(':location', $data['location']);
        $stmt->bindValue(':owner_name', $data['owner_name']);
        $stmt->bindValue(':contact_number', $data['contact_number']);

        return $stmt->execute();
    }

    public function update(int $id, array $data): bool
    {
        $sql = "UPDATE farms SET name = :name, location = :location, owner_name = :owner_name, contact_number = :contact_number WHERE id = :id";
        $stmt = self::$pdo->prepare($sql);

        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':name', $data['name']);
        $stmt->bindValue(':location', $data['location']);
        $stmt->bindValue(':owner_name', $data['owner_name']);
        $stmt->bindValue(':contact_number', $data['contact_number']);

        return $stmt->execute();
    }

    public function delete(int $id): bool
    {
        $stmt = self::$pdo->prepare("DELETE FROM farms WHERE id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function countAll(): int
    {
        $stmt = self::$pdo->query("SELECT COUNT(*) FROM farms");
        return $stmt->fetchColumn();
    }

    public function getAnimalCounts(): array
    {
        $sql = "SELECT f.name, COUNT(a.id) as animal_count
                FROM farms f
                LEFT JOIN animals a ON f.id = a.farm_id
                GROUP BY f.id, f.name
                ORDER BY f.name";
        $stmt = self::$pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
