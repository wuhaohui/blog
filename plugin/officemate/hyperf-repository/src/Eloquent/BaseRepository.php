<?php

declare(strict_types=1);

namespace Officemate\Repository\Eloquent;


use App\Model\Model;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Collection;
use Officemate\Repository\Exceptions\RepositoryException;

class BaseRepository
{
    /**
     * @var Application
     */
    protected $app;


    /**
     * @var Model
     */
    protected $model;


    /**
     * @var array
     */
    protected $fieldSearchable = [];

    /**
     * Collection of Criteria
     *
     * @var Collection
     */
    protected $criteria;

    /**
     * @var bool
     */
    protected $skipCriteria = false;

    /**
     * @var bool
     */
    protected $skipPresenter = false;

    /**
     * @var PresenterInterface
     */
    protected $presenter;


    /**
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app      = $app;
        $this->criteria = new Collection();
        $this->makeModel();
        $this->makePresenter();
        $this->makeValidator();
        $this->boot();
    }


    /**
     * Specify Model class name
     *
     * @return string
     */
    abstract public function model();

    /**
     * @return Model
     * @throws RepositoryException
     */
    public function makeModel()
    {
        $model = $this->app->make($this->model());

        if (!$model instanceof Model) {
            throw new RepositoryException("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }

        return $this->model = $model;
    }

    public function makePresenter($presenter = null)
    {
        $presenter = !is_null($presenter) ? $presenter : $this->presenter();

        if (!is_null($presenter)) {
            $this->presenter = is_string($presenter) ? $this->app->make($presenter) : $presenter;

            if (!$this->presenter instanceof PresenterInterface) {
                throw new RepositoryException("Class {$presenter} must be an instance of Prettus\\Repository\\Contracts\\PresenterInterface");
            }

            return $this->presenter;
        }

        return null;
    }
}