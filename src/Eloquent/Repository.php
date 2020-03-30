<?php


namespace Repository\Eloquent;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Container\Container as App;
use Repository\Contracts\CriteriaInterface;
use Repository\Contracts\RepositoryInterface;
use Illuminate\Support\Collection;

abstract class Repository implements RepositoryInterface, CriteriaInterface
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
     * @var Collection
     */
    protected $criteria;

    /**
     * @param App $app
     * @throws \ErrorException
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
     * @param array $columns
     * @return Model|mixed
     */
    public function all($columns = array('*'))
    {
        $this->applyCriteria();
        return $this->model->get($columns);
    }

    /**
     * @param int $perPage
     * @param array $columns
     * @return Model|mixed
     */
    public function paginate($perPage = 15, $columns = array('*'))
    {
        $this->applyCriteria();
        return $this->model->paginate($perPage, $columns);
    }

    /**
     * @param array $data
     * @return Model|mixed
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * @param array $data
     * @param $id
     * @param string $attribute
     * @return int|mixed
     */
    public function update(array $data, $id, $attribute = "id")
    {
        $this->applyCriteria();
        return $this->model->where($attribute, '=', $id)->update($data);
    }

    /**
     * @param $id
     * @return int|mixed
     */
    public function delete($id)
    {
        $this->applyCriteria();
        return $this->model()::destroy($id);
    }

    /**
     * @param $id
     * @param array $columns
     * @return Model|mixed
     */
    public function find($id, $columns = array('*'))
    {
        $this->applyCriteria();
        return $this->model->find($id, $columns);
    }

    /**
     * @return Builder
     * @throws \ErrorException
     */
    public function makeModel()
    {
        $model = $this->app->make($this->model());

        if (!$model instanceof Model)
            throw new \ErrorException("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");

        return $this->model = $model->newQuery();
    }

    /**
     * @param array $data
     * @return bool
     */
    public function saveModel(array $data)
    {
        foreach ($data as $k => $v) {
            $this->model->$k = $v;
        }
        return $this->model->save();
    }

    /**
     * @param array $relations
     * @return $this
     */
    public function with(array $relations)
    {
        $this->model = $this->model->with($relations);
        return $this;
    }

    /**
     * @param Criteria $criteria
     * @return $this|mixed
     */
    public function setCriteria(Criteria $criteria)
    {
        $this->criteria = $criteria;
        return $this;
    }

    /**
     * @return $this
     */
    public function applyCriteria()
    {
        if ($this->criteria) {
            $this->model = $this->criteria->apply($this->model, $this);
        }
        return $this;
    }

}
