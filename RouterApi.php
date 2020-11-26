<?php
require_once 'api/ApiCommentsController.php';
require_once 'api/ApiProductsController.php';
require_once 'RouterClass.php';

//Instancio el router
$router = new Router();


//armo la tabla de ruteo de la api Rest
$router->addRoute('products','GET', 'ApiProductsController','getProducts');
$router->addRoute('products/:ID','GET', 'ApiProductsController','getProductsID');
$router->addRoute('products/:ID','DELETE', 'ApiProductsController','deleteProducts');
$router->addRoute('products/','POST', 'ApiProductsController','insertProducts');
$router->addRoute('products/:ID','PUT', 'ApiProductsController','updateProducts');

//Comments
$router->addRoute('comments/:ID','GET', 'ApiCommentsController','getCommentsById');
$router->addRoute('comments/','POST', 'ApiCommentsController','insertComments');
$router->addRoute('comments/:ID','DELETE', 'ApiCommentsController','deleteComment');

//run
$router->route($_GET['resource'], $_SERVER['REQUEST_METHOD']);



?>