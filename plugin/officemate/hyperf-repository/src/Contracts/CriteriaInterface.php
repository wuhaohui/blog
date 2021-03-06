<?php


namespace Officemate\Repository\Contracts;


interface CriteriaInterface
{
    /**
     * Apply criteria in query repository
     *
     * @param                     $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository);

    /**
     * @return array
     */
    public function getFieldsSearchable(): array;
}