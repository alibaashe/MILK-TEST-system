<?php

namespace App\Controllers;

class HomeController extends BaseController
{
    /**
     * Show the index page.
     */
    public function index()
    {
        // For now, just a simple welcome message.
        // Later, we can render a proper home page view.
        echo "<h1>Welcome to the Milk Testing System</h1>";
        echo "<p><a href='/auth/login'>Login</a> or <a href='/auth/register'>Register</a></p>";
    }
}
