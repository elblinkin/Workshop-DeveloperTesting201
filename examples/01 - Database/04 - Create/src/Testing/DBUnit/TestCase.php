<?php

namespace Testing\DBUnit;

use PDO;
use PHPUnit_Extensions_Database_TestCase;

abstract class TestCase extends PHPUnit_Extensions_Database_TestCase {

    private static $pdo;

    public static function setUpBeforeClass() {
        self::$pdo = new PDO('sqlite::memory:');
        self::$pdo->exec(
            '
            CREATE TABLE user(
                id INTEGER PRIMARY KEY,
                name VARCHAR(255) NOT NULL
            )
            '
        );
    }

    protected function getPDO() {
        return self::$pdo;
    }

    protected function getConnection() {
        return $this->createDefaultDBConnection(self::$pdo, ':memory:');
    }
}
