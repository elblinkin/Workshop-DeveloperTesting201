<?php

require_once 'Hamcrest/BaseMatcher.php';
require_once 'Hamcrest/Description.php';

class UserEqualsConstraint extends Hamcrest_BaseMatcher {

	private $expected;

	public function __construct($expected) {
		$this->expected = $expected;
	}

	public function matches($actual) {
		return $this->expected->getId() == $actual->getId()
		    && $this->expected->getFirstName() == $actual->getFirstName()
		    && $this->expected->getLastName() == $actual->getLastName()
		    && $this->expected->getAge() == $actual->getAge();
	}

	public function describeTo(Hamcrest_Description $description) {
		$description->appendValue($this->expected);
	}
}

