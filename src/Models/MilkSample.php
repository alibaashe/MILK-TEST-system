<?php

namespace App\Models;

use App\Core\Model;
use PDO;

class MilkSample extends Model
{
    public function getAll(): array
    {
        $sql = "SELECT ms.id, ms.sample_code, ms.collection_date, ms.status,
                       a.tag_number AS animal_tag, f.name AS farm_name
                FROM milk_samples ms
                JOIN animals a ON ms.animal_id = a.id
                JOIN farms f ON a.farm_id = f.id
                ORDER BY ms.collection_date DESC";
        $stmt = self::$pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById(int $id)
    {
        $sql = "SELECT ms.*, a.tag_number as animal_tag, f.name as farm_name
                FROM milk_samples ms
                JOIN animals a ON ms.animal_id = a.id
                JOIN farms f ON a.farm_id = f.id
                WHERE ms.id = :id";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create(array $data): bool
    {
        $sql = "INSERT INTO milk_samples (sample_code, farm_id, animal_id, collection_date, collection_time, collected_by, status)
                VALUES (:sample_code, :farm_id, :animal_id, :collection_date, :collection_time, :collected_by, :status)";

        $stmt = self::$pdo->prepare($sql);

        // We need to get farm_id from animal_id
        $animalModel = new Animal();
        $animal = $animalModel->findById($data['animal_id']);
        $farm_id = $animal ? $animal['farm_id'] : null;

        $stmt->bindValue(':sample_code', $data['sample_code']);
        $stmt->bindValue(':farm_id', $farm_id, PDO::PARAM_INT);
        $stmt->bindValue(':animal_id', $data['animal_id'], PDO::PARAM_INT);
        $stmt->bindValue(':collection_date', $data['collection_date']);
        $stmt->bindValue(':collection_time', $data['collection_time']);
        $stmt->bindValue(':collected_by', $data['collected_by']);
        $stmt->bindValue(':status', $data['status'] ?? 'Pending');

        return $stmt->execute();
    }

    public function updateStatus(int $id, string $status): bool
    {
        $sql = "UPDATE milk_samples SET status = :status WHERE id = :id";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':status', $status);
        return $stmt->execute();
    }

    public function getStatusCounts(): array
    {
        $sql = "SELECT status, COUNT(*) as count FROM milk_samples GROUP BY status";
        $stmt = self::$pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
    }
}
