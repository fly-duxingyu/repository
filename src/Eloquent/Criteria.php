<?php


namespace Repository\Eloquent;

use Repository\Contracts\RepositoryInterface as Repository;

abstract class Criteria
{
    public abstract function apply($model, Repository $repository);
}