<?php


namespace Module\OMS\Repository;


use Illuminate\Contracts\Foundation\Application;
use Module\OMS\Model\B2bOrder;
use Officemate\Repository\Criteria\RequestCriteria;
use Officemate\Repository\Eloquent\BaseRepository;

/**
 * 订单数据仓库
 * Class OrderRepository
 * @package Module\OMS\Repository
 */
class B2bOrderRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'id',
        'orderInvoice.title' => 'like'
    ];

    public function boot()
    {
        $this->pushCriteria(RequestCriteria::class);
    }

    public function model()
    {
        return B2bOrder::class;
    }
}