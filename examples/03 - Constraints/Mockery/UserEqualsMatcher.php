<?php

use Mockery\Matcher\AbstractMatcher;

class UserEqualsMatcher extends AbstractMatcher {

	public function match(&$actual) {
		return $this->_expected->getId() == $actual->getId()
		    && $this->_expected->getFirstName() == $actual->getFirstName()
		    && $this->_expected->getLastName() == $actual->getLastName()
		    && $this->_expected->getAge() == $actual->getAge();
	}

	public function __toString() {
        return '<User Object Equals>';
	}
}

