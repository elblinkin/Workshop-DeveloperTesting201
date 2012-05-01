<?php




		$verifier = $this->getMock('Verifier');
		$verifier
		    ->expects($this->atLeastOnce())
		    ->method('isOldEnough')
		    ->with(new UserEqualsConstraint(
		    	new User(1, 'Bob', 'Johnson', 29, $database)
		    ))
		    ->will($this->returnValue(true));

