<?php

declare(strict_types=1);

namespace Officemate\Repository\Eloquent;


use App\Model\Model;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Collection;

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
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
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
}