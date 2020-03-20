<?php


namespace Repository\Contracts;


interface  RepositoryInterface
{
    /**
     * 查询所有all
     * @param array $columns //需要查询的字段
     * @return mixed
     */
    public function all($columns = array('*'));

    /**
     * 分页查询
     * @param $perPage //每页条数
     * @param array $columns //查询的字段
     * @return mixed
     */
    public function paginate($perPage = 1, $columns = array('*'));

    /**
     * 创建
     * @param array $data
     * @return mixed
     */
    public function create(array $data);

    /**
     * @param array $data
     * @return bool
     */
    public function saveModel(array $data);

    /**
     * @param array $data
     * @param $id
     * @return mixed
     */
    public function update(array $data, $id);

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id);

    /**
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function find($id, $columns = array('*'));

    /**
     * @param $field
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function findBy($field, $value, $columns = array('*'));

    /**
     * @param $field
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function findAllBy($field, $value, $columns = array('*'));

    /**
     * @param $where
     * @param array $columns
     * @return mixed
     */
    public function findWhere($where, $columns = array('*'));

}