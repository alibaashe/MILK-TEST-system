<?php

namespace App\Models;

use App\Core\Model;
use PDO;

class LabTest extends Model
{
    public function findBySampleId(int $sample_id)
    {
        $stmt = self::$pdo->prepare("SELECT * FROM lab_tests WHERE sample_id = :sample_id");
        $stmt->bindValue(':sample_id', $sample_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create(array $data): bool
    {
        $sql = "INSERT INTO lab_tests (sample_id, ph, specific_gravity, mastitis_test_result, antibiotic_test_result, bacterial_count, fat_percentage, protein_percentage, lactose_percentage, solids_non_fat_percentage, freezing_point)
                VALUES (:sample_id, :ph, :specific_gravity, :mastitis_test_result, :antibiotic_test_result, :bacterial_count, :fat_percentage, :protein_percentage, :lactose_percentage, :solids_non_fat_percentage, :freezing_point)";

        $stmt = self::$pdo->prepare($sql);

        $stmt->bindValue(':sample_id', $data['sample_id'], PDO::PARAM_INT);
        $stmt->bindValue(':ph', $data['ph']);
        $stmt->bindValue(':specific_gravity', $data['specific_gravity']);
        $stmt->bindValue(':mastitis_test_result', $data['mastitis_test_result']);
        $stmt->bindValue(':antibiotic_test_result', $data['antibiotic_test_result']);
        $stmt->bindValue(':bacterial_count', $data['bacterial_count'], PDO::PARAM_INT);
        $stmt->bindValue(':fat_percentage', $data['fat_percentage']);
        $stmt->bindValue(':protein_percentage', $data['protein_percentage']);
        $stmt->bindValue(':lactose_percentage', $data['lactose_percentage']);
        $stmt->bindValue(':solids_non_fat_percentage', $data['solids_non_fat_percentage']);
        $stmt->bindValue(':freezing_point', $data['freezing_point']);

        return $stmt->execute();
    }

    public function update(int $id, array $data): bool
    {
        $sql = "UPDATE lab_tests SET
                    ph = :ph,
                    specific_gravity = :specific_gravity,
                    mastitis_test_result = :mastitis_test_result,
                    antibiotic_test_result = :antibiotic_test_result,
                    bacterial_count = :bacterial_count,
                    fat_percentage = :fat_percentage,
                    protein_percentage = :protein_percentage,
                    lactose_percentage = :lactose_percentage,
                    solids_non_fat_percentage = :solids_non_fat_percentage,
                    freezing_point = :freezing_point
                WHERE id = :id";

        $stmt = self::$pdo->prepare($sql);

        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':ph', $data['ph']);
        $stmt->bindValue(':specific_gravity', $data['specific_gravity']);
        $stmt->bindValue(':mastitis_test_result', $data['mastitis_test_result']);
        $stmt->bindValue(':antibiotic_test_result', $data['antibiotic_test_result']);
        $stmt->bindValue(':bacterial_count', $data['bacterial_count'], PDO::PARAM_INT);
        $stmt->bindValue(':fat_percentage', $data['fat_percentage']);
        $stmt->bindValue(':protein_percentage', $data['protein_percentage']);
        $stmt->bindValue(':lactose_percentage', $data['lactose_percentage']);
        $stmt->bindValue(':solids_non_fat_percentage', $data['solids_non_fat_percentage']);
        $stmt->bindValue(':freezing_point', $data['freezing_point']);

        return $stmt->execute();
    }
}
