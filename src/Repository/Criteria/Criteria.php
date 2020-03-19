<?php


namespace Repository\Repository\Criteria;

use Repository\Repository\Contracts\RepositoryInterface as Repository;
use Repository\Repository\Contracts\RepositoryInterface;

abstract class Criteria
{
    /**
     * @param $model
     * @param RepositoryInterface $repository
     * @return mixed
     */
    public abstract function apply($model, Repository $repository);
}