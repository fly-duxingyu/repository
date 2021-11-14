<?php

namespace Duxingyu\Repository\Eloquent;

use Duxingyu\Repository\Contracts\RepositoryInterface;
use ErrorException;
use Illuminate\Container\Container;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

abstract class Repository implements RepositoryInterface
{
    /**
     * @var Container
     */
    private $app;

    /**
     * @var  Model | \Illuminate\Database\Eloquent\Builder | \Illuminate\Database\Eloquent\Collection | \Illuminate\Database\Query\Builder
     */
    public $model;

    public static $table_name;


    /**
     * @throws ErrorException|BindingResolutionException
     */
    public function __construct()
    {
        $this->app = new Container();
        $this->makeModel();
    }

    /**
     * Specify Model class name
     *
     * @return Model|string
     */
    abstract function model();


    /**
     * @return Builder
     * @throws ErrorException|BindingResolutionException
     */
    public function makeModel()
    {
        $model = $this->app->make($this->model());

        if (!$model instanceof Model)
            throw new ErrorException("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        self::$table_name = $model->getTable();
        return $this->model = $model;
    }
}
