<?php

require_once 'Finder/User.php';
require_once 'Model/User.php';
require_once 'Record.php';

require_once 'Testing/DBUnit/TestCase.php';

require_once 'PHPUnit/Extensions/Database/DataSet/ArrayDataSet.php';

use Finder\User as UserFinder;
use Model\User as User;
use Testing\DBUnit\TestCase as DBUnitTestCase;

class RecordTest extends DBUnitTestCase {

    private $record;

    private $modified_dataset;
    private $modified_table;

    protected function setUp() {
    	parent::setUp();
        $this->record = new Record(
            $this->getPDO(),
            'user',
            array(
                'id' => 1,
                'name' => 'Bob'
            )
        );

        $this->modified_dataset = new PHPUnit_Extensions_Database_DataSet_ArrayDataSet(
            array(
                'user' => array(
                    array('id' => 1, 'name' => 'Bobby'),
                    array('id' => 2, 'name' => 'Alice'),
                ),
            )
        );
        $this->modified_table = $this->modified_dataset->getTable('user');
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

    public function testGetField() {
        $this->assertEquals(
            'Bob',
            $this->record->getField('name')
        );
    }

    public function testGetField_modifiedNotStored() {
        $this->record->setField('name', 'Bobby');
        $this->assertEquals(
            'Bobby',
            $this->record->getField('name')
        );
    }

    public function testGetField_modifiedAndStored() {
        $this->record->setField('name', 'Bobby');
        $this->record->store();
        $this->assertEquals(
            'Bobby',
            $this->record->getField('name')
        );
    }

    public function testGetField_doesNotExist() {
        $this->assertNull(
            $this->record->getField('does_not_exist')
        );
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testSetField_id() {
        $this->record->setField('id', 2);
    }

    public function testSetField_doesNotModifyDB() {
        $this->record->setField('name', 'Bobby');
        $expected = $this->getDataSet()->getTable('user');
        $actual = $this->getConnection()
            ->createQueryTable(
                'user',
                'SELECT * FROM user'
            );
        $this->assertTablesEqual($expected, $actual);
    }

    public function testStore_notModified() {
        $this->record->store();
        $expected = $this->getDataSet()->getTable('user');
        $actual = $this->getConnection()
            ->createQueryTable(
                'user',
                'SELECT * FROM user'
            );
        $this->assertTablesEqual($expected, $actual);
    }

    public function testStore_modified() {
        $this->record->setField('name', 'Bobby');
        $this->record->store();

        $modified_dataset = new PHPUnit_Extensions_Database_DataSet_ArrayDataSet(
            array(
                'user' => array(
                    array('id' => 1, 'name' => 'Bobby'),
                    array('id' => 2, 'name' => 'Alice'),
                ),
            )
        );
        $expected = $modified_dataset->getTable('user');
        $actual = $this->getConnection()
            ->createQueryTable(
                'user',
                'SELECT * FROM user'
            );
        $this->assertTablesEqual($expected, $actual);
    }
}