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
        $request = new \Hyperf\HttpServer\Request();
        return $request->input($this->paramsFiled, []);
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
        return $model;
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

        foreach ($allowSearchParams as $field => $condition) {

            if (isset($params[$field])) {
                continue;
            }

            if (is_numeric($field)) {
                $field     = $condition;
                $condition = '=';
            }
            $value = $params[$field];

            if (stripos($field, '.')) {
                $explode  = explode('.', $field);
                $field    = array_pop($explode);
                $relation = implode('.', $explode);
            }

            $modelTableName = $model->getModel()->getTable();

            if (!empty($relation)) {
                $model = $model->whereHas($relation, function ($query) use ($field, $condition, $value) {
                    $query = $this->fileWhere($query, $field, $condition, $value);
                    return $query;
                });
            } else {
                $model = $this->fileWhere($model,$modelTableName . '.' . $field, $condition, $value);
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
            case empty($operator) || $operator == '=':
                $model = $model->where($column, $value);
                break;
            case ($operator == 'in'):
                $model = $model->whereIn($column, $value);
                break;
            case ($operator == 'between'):
                $model = $model->whereBetween($column, $value);
                break;
            case ($operator == 'like'):
                $model = $model->where($column, 'like', $value);
                break;
        }

        return $model;
    }

}