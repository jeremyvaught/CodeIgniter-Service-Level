<?php namespace Acme\Repositories;

/*
 * You'll recognize this from Laracasts.
 *
 * Also, I set everything ->toArray() at this point. This is to keep keep the
 * data universal. Do a quick search about using Eloquent in your Repository
 * Pattern or in your Hexagonal Architecture and you can read the arguments for
 * and against for months.
 */
abstract class EloquentRepository
{
    protected $model;

    function __construct($model)
    {
        $this->$model = $model;
    }

    /*
     * Explicitly set null for ->toArray() if it is so
     */
    public function getById($id)
    {
        $return = $this->model->find($id);

        if ($return == null)
        {
            $return = null;
        } else {
            $return = $return->toArray();
        }
        return $return;
    }

    public function getAll()
    {
        return $this->model->all()->toArray();
    }
}
