<?php
namespace Users\DataAccess;

use \PDO;
use Users\Entity\User;


class DataAccess
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function insert(User $user)
    {
        $stm = $this->pdo->prepare('
            INSERT INTO
                user (
                    name,
                    email,
                    password
                ) VALUES (
                    :name,
                    :email,
                    :password
                );
        ');

        $stm->bindValue(':name', $user->getName(), PDO::PARAM_STR);
        $stm->bindValue(':email', $user->getEmail(), PDO::PARAM_STR);
        $stm->bindValue(':password', $user->getPassword(), PDO::PARAM_STR);

        if ($stm->execute()) {
            return (int) $this->pdo->lastInsertId();
        }

        throw new \RuntimeException('Fail to insert data');
    }

    public function getById($id)
    {
        if (!is_int($id)) {
            $message = print_r($id, true) . 'is an invalid id';
            throw new \InvalidArgumentException($message);
        }

        $stm = $this->pdo->prepare('
            SELECT
                name,
                email,
                password
            FROM
                user
            WHERE
                id = :id;
        ');

        $stm->setFetchMode(PDO::FETCH_CLASS, 'Users\Entity\User');
        $stm->bindValue(':id', $id, PDO::PARAM_INT);

        if ($stm->execute()) {
            $user = $stm->fetch();

            $stm->closeCursor();
        }

        if (!$user instanceof User) {
            throw new \RuntimeException('Fail to retrieve user');
        }

        return $user;
    }

    public function getAll()
    {
        $stm = $this->pdo->prepare('
            SELECT
                id,
                name,
                email,
                password
            FROM
                user
        ');
        $stm->setFetchMode(PDO::FETCH_CLASS, 'Users\Entity\User');

        if ($stm->execute()) {
            return $stm->fetchAll();
        }

        throw new \RuntimeException('Fail to retrieve users');
    }
}