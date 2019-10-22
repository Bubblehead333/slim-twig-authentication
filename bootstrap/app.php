<?php

session_start();

require __DIR__ . '/../vendor/autoload.php';


//Remember to turn 'displayErrorDetails' when released to a production machine!

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


//Turn caching on to store cached views on a production machine
$container['view'] = function($container) {
    $view = new \Slim\Views\Twig(__DIR__ . '/../resources/views', [
        'cache' => false,
    ]);

    $view->addExtension(new \Slim\Views\TwigExtension(
        $container->router,
        $container->request->getUri()
    ));

    return $view;
};

$container['HomeController'] = function($container) {
    return new \App\Controllers\HomeController($container);
};


require __DIR__ . '/../app/routes.php';
