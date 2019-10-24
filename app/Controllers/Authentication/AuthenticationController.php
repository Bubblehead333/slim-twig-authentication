<?php

namespace App\Controllers\Authentication;

use App\Controllers\Controller;
use Slim\Views\Twig as View;
use App\Models\User;


class AuthenticationController extends Controller
{
    public function getSignUp($request, $response)
    {
        return $this->view->render($response, 'authentication\signup.twig');
    }

    public function postSignUp($request, $response)
    {
        $user = User::create([
            'username' => $request->getParam('username'),
            'email' => $request->getParam('email'),
            'password' => password_hash($request->getParam('password'), PASSWORD_DEFAULT),

        ]);

        return $response->withRedirect($this->router->pathFor('home'));
    }
}
