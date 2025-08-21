<?php

/**
 * Front Controller
 */

// Autoloader
spl_autoload_register(function ($class) {
    $root = dirname(__DIR__); // get the parent directory
    $file = $root . '/' . str_replace('\\', '/', $class) . '.php';
    $file = str_replace('App/', 'src/', $file); // Adjust for our namespace
    if (is_readable($file)) {
        require $file;
    }
});

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', '1');


// Start session
session_start();

// Routing
$router = new App\Core\Router();

// Add the routes
$router->add('', ['controller' => 'Home', 'action' => 'index']);
$router->add('auth/login', ['controller' => 'Auth', 'action' => 'login']);
$router->add('auth/processLogin', ['controller' => 'Auth', 'action' => 'processLogin']);
$router->add('auth/register', ['controller' => 'Auth', 'action' => 'register']);
$router->add('auth/processRegistration', ['controller' => 'Auth', 'action' => 'processRegistration']);
$router->add('auth/logout', ['controller' => 'Auth', 'action' => 'logout']);
$router->add('dashboard', ['controller' => 'Dashboard', 'action' => 'index']);

// Farm routes
$router->add('farm/index', ['controller' => 'Farm', 'action' => 'index']);
$router->add('farm/create', ['controller' => 'Farm', 'action' => 'create']);
$router->add('farm/store', ['controller' => 'Farm', 'action' => 'store']);
$router->add('farm/edit/{id:\d+}', ['controller' => 'Farm', 'action' => 'edit']);
$router->add('farm/update/{id:\d+}', ['controller' => 'Farm', 'action' => 'update']);
$router->add('farm/destroy/{id:\d+}', ['controller' => 'Farm', 'action' => 'destroy']);

// Animal routes
$router->add('animal/index', ['controller' => 'Animal', 'action' => 'index']);
$router->add('animal/create', ['controller' => 'Animal', 'action' => 'create']);
$router->add('animal/store', ['controller' => 'Animal', 'action' => 'store']);
$router->add('animal/edit/{id:\d+}', ['controller' => 'Animal', 'action' => 'edit']);
$router->add('animal/update/{id:\d+}', ['controller' => 'Animal', 'action' => 'update']);
$router->add('animal/destroy/{id:\d+}', ['controller' => 'Animal', 'action' => 'destroy']);

// Milk Sample routes
$router->add('milkSample/index', ['controller' => 'MilkSample', 'action' => 'index']);
$router->add('milkSample/create', ['controller' => 'MilkSample', 'action' => 'create']);
$router->add('milkSample/store', ['controller' => 'MilkSample', 'action' => 'store']);
$router->add('milkSample/show/{id:\d+}', ['controller' => 'MilkSample', 'action' => 'show']);
$router->add('milkSample/storeLabTest/{id:\d+}', ['controller' => 'MilkSample', 'action' => 'storeLabTest']);
$router->add('milkSample/storeFinalJudgement/{id:\d+}', ['controller' => 'MilkSample', 'action' => 'storeFinalJudgement']);

// Report routes
$router->add('report/index', ['controller' => 'Report', 'action' => 'index']);


// A more generic route for other controllers
$router->add('{controller}/{action}');


// Parse the URL from the query string
$url = $_GET['url'] ?? '';

// Dispatch the router
$router->dispatch($url);
