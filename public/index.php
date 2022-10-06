<?php

use controllers\AuthController;
use middlewares\AuthMiddleware;

require("../config/autoload.php");

$app = new core\Application;

$app->router->get('/', 'home', [new AuthMiddleware()]);
$app->router->get('/home', 'home', [new AuthMiddleware()]);
$app->router->get('/signup', 'signup');
$app->router->post('/signup', [new AuthController(), 'handleSignup']);
$app->router->get('/login', [new AuthController(), 'login']);
$app->router->post('/login', [new AuthController(), 'handleLogin']);
$app->router->get('/dashboard', [new AuthController(), 'dashboard'], [new AuthMiddleware()]);
$app->router->get('/logout', [new AuthController(), 'logout']);
$app->router->get('/test', 'test');

$app->run();
