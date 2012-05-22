<?php

require_once 'UserEqualsConstraint.php';
require_once 'PHPUnit/Framework/Assert/Functions.php';

class UserAsserts {

	public static function assertEquals($expected, $actual, $message=null) {
        assertThat(
        	$actual,
        	new UserEqualsConstraint($expected),
        	$message
        );
	}

	public static function assertNotEquals($expected, $actual, $message=null) {
		assertThat(
			$actual,
			new PHPUnit_Framework_Constraint_Not(
				new UserEqualsConstraint($expected)
			),
			$message
		);
	}

	/* Level 1
	public static function assertEquals($expected, $actual) {
	    assertEquals(
	    	$expected->getId(), $actual->getId()
	    );
	    assertEquals(
            $expected->getFirstName(), $actual->getFirstName();
	    );
	    assertEquals(
	    	$expected->getLastName(), $actual->getLastName()
	    );
	    assertEquals(
	    	$expected->getAge(), $actual->getAge()
	    );
	}
	*/

    /* Level 2
	public static function assertEquals($expected, $actual, $message=null) {
        if ($expected->getId() == $actual->getId()
        	&& $expected->getFirstName() == $actual->getFirstName()
            && $expected->getLastName() == $actual->getLastName()
            && $expected->getAge() == $actual->getAge()
        ) {
        	return; // All is AWESOME!
        }

        if (isset($message)) {
            fail($message);
        } else {
        	fail(sprintf(
        		'Expected %s, but was %s.',
        		PHPUnit_Util_Type::export($expected),
        		PHPUnit_Util_Type::export($actual)
        	));
        }
	}
	*/
}