<?php
namespace Users\Route;

use Respect\Rest\Routable;
use Users\DataAccess\DataAccess;

class AllUsers implements Routable
{
    protected $dataAccess;

    public function __construct(DataAccess $data)
    {
        $this->dataAccess = $data;
    }

    public function get()
    {
        return $this->dataAccess->getAll();
    }
}