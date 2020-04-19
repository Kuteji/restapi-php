<?php

require_once "controllers/routes.controller.php";
require_once "controllers/customers.controller.php";
require_once "controllers/courses.controller.php";


$routes = new RoutesController();

$routes->index();