<?php

define('PUBLICDIR', __DIR__);
define('ROOTDIR', dirname(__DIR__));
define('STORAGEDIR', ROOTDIR.'/Storage');

require_once __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection;
use Symfony\Component\DependencyInjection\Reference;

$sc = include ROOTDIR . '/bootstrap.php';

$request = Request::createFromGlobals();

$sc->setParameter('routes', include ROOTDIR.'/Application/Http/routes.php');
$sc->register('listener.string_response', 'System\Core\StringResponseListener');
$sc->getDefinition('dispatcher')
	->addMethodCall('addSubscriber', array(new Reference('listener.string_response')))
;
$sc->setParameter('charset', 'UTF-8');
$sc->setParameter('path.public', PUBLICDIR);
$sc->setParameter('path.root', ROOTDIR);
$sc->setParameter('path.storage', STORAGEDIR);

$framework = $sc->get('framework');

//$response = $framework->getKernel()->handle($request);
$response = $sc->get('kernel')->handle($request);

$response->send();

$sc->get('kernel')->terminate($request, $response);
