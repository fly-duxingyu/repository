<?php


namespace Repository\Contracts;



use Repository\Eloquent\Criteria;

interface CriteriaInterface
{
    /**
     * @param Criteria $criteria
     * @return mixed
     */
    public function setCriteria(Criteria $criteria);

    /**
     * @param Criteria $criteria
     * @return mixed
     */

    /**
     * @return mixed
     */
    public function  applyCriteria();
}
