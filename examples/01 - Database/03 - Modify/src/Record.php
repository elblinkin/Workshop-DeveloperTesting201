<?php

class Record {
	
	private $pdo;
	private $table_name;
	private $stored_fields;
	private $dirty_fields;

	function __construct(
		$pdo,
		$table_name,
		array $stored_fields = array(),
		array $dirty_fields = array()
	) {
		$this->pdo = $pdo;
		$this->table_name = $table_name;
		$this->stored_fields = $stored_fields;
		$this->dirty_fields = $dirty_fields;
	}

	function getField($name) {
		if (array_key_exists($name, $this->dirty_fields)) {
            return $this->dirty_fields[$name];
		} else if (array_key_exists($name, $this->stored_fields)) {
            return $this->stored_fields[$name];
		}
		return null;
	}

	function setField($name, $value) {
		if ($name === 'id') {
			throw new InvalidArgumentException('Attempted to modify "id"');
		}
		$this->dirty_fields[$name] = $value;
	}

	function store() {
		if (empty($this->dirty_fields)) {
			return false;  // Nothing to change
		}
		$sql = sprintf('UPDATE %s SET', $this->table_name);
		foreach ($this->dirty_fields as $column => $field) {
			$sql .= sprintf(" %s='%s' ", $column, $field);
		}
		$sql .= sprintf('WHERE id=%s', $this->stored_fields['id']);

		$statement = $this->pdo->prepare($sql);
		if ($statement->execute() === false) {
			throw new RuntimeException(
				sprintf(
					'Failed to update record with id=%s',
					$id
				)
			);
		}
		$this->stored_fields = array_merge($this->stored_fields, $this->dirty_fields);
		$this->dirty_fields = array();
		return true;
	}
}