<?php
namespace Users\Route;

use Respect\Rest\Routable;
use Users\DataAccess\DataAccess;
use Users\Entity\User;
use Users\Users;

class OneUser implements Routable
{
    const HTTP_ERROR = 'HTTP/1.1 500';
    const HTTP_CREATED = 'HTTP/1.1 201';
    const MSG_CREATED = 'Usuário inserido com sucesso';
    const MSG_NOT_CREATED = 'Não foi possível inserir usuário';
    const MSG_UPDATED = 'Usuário alterado com sucesso';
    const MSG_NOT_UPDATED = 'Não foi possível alterar usuário';

    protected $dataAccess;
    protected $users;

    public function __construct(DataAccess $dataAcces, Users $users)
    {
        $this->dataAccess = $dataAcces;
        $this->users      = $users;
    }

    public function get($id)
    {
        $user = $this->dataAccess->getById($id);

        return array(
            'name' => $user->getName(),
            'email' => $user->getEmail(),
        );
    }

    public function post()
    {
        if ($this->users->acceptFromUserInput()) {
            header(self::HTTP_CREATED.' '.self::MSG_CREATED);
            return new AllUsers($this->dataAccess);
        }
        header(self::HTTP_ERROR.' '.self::MSG_NOT_CREATED);
        return self::MSG_NOT_CREATED;
    }
}