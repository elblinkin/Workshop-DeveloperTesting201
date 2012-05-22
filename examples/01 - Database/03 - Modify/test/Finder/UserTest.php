<?php

require_once 'Finder/User.php';
require_once 'Model/User.php';
require_once 'Record.php';

require_once 'Testing/DBUnit/TestCase.php';

require_once 'PHPUnit/Extensions/Database/DataSet/ArrayDataSet.php';

use Finder\User as UserFinder;
use Model\User as User;
use Testing\DBUnit\TestCase as DBUnitTestCase;

class UserTest extends DBUnitTestCase {

    protected function setUp() {
    	parent::setUp();
    	$this->finder = new UserFinder($this->getPDO());
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
    	$expected = new User(
            new Record(
                $this->getPDO(),
                'user',
                array(
                    'id' => '1',
                    'name' => 'Bob'
                )
            )
        );
        $actual = $this->finder->find(1);
        $this->assertEquals($expected, $actual);
    }

    public function testFind_doesNotExist() {
        $this->assertNull($this->finder->find(3));
    }

    /**
     * This test is probably not appropriate.
     * See: RecordTest
     */
    public function testFind_modify() {
        $expected = new User(
            new Record(
                $this->getPDO(),
                'user',
                array(
                    'id' => '1',
                    'name' => 'Bobby'
                )
            )
        );
        $original = $this->finder->find(1);
        $original->setName('Bobby');
        $original->store();
        $actual = $this->finder->find(1);
        $this->assertEquals($expected, $actual);
    }

    public function testFindAll() {
    	$expected = array(
    		new User(
                new Record(
                    $this->getPDO(),
                    'user',
                    array(
                        'id' => '1',
                        'name' => 'Bob'
                    )
                )
            ),
    		new User(
                new Record(
                    $this->getPDO(),
                    'user',
                    array(
                        'id' => '2',
                        'name' => 'Alice'
                    )
                )
            ),
    	);
    	$actual = $this->finder->findAll();
    	$this->assertEquals($expected, $actual);
    }
}