<?php
namespace Users;

use Users\Entity\User;
use Users\DataAccess\DataAccess;

class Users
{
    protected $dataAccess;

    public function __construct(DataAccess $data)
    {
        $this->dataAccess = $data;
    }

    public function acceptFromUserInput()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $postSpec = array(
                'name'     => FILTER_SANITIZE_STRING,
                'email'    => FILTER_SANITIZE_STRING,
                'password' => FILTER_SANITIZE_STRING,
            );

            $post = array_filter(filter_var_array($_POST, $postSpec));

            if (count($_POST) === count($post)) {
                $user = new User();
                $user->setName($post['name'])
                     ->setEmail($post['email'])
                     ->setPassword($post['password']);

                return $this->create($user);
            }
            throw new \UnexpectedValueException ('Unexpected post data');
        }
    }

    public function create(User $user)
    {
        return $this->dataAccess->insert($user);
    }
}