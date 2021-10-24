<?php

namespace Duxingyu\Repository\Eloquent;

use Duxingyu\Repository\Contracts\RepositoryInterface;
use ErrorException;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Container\Container as App;

abstract class Repository implements RepositoryInterface
{
    /**
     * @var App
     */
    private $app;

    /**
     * @var  Model
     */
    protected $model;

    /**
     * @param App $app
     * @throws ErrorException|BindingResolutionException
     */
    public function __construct(App $app)
    {
        $this->app = $app;
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

        return $this->model = $model->newQuery();
    }

}
