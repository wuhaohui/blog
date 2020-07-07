<?php


namespace Module\OMS\Controller;


use App\Controller\AbstractController;
use Hyperf\Di\Annotation\Inject;
use Hyperf\View\RenderInterface;
use Illuminate\Container\Container;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\App;
use Module\OMS\Model\B2bOrder;
use Module\OMS\Repository\B2bOrderRepository;

class OrderListController extends AbstractController
{
    /**
     * @var B2bOrderRepository
     */
    public $repository;

    public function index(B2bOrderRepository $repository)
    {
        $data = $repository->paginate(10)->toArray();
        var_dump($data);
    }
}