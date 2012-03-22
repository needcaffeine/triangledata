<?php
// Require the bootstrap.
require 'Bootstrap.php';

// Instantiate Slim.
$app = new Slim(array(
	'mode' => 'development',
	'log.enabled' => true,
	'log.path' => APPLICATION_PATH . '/logs',
	'log.level' => 4,
	'debug' => true
));

// We don't care to log stuff on production.
$app->configureMode('production', function () use ($app) {
	$app->config(array(
		'log.enable' => false,
		'debug' => false
	));
});

// Automatically parse the HTTP request body based on its content type.
$app->add('Slim_Middleware_ContentTypes');

// Create a hook to lazy load our controllers so we don't have to declare
// every consumable method in this one file.
$app->hook('slim.before.router', function () use($app) {

	// We need to form the controller URI.
	$uri = $app->request()->getResourceUri();

	// If there are no slashes in the uri (going past the first slash as an offset),
	// *this* is the controller. Else, parse for the controller string.
	if (($i = strpos($uri, '/', 1)) === false) {
		$controller = substr($uri, 1);
	} else {
		$controller = substr($uri, 1, $i-1);
	}

	// Define our controllers here for all our consumable methods.
	switch ($controller) {
		case 'hello' : require_once 'Controllers/Hello.php'; break;
		case 'crime' : require_once 'Controllers/Crime.php'; break;
	}
});

// This needs to happen after everything else.
$app->contentType('application/json');
$app->run();
