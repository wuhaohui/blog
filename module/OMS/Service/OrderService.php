<?php


namespace Module\OMS\Service;


use Hyperf\Di\Annotation\Inject;
use Module\OMS\Repository\B2bOrderRepository;
use function App\app;

class OrderService extends BaseService
{
    /**
     * @Inject
     * @var B2bOrderRepository
     */
    protected $repository;


    /**
     * 指派订单列表
     * @param int $adminId
     * @param array $search
     */
    public function assignOrderList(int $adminId, array $search)
    {
        $data = app(B2bOrderRepository::class)->paginate(10);
        return true;
    }
}