<?php
namespace Users\Route;

use Respect\Rest\Routable;
use Users\DataAccess\DataAccess;
use Users\Entity\User;

class OneUser implements Routable
{
    const HTTP_ERROR = 'HTTP/1.1 500';
    const HTTP_CREATED = 'HTTP/1.1 201';
    const MSG_CREATED = 'Usuário inserido com sucesso';
    const MSG_NOT_CREATED = 'Não foi possível inserir usuário';
    const MSG_UPDATED = 'Usuário alterado com sucesso';
    const MSG_NOT_UPDATED = 'Não foi possível alterar usuário';

    protected $dataAccess;

    public function __construct(DataAccess $dataAcces)
    {
        $this->dataAccess = $dataAcces;
    }

    public function get($id)
    {
        $user = $this->dataAccess->getById($id);

        return array(
            'name' => $user->getName(),
            'email' => $user->getEmail(),
        );
    }
}