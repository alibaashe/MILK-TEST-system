<?php

namespace App\Core;

use PDO;

abstract class Model
{
    protected static ?PDO $pdo = null;

    public function __construct()
    {
        if (self::$pdo === null) {
            self::$pdo = Database::getInstance();
        }
    }
}
