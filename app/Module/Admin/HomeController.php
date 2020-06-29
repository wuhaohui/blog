<?php

declare(strict_types=1);

namespace App\Module\Admin;

use App\Controller\AbstractController;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\View\RenderInterface;

/**
 * Class HomeController
 * @package App\Module\Admin
 */
class HomeController extends AbstractController
{

    public function index(RequestInterface $request,RenderInterface $view)
    {

        $id = $request->input('id', '0');
        return $view->render('admin/home/index',['id' => $id]);
    }
}