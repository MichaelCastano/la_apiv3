<?php

define("ABS_PATH", dirname(__FILE__));
error_reporting(E_ALL);
ini_set('display_errors', 1);


// setup the autoloading
require_once('vendor/autoload.php');

// setup Propel
require_once('generated-conf/config.php');

// setup Application Parts
require_once('src/AuthMiddleware.php');
require_once('src/HeaderMiddleware.php');
require_once('src/Util.php');
require_once('src/Err.php');


// Create and configure Slim app
$container = new \Slim\Container;
$app = new \Slim\App($container);

$container['AuthMiddleware'] = function ($container) {
    return new AuthMiddleware();
};

$container['HeaderMiddleware'] = function ($container) {
    return new HeaderMiddleware();
};


// Define the private group */
$app->group('', function () use ($app) {
    $app->get('/test', function ($request, $response, $args) {
        $response->getBody()->write('{ "result":"passed" }');

        return $response;
    });

    $app->get('/gigs', function ($request, $response, $args) {
        $gigs = GigQuery::create()->find();
        $response->getBody()->write($gigs->toJSON());
        return $response;
    });

    $app->get('/gigs/{id}', function ($request, $response, $args) {
        $id = $request->getAttribute('id');

        $gig = GigQuery::create()->findPK($id);
        $response->getBody()->write($gig->toJSON());

        return $response;
    });

})->add('AuthMiddleware')
    ->add('HeaderMiddleware');


// Define the private group */
$app->group('public', function () use ($app) {


})->add('HeaderMiddleware');


// Run app
$app->run();

?>
