<?php

namespace Finder;

use Model\User as UserModel;
use Record;

class User {
    
    private $pdo;

    function __construct($pdo) {
        $this->pdo = $pdo;
    }

    function create() {
        return new UserModel(
            new Record(
                $this->pdo,
                'user',
                array()
            )
        );
    }

    function find($id) {
        $statement = $this->pdo->prepare(
            'SELECT * FROM user WHERE id=:id'
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
            return new UserModel($this->hydrateFrom($row));
        }
    }

    function findAll() {
        $rows = $this->pdo->query(
            "SELECT * FROM user"
        );
        $users = array();
        foreach ($rows as $row) {
            $users[] = new UserModel($this->hydrateFrom($row));
        }
        return $users;
    }

    function hydrateFrom($row) {
        $stored_fields = array();
        foreach ($row as $key => $value) {
            if (is_int($key)) {
                continue;
            }
            $stored_fields[$key] = $value;
        }
        return new Record(
                $this->pdo,
                'user',
                $stored_fields
        );
    }
}