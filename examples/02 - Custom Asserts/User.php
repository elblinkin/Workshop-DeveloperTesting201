<?php

class User {
	
	private $id;
	private $first_name;
	private $last_name;
	private $age;
	private $database;

	public function __construct(
		$id,
		$first_name,
		$last_name,
		$age,
		$database
	) {
		$this->id = $id;
		$this->first_name = $first_name;
		$this->last_name = $last_name;
		$this->age = $age;
		$this->database = $database;
	}

	public function getId() {
		return $this->id;
	}

	public function getFirstName() {
		return $this->first_name;
	}

	public function setFirstName($first_name) {
		$this->database->update($this, 'first_name', $first_name);
		$this->first_name = $first_name;
	}

	public function getLastName() {
		return $this->last_name;
	}

	public function setLastName($last_name) {
		$this->database->update($this, 'last_name', $last_name);
		$this->last_name = $last_name;
	}

	public function getAge() {
		return $this->age;
	}

	public function setAge($age) {
		$this->database->update($this, 'age', $age);
		$this->age = $age;
	}
}