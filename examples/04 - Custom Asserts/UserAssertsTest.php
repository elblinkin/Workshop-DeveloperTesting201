<?php

require_once 'Database.php';
require_once 'User.php';
require_once 'UserAsserts.php';

class UserAssertsTest
extends PHPUnit_Framework_TestCase {
	
	public function testAssertEquals_sameDatabase() {
		$database = $this->getMock('Database');

		$user1 = new User(1, 'Bob', 'Johnson', 29, $database);
		$user2 = new User(1, 'Bob', 'Johnson', 29, $database);
		UserAsserts::assertEquals($user1, $user2);
	}

	public function testAssertEquals_differentDatabase() {
		$database1 = $this->getMock('Database');
		$database2 = $this->getMock('Database');

		$user1 = new User(1, 'Bob', 'Johnson', 29, $database1);
		$user2 = new User(1, 'Bob', 'Johnson', 29, $database2);
		UserAsserts::assertEquals($user1, $user2);
	}

    /**
     * @expectedException PHPUnit_Framework_AssertionFailedError
     * @expectedExceptionMessage is equal to User Object
     */
	public function testAssertEquals_differentUser() {
		$database = $this->getMock('Database');
		$user1 = new User(1, 'Bob', 'Johnson', 29, $database);
		$user2 = new User(2, 'Alice', 'Johnson', 26, $database);
		UserAsserts::assertEquals($user1, $user2);
	}

    /**
     * @expectedException PHPUnit_Framework_AssertionFailedError
     * @expectedExceptionMessage is not equal to User Object
     */
	public function testAssertNotEquals_sameUsersameDatabase() {
		$database = $this->getMock('Database');
		$user1 = new User(1, 'Bob', 'Johnson', 29, $database);
		$user2 = new User(1, 'Bob', 'Johnson', 29, $database);
		UserAsserts::assertNotEquals($user1, $user2);
	}


    /**
     * @expectedException PHPUnit_Framework_AssertionFailedError
     * @expectedExceptionMessage is not equal to User Object
     */
	public function testAssertEquals_sameUserDifferentDatabase() {
		$database1 = $this->getMock('Database');
		$database2 = $this->getMock('Database');

		$user1 = new User(1, 'Bob', 'Johnson', 29, $database1);
		$user2 = new User(1, 'Bob', 'Johnson', 29, $database2);
		UserAsserts::assertNotEquals($user1, $user2);
	}

	public function testAssertNotEquals_differentUser() {
		$database = $this->getMock('Database');
		$user1 = new User(1, 'Bob', 'Johnson', 29, $database);
		$user2 = new User(2, 'Alice', 'Johnson', 26, $database);
		UserAsserts::assertNotEquals($user1, $user2);
	}


}