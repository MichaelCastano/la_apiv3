<?php

header('Content-type: application/json');
header("Access-Control-Allow-Origin: *");

// load dependencies
require_once('vendor/autoload.php');

require_once('auth.php');
require_once('db.php');
require_once('utils.php');
require_once('err.php');
require_once('constants.php');

// Create and configure Slim app
$app = new \Slim\App;

// Define app routes
$app->get('/hello/{name}', function ($request, $response, $args) {
    return $response->write("Hello " . $args['name']);
});

// Run app
$app->run();

?>
