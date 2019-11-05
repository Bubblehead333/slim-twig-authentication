<?php

/*
* Create your routes to all URLs here. Make sure the first argument of the get
* method is the API path, and the second a link to an existing Class:method.
* This method can then return a rendered twig template.
*/

$app->get('/', 'HomeController:index')->setName('home');

//Authentication routes
$app->get('/authentication/signup', 'AuthenticationController:getSignUp')->setName('authentication.signup');
$app->post('/authentication/signup', 'AuthenticationController:postSignUp');

//Sign In routes
$app->get('/authentication/signin', 'AuthenticationController:getSignIn')->setName('authentication.signin');
$app->post('/authentication/signin', 'AuthenticationController:postSignIn');

//Sign Out routes
$app->get('/authentication/signiout', 'AuthenticationController:getSignOut')->setName('authentication.signout');
