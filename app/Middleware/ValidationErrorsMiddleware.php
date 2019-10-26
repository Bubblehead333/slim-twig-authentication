<?php

namespace App\Middleware;

class ValidationErrorsMiddleware extends Middleware
{
    protected $container;

    public function __invoke($request, $response, $next)
    {
        //Set view global variable for 'errors'
        $this->container->view->getEnvironment()->addGlobal('errors', $_SESSION['errors']);

        //Unset session variable after assigning container global
        unset($_SESSION['errors']);

        $response = $next($request, $response);
        return $response;
    }
}
