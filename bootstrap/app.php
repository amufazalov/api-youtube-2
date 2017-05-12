<?php

require  dirname(__DIR__).'/vendor/autoload.php';

$settings = require dirname(__DIR__) . '/app/settings.php';

$app = new Slim\App($settings);

$container = $app->getContainer();

//debug($container);

//регистрируем компонент Twig в контейнере
$container['view'] = function($container){
    $view = new \Slim\Views\Twig(dirname(__DIR__). '/app/Views', [
        'cache' => false
    ]);

    $view->addExtension(new Slim\Views\TwigExtension(
        $container->router,
        $container->request->getUri()
    ));

    return $view;
};

//Регистрируем контроллер MainController
$container['MainController'] = function($container){
    return new \App\Controllers\MainController($container);
};