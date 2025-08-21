<?php

namespace App\Controllers;

use App\Models\Farm;
use App\Models\FinalJudgement;

class ReportController extends BaseController
{
    protected function before(): bool
    {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('?url=auth/login');
            return false;
        }
        return true;
    }

    public function index()
    {
        $farmModel = new Farm();
        $judgementModel = new FinalJudgement();

        // Data for Animals per Farm chart
        $animalCountsData = $farmModel->getAnimalCounts();
        $farmLabels = [];
        $animalCounts = [];
        foreach ($animalCountsData as $data) {
            $farmLabels[] = $data['name'];
            $animalCounts[] = $data['animal_count'];
        }

        // Data for Judgement Breakdown chart
        $judgementCountsData = $judgementModel->getJudgementCounts();
        $judgementLabels = array_keys($judgementCountsData);
        $judgementCounts = array_values($judgementCountsData);

        $this->render('reports/index.php', [
            'title' => 'Reports',
            'farmLabels' => json_encode($farmLabels),
            'animalCounts' => json_encode($animalCounts),
            'judgementLabels' => json_encode($judgementLabels),
            'judgementCounts' => json_encode($judgementCounts)
        ]);
    }
}
