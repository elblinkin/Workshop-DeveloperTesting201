<?php

class Finder {
	
	private $pdo;

    function __construct($pdo) {
        $this->pdo = $pdo;
    }

    function create($table_name) {
        return new Record(
            $this->pdo,
            $table_name,
            array()
        );
    }

    function find($table_name, $id) {
        $statement = $this->pdo->prepare(
            sprintf(
                'SELECT * FROM %s WHERE id=:id',
                $table_name
            )
        );
        $statement->execute(
            array(
                ':id' => $id
            )
        );
        $row = $statement->fetch();
        if ($row === false) {
            return null;
        } else {
            return $this->hydrateFrom($table_name, $row);
        }
    }

    function findAll($table_name) {
        $statement = $this->pdo->prepare(
            sprintf(
                'SELECT * FROM %s',
                $table_name
            )
        );
        $statement->execute();
        $records = array();
        foreach ($statement as $row) {
            $records[] = $this->hydrateFrom($table_name, $row);
        }
        return $records;
    }

    function hydrateFrom($table_name, $row) {
    	$stored_fields = array();
    	foreach ($row as $key => $value) {
            if (is_int($key)) {
                continue;
            }
    		$stored_fields[$key] = $value;
    	}
    	return new Record(
    		$this->pdo,
    		$table_name,
    		$stored_fields
    	);
    }
}