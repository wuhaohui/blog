<?php

declare(strict_types=1);

namespace Module\User\Controller;

use App\Controller\AbstractController;

class LoginController  extends AbstractController
{
    public function index()
    {
        return '正在登陆';
    }
}