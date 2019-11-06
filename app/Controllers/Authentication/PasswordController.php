<?php

namespace App\Controllers\Authentication;

use App\Models\User;
use App\Controllers\Controller;
use Respect\Validation\Validator as validator;


class PasswordController extends Controller
{
    public function getChangePassword($request, $response)
    {
        return $this->view->render($response, 'authentication/password/change-password.twig');
    }

    public function postChangePassword($request, $response)
    {
        $validation = $this->validator->validate($request, [
            'password_old' => validator::noWhitespace()->notEmpty()->matchesPassword($this->authentication->user()->password),
            'password' => validator::noWhitespace()->notEmpty(),
        ]);

        if($validation->failed()) {
            return $response->withRedirect($this->router->pathFor('authentication.password.change'));
        }

        $this->authentication->user()->setPassword($request->getParam('password'));
        $this->flash->addMessage('info', 'Your password was successfully changed.');

        return $response->withRedirect($this->router->pathFor('home'));
    }
}
