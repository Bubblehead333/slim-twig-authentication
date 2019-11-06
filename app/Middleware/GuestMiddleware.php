<?php

namespace App\Middleware;
/**
 *  This ensure that only certain pages can be accessed when a User is NOT
 *  logged in.
 */
class GuestMiddleware extends Middleware
{
    public function __invoke($request, $response, $next)
    {
        if($this->container->authentication->check()) {
            return $response->withRedirect($this->container->router->pathFor('home'));
        }

        $response = $next($request, $response);
        return $response;
    }
}
