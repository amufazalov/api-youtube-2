<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require_once '../src/helpers.php';
require '../bootstrap/app.php';


$app->get('/', 'MainController:index');
$app->get('/query/{name}', function(Request $request, Response $response, $args){
    return $args['name'];
});

$app->run();