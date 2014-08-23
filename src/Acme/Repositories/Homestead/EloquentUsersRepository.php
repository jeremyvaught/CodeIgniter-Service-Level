<?php namespace Acme\Repositories\Homestead;

use Acme\Repositories\EloquentRepository;
use Acme\Models\Eloquent\Homestead\Users;

class EloquentUsersRepository extends EloquentRepository implements UsersRepositoryInterface
{
    protected $model;

    public function __construct(Users $model)
    {
        $this->model = $model;
    }

    /*-------------------------------------------------------------------------
    | Override below or supplement any methods from the interface
    |--------------------------------------------------------------------------
    */

}
