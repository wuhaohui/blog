<?php


namespace Officemate\Repository\Criteria;


use Hyperf\Database\Model\Builder;
use Illuminate\Support\Facades\Request;
use Module\OMS\Model\Model;
use Officemate\Repository\Contracts\CriteriaInterface;
use Officemate\Repository\Contracts\RepositoryInterface;
use Officemate\Repository\Eloquent\BaseRepository;

class RequestCriteria implements CriteriaInterface
{
    protected $paramsFiled = 'search';

    /**
     * @var BaseRepository
     */
    protected $repository;

    /**
     * @var string
     * join 利用 left join 连表查询
     * exists 利用 exists 查询结果
     */
    protected $searchWay = 'exists';//查询方式

    /**
     * 获取搜索的字段
     * return array
     */
    protected function getParams()
    {
        return Request::input($this->paramsFiled);
    }

    /**
     * 可查询字段规则
     * @return array
     */
    public function getFieldsSearchable(): array
    {
        return $this->repository->getFieldsSearchable();
    }


    /**
     * @param $model
     * @param RepositoryInterface $repository
     * @return mixed|void
     */
    public function apply($model, RepositoryInterface $repository)
    {
        $this->repository = $repository;
        $model            = $this->{$this->searchWay . 'Builder'}($model, $repository);
    }

    /**
     * @param Builder $model
     * @param BaseRepository $repository
     */
    protected function joinBuilder($model, $repository)
    {
        $params            = $this->getParams();//获取查询的字段
        $allowSearchParams = $this->getFieldsSearchable();//可搜索字段

        $tables = [];
        foreach ($params as $column => $value) {
            if (array_key_exists($column, $allowSearchParams)) {
                $operator = $allowSearchParams[$column];
                $this->fileWhere($model, $column, $operator, $value);
            }
        }

    }

    /**
     * @param $model
     */
    protected function existsBuilder($model)
    {
        $params            = $this->getParams();//获取查询的字段
        $allowSearchParams = $this->getFieldsSearchable();//可搜索字段

        foreach ($params as $field => $value) {

            $condition = $allowSearchParams[$field];

            if (stripos($field, '.')) {
                $explode  = explode('.', $field);
                $field    = array_pop($explode);
                $relation = implode('.', $explode);
            }

            $modelTableName = $model->getModel()->getTable();

            if (!empty($relation)) {
                $model->whereHas($relation, function ($query) use ($field, $condition, $value) {
                    $query = $this->fileWhere($query, $field, $condition, $value);
                    return $query;
                });
            } else {
                $model->where($modelTableName . '.' . $field, $condition, $value);
            }
        }

        return $model;
    }

    /**
     *  * 填充搜索条件
     * @param Builder $model
     * @param $column
     * @param $operator
     * @param $value
     */
    protected function fileWhere($model, $column, $operator, $value)
    {
        switch ($operator) {
            case empty($operator):
                $model->where($column, $value);
                break;
            case ($operator == 'in'):
                $model->whereIn($column, $value);
                break;
            case ($operator == 'between'):
                $model->whereBetween($column, $value);
                break;
            case ($operator == 'like'):
                $model->where($column, 'like', $value);
                break;
        }

        return $model;
    }

}