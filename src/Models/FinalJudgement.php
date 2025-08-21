<?php

namespace App\Models;

use App\Core\Model;
use PDO;

class FinalJudgement extends Model
{
    public function findBySampleId(int $sample_id)
    {
        $sql = "SELECT fj.*, u.name as judge_name
                FROM final_judgements fj
                LEFT JOIN users u ON fj.judged_by = u.id
                WHERE fj.sample_id = :sample_id";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindValue(':sample_id', $sample_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create(array $data): bool
    {
        $sql = "INSERT INTO final_judgements (sample_id, judgement, comments, judged_by, inspector_signature_path)
                VALUES (:sample_id, :judgement, :comments, :judged_by, :inspector_signature_path)";

        $stmt = self::$pdo->prepare($sql);

        $stmt->bindValue(':sample_id', $data['sample_id'], PDO::PARAM_INT);
        $stmt->bindValue(':judgement', $data['judgement']);
        $stmt->bindValue(':comments', $data['comments']);
        $stmt->bindValue(':judged_by', $data['judged_by'], PDO::PARAM_INT);
        $stmt->bindValue(':inspector_signature_path', $data['inspector_signature_path']);

        return $stmt->execute();
    }

    public function update(int $id, array $data): bool
    {
        // Build the query dynamically based on whether a new signature is uploaded
        $sql = "UPDATE final_judgements SET
                    judgement = :judgement,
                    comments = :comments,
                    judged_by = :judged_by";

        if (!empty($data['inspector_signature_path'])) {
            $sql .= ", inspector_signature_path = :inspector_signature_path";
        }

        $sql .= " WHERE id = :id";

        $stmt = self::$pdo->prepare($sql);

        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':judgement', $data['judgement']);
        $stmt->bindValue(':comments', $data['comments']);
        $stmt->bindValue(':judged_by', $data['judged_by'], PDO::PARAM_INT);

        if (!empty($data['inspector_signature_path'])) {
            $stmt->bindValue(':inspector_signature_path', $data['inspector_signature_path']);
        }

        return $stmt->execute();
    }

    public function getJudgementCounts(): array
    {
        $sql = "SELECT judgement, COUNT(*) as count FROM final_judgements GROUP BY judgement";
        $stmt = self::$pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
    }
}
