<?php

namespace Model;

class User {
	
	private $record;

	function __construct($record) {
        $this->record = $record;
    }

    public function getId() {
        return $this->record->getField('id');
    }

    public function getName() {
        return $this->record->getField('name');
    }

    public function setName($name) {
        $this->record->setField('name', $name);
    }

    public function store() {
        $this->record->store();
    }
}