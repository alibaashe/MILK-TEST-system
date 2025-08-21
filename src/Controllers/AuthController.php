<?php

namespace App\Controllers;

use App\Models\User;

class AuthController extends BaseController
{
    /**
     * Show the registration page.
     */
    public function register()
    {
        $this->render('auth/register.php');
    }

    /**
     * Process the registration form.
     */
    public function processRegistration()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Basic validation
            if ($_POST['password'] !== $_POST['password_confirmation']) {
                die('Passwords do not match.');
            }

            $user = new User();
            $success = $user->create([
                'name' => $_POST['name'],
                'email' => $_POST['email'],
                'password' => $_POST['password'],
                'role' => $_POST['role'] ?? 'Inspector' // Default role
            ]);

            if ($success) {
                $this->redirect('/auth/login');
            } else {
                die('Registration failed.');
            }
        }
    }

    /**
     * Show the login page.
     */
    public function login()
    {
        $this->render('auth/login.php');
    }

    /**
     * Process the login form.
     */
    public function processLogin()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userModel = new User();
            $user = $userModel->findByEmail($_POST['email']);

            if ($user && password_verify($_POST['password'], $user['password'])) {
                // Start session and store user info
                session_start();
                session_regenerate_id(true); // Prevent session fixation
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_role'] = $user['role'];

                // Redirect to a dashboard or home page
                $this->redirect('/dashboard');
            } else {
                // Invalid credentials, redirect back to login
                $this->redirect('/auth/login?error=1');
            }
        }
    }

    /**
     * Log the user out.
     */
    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();
        $this->redirect('/');
    }
}
