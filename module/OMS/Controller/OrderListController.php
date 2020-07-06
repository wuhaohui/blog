<?php


namespace Module\OMS\Controller;


use App\Controller\AbstractController;
use Hyperf\Di\Annotation\Inject;
use Hyperf\View\RenderInterface;
use Module\OMS\Model\B2bOrder;
use Module\OMS\Repository\B2bOrderRepository;

class OrderListController extends AbstractController
{
    /**
     * @Inject
     * @var B2bOrderRepository
     */
    public $repository;

    public function index()
    {
        print_r($this->repository->model());
//        $data = $this->repository->get();
//        print_r($data);
    }
}