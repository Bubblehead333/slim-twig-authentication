<?php

namespace App\Controllers;

use Slim\Views\Twig as View;
use App\Models\User;
/**
 * HomeController contains methods related to the rendering of the home or
 * index page.
 */
class HomeController extends Controller
{
    /**
     * This method renders the main home page view
     * @param  Request $request  [description]
     * @param  Response $response [description]
     * @return [type]           [description]
     */
    public function index($request, $response)
    {
        return $this->container->view->render($response, 'index.twig');
    }
}
