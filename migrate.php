<?php

// A simple migration script

// Autoloader
spl_autoload_register(function ($class) {
    $root = __DIR__;
    // Adjust for our App namespace
    $file = $root . '/' . str_replace(['\\', 'App/'], ['/', 'src/'], $class) . '.php';
    if (is_readable($file)) {
        require $file;
    }
});

echo "Running migrations...\n";

try {
    // Get the database instance
    $pdo = App\Core\Database::getInstance();

    if ($pdo === null) {
        throw new Exception("Could not get a database connection.");
    }

    // Read the SQL file
    $sql = file_get_contents(__DIR__ . '/database/schema.sql');

    if ($sql === false) {
        throw new Exception("Could not read the schema.sql file.");
    }

    // Execute the SQL
    $pdo->exec($sql);

    echo "Database schema created successfully.\n";

} catch (Exception $e) {
    die("An error occurred: " . $e->getMessage() . "\n");
}
