<?php namespace Acme\Repositories\Homestead;

interface UsersRepositoryInterface {
    public function getAll();
    public function getById($id);
}
