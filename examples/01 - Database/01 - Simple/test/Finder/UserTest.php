<?php

require_once 'Finder/User.php';
require_once 'Model/User.php';

require_once 'PHPUnit/Extensions/Database/TestCase.php';
require_once 'PHPUnit/Extensions/Database/DataSet/ArrayDataSet.php';

use Finder\User as UserFinder;
use Model\User as User;

class UserTest extends PHPUnit_Extensions_Database_TestCase {

    private $pdo;
    private $finder;

    protected function setUp() {
        $this->pdo = new PDO('sqlite::memory:');
        parent::setUp();
        $this->finder = new UserFinder($this->pdo);
    }

    protected function getConnection() {
        $this->pdo->exec(
            '
            CREATE TABLE user(
                id INTEGER PRIMARY KEY,
                name VARCHAR(255) NOT NULL
            )
            '
        );
        return $this->createDefaultDBConnection($this->pdo, ':memory:');
    }

    protected function getDataSet() {
        return new PHPUnit_Extensions_Database_DataSet_ArrayDataSet(
            array(
                'user' => array(
                    array('id' => 1, 'name' => 'Bob'),
                    array('id' => 2, 'name' => 'Alice'),
                ),
            )
        );
    }

    public function testFind_exists() {
        $expected = new User(1, 'Bob');
        $actual = $this->finder->find(1);
        $this->assertEquals($expected, $actual);
    }

    public function testFind_doesNotExist() {
        $this->assertNull($this->finder->find(3));
    }

    public function testFindAll() {
        $expected = array(
            new User(1, 'Bob'),
            new User(2, 'Alice'),
        );
        $actual = $this->finder->findAll();
        $this->assertEquals($expected, $actual);
    }
}