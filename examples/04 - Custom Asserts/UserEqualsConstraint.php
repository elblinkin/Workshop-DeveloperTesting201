<?php

class UserEqualsConstraint
extends PHPUnit_Framework_Constraint {
	
	private $expected;

	public function __construct($expected) {
        $this->expected = $expected;
	}

	protected function matches($actual) {
		return $this->expected->getId() == $actual->getId()
		    && $this->expected->getFirstName() == $actual->getFirstName()
		    && $this->expected->getLastName() == $actual->getLastName()
		    && $this->expected->getAge() == $actual->getAge();
	}

	public function toString() {
		return sprintf(
			'is equal to %s.',
			PHPUnit_Util_Type::export($this->expected)
		);
	}
}


