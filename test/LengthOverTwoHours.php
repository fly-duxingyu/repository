<?php


class LengthOverTwoHours extends \Repository\Repository\Criteria\Criteria
{

    /**
     * @inheritDoc
     */
    public function apply($model, \Repository\Repository\Contracts\RepositoryInterface $repository)
    {
        $model = $model->where('length', '>', 120);
        return $model;
    }
}