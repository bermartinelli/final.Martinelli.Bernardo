<?php
include_once'controller.php';
//tabla de ruteo

$controller = new empleosController();

//....

$params = explode ('/', $action);

switch ($params[0]) {
    case 'nuevoPosteo':
        $controller-> newPost();
        break;
    case 'InfoPosteo':
        $controller-> newPost($params[1]);
        break;
    case 'desactivarPosteo';
        $controller -> deactivatePost($params[1]);
}