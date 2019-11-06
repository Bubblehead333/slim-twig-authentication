<?php

namespace App\Controllers\Authentication;

use App\Models\User;
use App\Controllers\Controller;
use Respect\Validation\Validator as validator;

/**
 * AuthenticationController handles all User signing in, signing up and logging
 * out processes.
 * Validation rules are enforced to ensure correct information is used.
 */
class AuthenticationController extends Controller
{
    /**
     * Signs out current user in session
     * @param  Request $request  [description]
     * @param  Response $response [description]
     * @return [type]           [description]
     */
    public function getSignOut($request, $response)
    {
        $this->authentication->logout();
        return $response->withRedirect($this->router->pathFor('home'));
    }

    /**
     * Renders the view for allowing a user to sign in
     * @return [type] [description]
     */
    public function getSignIn($request, $response)
    {
        return $this->view->render($response, 'authentication/signin.twig');
    }

    /**
     * Processes input from sign in form, signs User in if credentials
     * are correct.
     * @param  Request $request  [description]
     * @param  Response $response [description]
     * @return [type]           [description]
     */
    public function postSignIn($request, $response)
    {
        //Using for inputs, attempt to authenticate user
        $authentication = $this->authentication->attempt(
            $request->getParam('email'),
            $request->getParam('password')
        );

        //If authentication failed, redirect with error message
        if(!$authentication) {
            return $response->withRedirect($this->router->pathFor('authentication.signin'));
        }
        return $response->withRedirect($this->router->pathFor('home'));
    }

    /**
     * This method renders the view for allowing a user to register as a
     * new user.
     * @param Request $request  [description]
     * @param Response $response [description]
     * @return View             Shows the signup form
     */
    public function getSignUp($request, $response)
    {
        return $this->view->render($response, 'authentication\signup.twig');
    }

    /**
     * This method accepts form data, validates it, if validation passes,
     * creates a new user in the database.
     * @param  Request $request  [description]
     * @param  Response $response [description]
     * @return http_redirect      Redirects to home page
     */
    public function postSignUp($request, $response)
    {
        //Perform a validation check before data is sent to database
        $validation = $this->validator->validate($request,
            [
                'username' => validator::noWhitespace()->notEmpty(),
                'email' => validator::noWhitespace()->notEmpty()->email()->EmailAvailable(),
                'password' => validator::noWhitespace()->notEmpty(),
            ]
        );

        //Check if validation returned $errors, redirect if validation returned
        //errors.
        if($validation->failed()) {
            $this->flash->addMessage('error', 'Details do not match an account.');
            return $response->withRedirect($this->router->pathFor('authentication.signup'));
        }

        //Generates a create query with data from sign up form
        $user = User::create(
            [
                'username' => $request->getParam('username'),
                'email' => $request->getParam('email'),
                'password' => password_hash($request->getParam('password'), PASSWORD_DEFAULT),
            ]
        );
        $this->flash->addMessage('info', 'Account created successfully!');
        $this->authentication->attempt($user->email, $request->getParam('password'));

        return $response->withRedirect($this->router->pathFor('home'));
    }
}
