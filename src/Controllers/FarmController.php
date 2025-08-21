<?php

namespace App\Controllers;

use App\Models\Farm;

class FarmController extends BaseController
{
    private Farm $farmModel;

    public function __construct(array $params)
    {
        parent::__construct($params);
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
        // Optional: Role-based access
        if ($_SESSION['user_role'] !== 'Admin') {
            die('Access Denied: You must be an Admin to manage farms.');
        }
        return true;
    }

    /**
     * Show the list of farms.
     */
    public function index()
    {
        $farms = $this->farmModel->getAll();
        $this->render('farms/index.php', ['farms' => $farms, 'title' => 'Farms']);
    }

    /**
     * Show the form for creating a new farm.
     */
    public function create()
    {
        $this->render('farms/create.php', ['title' => 'Add New Farm']);
    }

    /**
     * Store a new farm in the database.
     */
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->farmModel->create($_POST);
            $this->redirect('?url=farm/index');
        }
    }

    /**
     * Show the form for editing a farm.
     */
    public function edit()
    {
        $id = $this->params['id'];
        $farm = $this->farmModel->findById($id);
        if (!$farm) {
            die('Farm not found.');
        }
        $this->render('farms/edit.php', ['farm' => $farm, 'title' => 'Edit Farm']);
    }

    /**
     * Update an existing farm in the database.
     */
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $this->params['id'];
            $this->farmModel->update($id, $_POST);
            $this->redirect('?url=farm/index');
        }
    }

    /**
     * Delete a farm from the database.
     */
    public function destroy()
    {
        $id = $this->params['id'];
        $this->farmModel->delete($id);
        $this->redirect('?url=farm/index');
    }
}
