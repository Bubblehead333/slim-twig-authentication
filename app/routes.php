<?php

use App\Middleware\AuthenticationMiddleware;
use App\Middleware\GuestMiddleware;


/*
* Create your routes to all URLs here. Make sure the first argument of the get
* method is the API path, and the second a link to an existing Class:method.
* This method can then return a rendered twig template.
*/


$app->get('/', 'HomeController:index')->setName('home');

//These routes should only be accessed if a user is NOT signed in
$app->group('', function () {
    //Authentication routes
    $this->get('/authentication/signup', 'AuthenticationController:getSignUp')->setName('authentication.signup');
    $this->post('/authentication/signup', 'AuthenticationController:postSignUp');

    //Sign In routes
    $this->get('/authentication/signin', 'AuthenticationController:getSignIn')->setName('authentication.signin');
    $this->post('/authentication/signin', 'AuthenticationController:postSignIn');
})->add(new GuestMiddleware($container));



//These routes should only be accessed if a user is signed in
$app->group('', function () {

    //Sign Out routes
    $this->get('/authentication/signout', 'AuthenticationController:getSignOut')->setName('authentication.signout');

    //Password routes
    $this->get('/authentication/password/change', 'PasswordController:getChangePassword')->setName('authentication.password.change');
    $this->post('/authentication/password/change', 'PasswordController:postChangePassword');

})->add(new AuthenticationMiddleware($container));
