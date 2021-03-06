<?php

use Respect\Validation\Validator as validator;

session_start();

require __DIR__ . '/../vendor/autoload.php';


//Remember to turn 'displayErrorDetails' off when released to a production
//machine!

//This is where you place your database credentials...of course plain text is
//NOT secure!

$app = new \Slim\App([
    'settings' => [
        'displayErrorDetails' => true,
        'db' => [
            'driver'    => 'mysql',
            'host'      => 'localhost',
            'database'  => 'your-database-here',
            'username'  => 'root',
            'password'  => 'mysql',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ],
    ]
]);

$container = $app->getContainer();

$capsule = new \Illuminate\Database\Capsule\Manager;
$capsule->addConnection($container['settings']['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();

$container['db'] = function($container) use ($capsule) {
    return $capsule;
};

$container['authentication'] = function($container) {
    return new \App\Authentication\Authentication;
};

$container['flash'] = function($container) {
    return new \Slim\Flash\Messages;
};

//Turn caching on to store cached views on a production machine
$container['view'] = function($container) {
    $view = new \Slim\Views\Twig(__DIR__ . '/../resources/views', [
        'cache' => false,
    ]);

    $view->addExtension(new \Slim\Views\TwigExtension(
        $container->router,
        $container->request->getUri()
    ));

    //Try and connect to the database
    //There is probably a better way of doing this, but for now just so the
    //website will show when the database is down
    $_SESSION['database_online'] = true;

    try{
        $view->getEnvironment()->addGlobal('authentication', [
            'check' => $container->authentication->check(),
            'user' => $container->authentication->user(),
        ]);
    }
    catch(Exception $e){
        $_SESSION['database_online'] = false;
        //The following can be enabled to show explicit error message, of course
        //should not be shown on production servers!
        echo $e->getMessage();
    }

    $view->getEnvironment()->addGlobal('flash', $container->flash);

    return $view;
};


$container['validator'] = function($container) {
    return new \App\Validation\Validator;
};

$container['HomeController'] = function($container) {
    return new \App\Controllers\HomeController($container);
};

$container['AuthenticationController'] = function($container) {
    return new \App\Controllers\Authentication\AuthenticationController($container);
};

$container['PasswordController'] = function($container) {
    return new \App\Controllers\Authentication\PasswordController($container);
};


$container['csrf'] = function($container) {
    return new \Slim\Csrf\Guard;
};



$app->add(new \App\Middleware\ValidationErrorsMiddleware($container));
$app->add(new \App\Middleware\OldInputMiddleware($container));
$app->add(new \App\Middleware\CSRFViewMiddleware($container));


$app->add($container->csrf);

validator::with('App\\Validation\\Rules\\');



require __DIR__ . '/../app/routes.php';
