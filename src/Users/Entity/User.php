<?php
namespace Users\Entity;

use \InvalidArgumentException as Argument;
use \Respect\Validation\Validator as V;

class User
{
    protected $name;
    protected $email;
    protected $password;

    public function setName($name)
    {
        if (!is_string($name)) {
            throw new Argument('O nome passado é inválido');
        }

        $this->name = $name;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setEmail($email)
    {
        if (! V::email()->validate($email)) {
            throw new Argument('Email invalido');
        }

        $this->email = $email;
        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }


    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    public function getPassword()
    {
        return $this->password;
    }
}