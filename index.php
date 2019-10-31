<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require './vendor/autoload.php';
include_once './API/UsuarioAPI.php';
include_once './API/TokenAPI.php';
include_once './API/PeliculaAPI.php';
include_once './API/ActorAPI.php';
include_once './Middleware/TokenMiddleware.php';

$app = new \Slim\App([
    'settings' => [
        'displayErrorDetails' => true
    ]
]);

//Usuario
$app->post('/usuario[/]', \TokenAPI::class . ':CrearUsuario');
$app->get('/usuario[/]', \UsuarioAPI::class . ':TraerTodos');
/* ->add(\TokenMiddleware::class . ':ValidarAdmin')
->add(\TokenMiddleware::class . ':ValidarToken'); */
//login
$app->post('/login[/]', \TokenAPI::class . ':GenerarToken');
//pelicula
$app->get('/pelicula[/]', \PeliculaAPI::class . ':TraerTodos');
$app->post('/pelicula/cargar[/]', \PeliculaAPI::class . ':CargarConImagen');
$app->post('/pelicula/eliminar[/]', \PeliculaAPI::class . ':Eliminar');
//Actor
$app->get('/actor[/]', \ActorAPI::class . ':TraerTodos');
$app->post('/actor/cargar[/]', \ActorAPI::class . ':Cargar');

$app->post('/pelicula/foto[/]', \PeliculaAPI::class . ':Foto');


$app->run();