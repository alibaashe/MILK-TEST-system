<?php

namespace App\Controllers;

use App\Models\Farm;
use App\Models\Animal;
use App\Models\MilkSample;

class DashboardController extends BaseController
{
    /**
     * Before filter. Protects the dashboard from guest users.
     */
    protected function before(): bool
    {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('?url=auth/login');
            return false;
        }
        return true;
    }

    /**
     * Show the dashboard page.
     */
    public function index()
    {
        $farmModel = new Farm();
        $animalModel = new Animal();
        $milkSampleModel = new MilkSample();

        $stats = [
            'farm_count' => $farmModel->countAll(),
            'animal_count' => $animalModel->countAll(),
            'sample_status_counts' => $milkSampleModel->getStatusCounts()
        ];

        $this->render('dashboard/index.php', [
            'title' => 'Dashboard',
            'stats' => $stats
        ]);
    }
}
