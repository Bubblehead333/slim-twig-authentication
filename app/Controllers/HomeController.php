<?php

namespace App\Controllers;

use Slim\Views\Twig as View;
use App\Models\User;

class HomeController extends Controller
{
    public function index($request, $response)
    {
        return $this->container->view->render($response, 'index.twig');
    }
}
