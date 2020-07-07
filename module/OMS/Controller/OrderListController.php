<?php


namespace Module\OMS\Controller;


use App\Controller\AbstractController;
use Hyperf\Contract\ContainerInterface;
use Module\OMS\Repository\B2bOrderRepository;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Module\OMS\Service\OrderService;
use Hyperf\Di\Annotation\Inject;
use Psr\Http\Message\ResponseInterface as Psr7ResponseInterface;

class OrderListController extends AbstractController
{

    /**
     * @param B2bOrderRepository $repository
     * @param ResponseInterface $response
     * @return Psr7ResponseInterface
     */
    public function index(B2bOrderRepository $repository, ResponseInterface $response): Psr7ResponseInterface
    {
        $data = $repository
            ->with(['orderInvoice'])
            ->paginate(10);

        $service = new OrderService();
        $service->assignOrderList(2784, []);

        return $response->json($data->toArray());
    }
}