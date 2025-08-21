<?php

namespace App\Controllers;

use App\Models\Animal;
use App\Models\Farm;

class AnimalController extends BaseController
{
    private Animal $animalModel;
    private Farm $farmModel;

    public function __construct(array $params)
    {
        parent::__construct($params);
        $this->animalModel = new Animal();
        $this->farmModel = new Farm();
    }

    /**
     * Before filter - protect all actions in this controller
     */
    protected function before(): bool
    {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('?url=auth/login');
            return false;
        }

        $allowed_roles = ['Admin', 'Inspector'];
        if (!in_array($_SESSION['user_role'], $allowed_roles)) {
            die('Access Denied: You do not have permission to manage animals.');
        }
        return true;
    }

    /**
     * Show the list of animals.
     */
    public function index()
    {
        $animals = $this->animalModel->getAll();
        $this->render('animals/index.php', ['animals' => $animals, 'title' => 'Animals']);
    }

    /**
     * Show the form for creating a new animal.
     */
    public function create()
    {
        $farms = $this->farmModel->getAll();
        $this->render('animals/create.php', [
            'farms' => $farms,
            'title' => 'Add New Animal'
        ]);
    }

    /**
     * Store a new animal in the database.
     */
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->animalModel->create($_POST);
            $this->redirect('?url=animal/index');
        }
    }

    /**
     * Show the form for editing an animal.
     */
    public function edit()
    {
        $id = $this->params['id'];
        $animal = $this->animalModel->findById($id);
        if (!$animal) {
            die('Animal not found.');
        }
        $farms = $this->farmModel->getAll();
        $this->render('animals/edit.php', [
            'animal' => $animal,
            'farms' => $farms,
            'title' => 'Edit Animal'
        ]);
    }

    /**
     * Update an existing animal in the database.
     */
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $this->params['id'];
            $this->animalModel->update($id, $_POST);
            $this->redirect('?url=animal/index');
        }
    }

    /**
     * Delete an animal from the database.
     */
    public function destroy()
    {
        $id = $this->params['id'];
        $this->animalModel->delete($id);
        $this->redirect('?url=animal/index');
    }
}
