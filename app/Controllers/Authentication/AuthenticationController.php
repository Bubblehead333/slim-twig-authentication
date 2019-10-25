<?php

namespace App\Controllers\Authentication;

use App\Models\User;
use App\Controllers\Controller;
use Respect\Validation\Validator as validator;


class AuthenticationController extends Controller
{
    public function getSignUp($request, $response)
    {
        return $this->view->render($response, 'authentication\signup.twig');
    }

    public function postSignUp($request, $response)
    {
        //Perform a validation check before data is sent to database
        $validation = $this->validator->validate($request,
            [
                'username' => validator::noWhitespace()->notEmpty(),
                'email' => validator::noWhitespace()->notEmpty(),
                'password' => validator::noWhitespace()->notEmpty(),
            ]
        );

        //Check if validation returned $errors
        if($validation->failed()) {
            return $response->withRedirect($this->router->pathFor('auth.signup'));

        }

        //Generates a create query with data from sign up form
        $user = User::create(
            [
                'username' => $request->getParam('username'),
                'email' => $request->getParam('email'),
                'password' => password_hash($request->getParam('password'), PASSWORD_DEFAULT),
            ]
        );

        return $response->withRedirect($this->router->pathFor('home'));
    }
}
