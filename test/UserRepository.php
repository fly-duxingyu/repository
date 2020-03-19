<?php


class UserRepository extends \Repository\Eloquent\Repository
{

    function model()
    {
        return 'Bosnadev\Models\Actor';
    }
}