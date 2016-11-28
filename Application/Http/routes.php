<?php

use Symfony\Component\Routing;

$routes = new Routing\RouteCollection();
$routes->add('index', new Routing\Route(
	'/',
	array('_controller' => 'Application\\Controller\\HomeController::indexAction'))
);
$routes->add('test', new Routing\Route(
	'/test/{param}',
	array('param' => 'testparam', '_controller' => 'Application\\Controller\\TestController::indexAction'))
);

return $routes;
