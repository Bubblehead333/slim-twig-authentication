<?php

namespace App\Controllers;

use Slim\Views\Twig as View;
use App\Models\User;

class HomeController extends Controller
{
    public function index($request, $response)
    {
        $user = User::find(1);
        $user = User::where('username'. 'Bubblehead')->
        var_dump($user);
        die();
        return $this->container->view->render($response, 'index.twig');
    }

}
