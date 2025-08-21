<?php

namespace App\Controllers;

use App\Models\MilkSample;
use App\Models\LabTest;
use App\Models\FinalJudgement;
use App\Models\Animal;

class MilkSampleController extends BaseController
{
    private MilkSample $milkSampleModel;
    private LabTest $labTestModel;
    private FinalJudgement $finalJudgementModel;
    private Animal $animalModel;

    public function __construct(array $params)
    {
        parent::__construct($params);
        $this->milkSampleModel = new MilkSample();
        $this->labTestModel = new LabTest();
        $this->finalJudgementModel = new FinalJudgement();
        $this->animalModel = new Animal();
    }

    protected function before(): bool
    {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('?url=auth/login');
            return false;
        }
        $allowed_roles = ['Admin', 'Lab Technician', 'Inspector'];
        if (!in_array($_SESSION['user_role'], $allowed_roles)) {
            die('Access Denied.');
        }
        return true;
    }

    public function index()
    {
        $samples = $this->milkSampleModel->getAll();
        $this->render('milk_samples/index.php', ['samples' => $samples, 'title' => 'Milk Samples']);
    }

    public function create()
    {
        $animals = $this->animalModel->getAll();
        $this->render('milk_samples/create.php', ['animals' => $animals, 'title' => 'Add Milk Sample']);
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_POST['collected_by'] = $_SESSION['user_name'];
            $this->milkSampleModel->create($_POST);
            $this->redirect('?url=milkSample/index');
        }
    }

    public function show()
    {
        $id = $this->params['id'];
        $sample = $this->milkSampleModel->findById($id);
        if (!$sample) {
            die('Sample not found.');
        }
        $labTest = $this->labTestModel->findBySampleId($id);
        $finalJudgement = $this->finalJudgementModel->findBySampleId($id);

        $this->render('milk_samples/show.php', [
            'sample' => $sample,
            'labTest' => $labTest,
            'finalJudgement' => $finalJudgement,
            'title' => 'Sample Details: ' . $sample['sample_code']
        ]);
    }

    public function storeLabTest()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $sample_id = $this->params['id'];
            $existingTest = $this->labTestModel->findBySampleId($sample_id);

            $_POST['sample_id'] = $sample_id;

            if ($existingTest) {
                $this->labTestModel->update($existingTest['id'], $_POST);
            } else {
                $this->labTestModel->create($_POST);
            }

            $this->milkSampleModel->updateStatus($sample_id, 'Completed');
            $this->redirect('?url=milkSample/show/' . $sample_id);
        }
    }

    public function storeFinalJudgement()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $sample_id = $this->params['id'];
            $upload_dir = dirname(__DIR__, 2) . '/uploads/signatures/';
            $signature_path = null;

            // Handle file upload
            if (isset($_FILES['signature']) && $_FILES['signature']['error'] === UPLOAD_ERR_OK) {
                $file_tmp_path = $_FILES['signature']['tmp_name'];
                $file_name = $_FILES['signature']['name'];
                $file_size = $_FILES['signature']['size'];
                $file_type = $_FILES['signature']['type'];
                $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

                $allowed_ext = ['jpg', 'jpeg', 'png'];
                if (in_array($file_ext, $allowed_ext)) {
                    if ($file_size < 2000000) { // 2MB limit
                        $new_file_name = uniqid('', true) . '.' . $file_ext;
                        $dest_path = $upload_dir . $new_file_name;

                        if (move_uploaded_file($file_tmp_path, $dest_path)) {
                            $signature_path = $new_file_name;
                        } else {
                            die('Error moving uploaded file.');
                        }
                    } else {
                        die('File is too large.');
                    }
                } else {
                    die('Invalid file type.');
                }
            }

            $existingJudgement = $this->finalJudgementModel->findBySampleId($sample_id);

            $data = $_POST;
            $data['sample_id'] = $sample_id;
            $data['judged_by'] = $_SESSION['user_id'];
            $data['inspector_signature_path'] = $signature_path;

            if ($existingJudgement) {
                // Don't overwrite existing signature if no new one is uploaded
                if ($signature_path === null) {
                    $data['inspector_signature_path'] = $existingJudgement['inspector_signature_path'];
                }
                $this->finalJudgementModel->update($existingJudgement['id'], $data);
            } else {
                $this->finalJudgementModel->create($data);
            }

            $this->milkSampleModel->updateStatus($sample_id, 'Judged');
            $this->redirect('?url=milkSample/show/' . $sample_id);
        }
    }
}
