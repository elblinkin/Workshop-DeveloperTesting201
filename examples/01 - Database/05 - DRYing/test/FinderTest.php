<?php

require_once 'Finder.php';
require_once 'Model/User.php';
require_once 'Record.php';

require_once 'Testing/DBUnit/TestCase.php';

require_once 'PHPUnit/Extensions/Database/DataSet/ArrayDataSet.php';

use Model\User as User;
use Testing\DBUnit\TestCase as DBUnitTestCase;

class FinderTest extends DBUnitTestCase {

    protected function setUp() {
    	parent::setUp();
    	$this->finder = new Finder($this->getPDO());
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

    public function testCreate_returnsRecord() {
        $user = $this->finder->create('user');
        $this->assertInstanceOf('Record', $user);
    }

    public function testCreate_doesNotModifyTable() {
        $this->finder->create('user');
        $expected = $this->getDataSet()->getTable('user');
        $actual = $this->getConnection()
            ->createQueryTable(
                'user',
                'SELECT * FROM user'
            );
        $this->assertTablesEqual($expected, $actual);
    }

    public function testFind_exists() {
    	$expected = new Record(
            $this->getPDO(),
            'user',
            array(
                'id' => '1',
                'name' => 'Bob'
            )
        );
        $actual = $this->finder->find('user', 1);
        $this->assertEquals($expected, $actual);
    }

    public function testFind_doesNotExist() {
        $this->assertNull($this->finder->find('user', 3));
    }

    public function testFindAll() {
    	$expected = array(
    		new Record(
                $this->getPDO(),
                'user',
                array(
                    'id' => '1',
                    'name' => 'Bob'
                )
            ),
            new Record(
                $this->getPDO(),
                'user',
                array(
                    'id' => '2',
                    'name' => 'Alice'
                )
            ),
    	);
    	$actual = $this->finder->findAll('user');
    	$this->assertEquals($expected, $actual);
    }
}