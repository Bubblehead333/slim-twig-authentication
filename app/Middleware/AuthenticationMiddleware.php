<?php

namespace App\Middleware;
/**
 * This ensures that only certain pages can be accessed when a User is logged in.
 */
class AuthenticationMiddleware extends Middleware
{
    public function __invoke($request, $response, $next)
    {
        if(!$this->container->authentication->check()) {
            $this->container->flash->addMessage('info', 'You must be signed in to access this page.');
            return $response->withRedirect($this->container->router->pathFor('authentication.signin'));
        }

        $response = $next($request, $response);
        return $response;
    }
}
