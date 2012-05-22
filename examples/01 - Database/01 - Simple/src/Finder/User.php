<?php

namespace Finder;

use Model\User as UserModel;

class User {
    
    private $pdo;

    function __construct($pdo) {
        $this->pdo = $pdo;
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
            return $this->hydrateFrom($row);
        }
    }

    function findAll() {
        $rows = $this->pdo->query(
            "SELECT * FROM user"
        );
        $users = array();
        foreach ($rows as $row) {
            $users[] = $this->hydrateFrom($row);
        }
        return $users;
    }

    function hydrateFrom($row) {
        return new UserModel(
            $row['id'],
            $row['name']
        );
    }
}