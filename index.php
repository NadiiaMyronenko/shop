<?php

//FRONT CONTROLLER

//error reporting
ini_set("display_errors", 1);
error_reporting(E_ALL);

session_start();

define("ROOT", dirname(__FILE__));
require_once ROOT . '/components/Autoload.php';

//create Router
$router = new Router();
$router->run();