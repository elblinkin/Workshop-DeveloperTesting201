<?php

namespace Finder;

use Model\User as UserModel;

class User {
    
    private $finder;

    function __construct($finder) {
        $this->finder = $finder;
    }

    function create() {
        return new UserModel($this->finder->create('user')); 
    }

    function find($id) {
        return new UserModel(
            $this->finder->find('user', $id)
        );
    }

    function findAll() {
        return new UserModel(
            $this->finder->findAll('user')
        );
    }
}