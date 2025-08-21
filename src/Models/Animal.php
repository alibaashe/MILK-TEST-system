<?php

namespace App\Models;

use App\Core\Model;
use PDO;

class Animal extends Model
{
    public function getAll(): array
    {
        $sql = "SELECT animals.*, farms.name as farm_name
                FROM animals
                LEFT JOIN farms ON animals.farm_id = farms.id
                ORDER BY animals.tag_number";
        $stmt = self::$pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById(int $id)
    {
        $stmt = self::$pdo->prepare("SELECT * FROM animals WHERE id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create(array $data): bool
    {
        $sql = "INSERT INTO animals (farm_id, species, tag_number, date_of_birth, gender, health_status)
                VALUES (:farm_id, :species, :tag_number, :date_of_birth, :gender, :health_status)";
        $stmt = self::$pdo->prepare($sql);

        $stmt->bindValue(':farm_id', $data['farm_id'], PDO::PARAM_INT);
        $stmt->bindValue(':species', $data['species']);
        $stmt->bindValue(':tag_number', $data['tag_number']);
        $stmt->bindValue(':date_of_birth', $data['date_of_birth']);
        $stmt->bindValue(':gender', $data['gender']);
        $stmt->bindValue(':health_status', $data['health_status']);

        return $stmt->execute();
    }

    public function update(int $id, array $data): bool
    {
        $sql = "UPDATE animals SET
                    farm_id = :farm_id,
                    species = :species,
                    tag_number = :tag_number,
                    date_of_birth = :date_of_birth,
                    gender = :gender,
                    health_status = :health_status
                WHERE id = :id";
        $stmt = self::$pdo->prepare($sql);

        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':farm_id', $data['farm_id'], PDO::PARAM_INT);
        $stmt->bindValue(':species', $data['species']);
        $stmt->bindValue(':tag_number', $data['tag_number']);
        $stmt->bindValue(':date_of_birth', $data['date_of_birth']);
        $stmt->bindValue(':gender', $data['gender']);
        $stmt->bindValue(':health_status', $data['health_status']);

        return $stmt->execute();
    }

    public function delete(int $id): bool
    {
        $stmt = self::$pdo->prepare("DELETE FROM animals WHERE id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function countAll(): int
    {
        $stmt = self::$pdo->query("SELECT COUNT(*) FROM animals");
        return $stmt->fetchColumn();
    }
}
