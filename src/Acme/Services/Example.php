<?php namespace Acme\Services;

use Acme\Services\Cookie;
use Acme\Repositories\Homestead\UsersRepositoryInterface as User;

/*
 * This is obviously a highly oversimplified example. All we are doing here
 * is returning something from the Database Repository but in the real
 * world, this is where your logic goes.
 */
class Example
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getUser($id)
    {

        $user = $this->user->getById($id);

        return $user;
    }

}
