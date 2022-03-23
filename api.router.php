<?php

include_once('libs/Router.php');
include_once('libs/api.controller.php');

$router = new Router();

$router -> addRoute('post', 'GET', 'apiController', 'getPosts');

$resource = $_GET['resource'];
$method = $_SERVER['REQUEST_METHOD'];
$router -> route($resource, $method);