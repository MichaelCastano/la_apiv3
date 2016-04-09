<?php

define("ABS_PATH", dirname(__FILE__));
error_reporting(E_ALL);
ini_set('display_errors', 1);


/* setup the autoloading */
require_once('vendor/autoload.php');

/* setup Propel */
require_once('generated-conf/config.php');

/* load Application Parts */
require_once('src/AuthMiddleware.php');
require_once('src/HeaderMiddleware.php');
require_once('src/Util.php');
require_once('src/Err.php');

/* setup Loggerenvironment */
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$logger = new Logger('defaultLogger');
$logger->pushHandler(new StreamHandler('php://stderr'));
//$serviceContainer->setLogger('defaultLogger', $logger);


/* setup SLIM RestFul Application */
$configuration = [
    'settings' => [
        'displayErrorDetails' => true,
    ],
];

// Create and configure Slim app
$container = new \Slim\Container($configuration);
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

    /* GIGS */
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

    /* VENUES */
    $app->get('/venues', function ($request, $response, $args) {
        $venues = VenueQuery::create()->find();
        $response->getBody()->write($venues->toJSON());
        return $response;
    });

    $app->get('/venues/{id}', function ($request, $response, $args) {
        $id = $request->getAttribute('id');

        $venue = VenueQuery::create()->findPK($id);
        $response->getBody()->write($venue->toJSON());

        return $response;
    });

    /* USERS */
    $app->get('/users', function ($request, $response, $args) {
        $users = UserQuery::create()->find();
        /* hide password and telephonenumber */
        foreach ($users as $user) {
            $user->setPassword("hidden");
            $user->setSalt("hidden");
        }
        $response->getBody()->write($users->toJSON());
        return $response;
    });


})  ->add('AuthMiddleware')
    ->add('HeaderMiddleware');


// Define the control group */
$app->group('/control', function () use ($app) {

    /* AUTH */
    $app->post('/login', function ($request, $response, $args) {
        $parsedBody = $request->getParsedBody();

        $password = $parsedBody['password'];
        $username = $parsedBody['username'];

        $user = UserQuery::create()->findOneByUsername($username);
        if (is_object($user)) {
            $salt = $user->getSalt();
            $hashedPassword = $user->getPassword();
        } else {
            session_start();
            session_destroy();
            return err_auth_error($response, "Incorrect credentials (username)");
        }

        if (hash('sha512', $password . $salt) == $hashedPassword) {
            session_start();
            session_unset();
            session_regenerate_id(true);
            $_SESSION['username'] = $username;
            return success($response, "Logged in");
        } else {
            session_start();
            session_destroy();
            return err_auth_error($response, "Incorrect credentials (password)");
        }
    });

    $app->get('/logout', function ($request, $response, $args) {
        session_start();
        session_destroy();
        return success($response, "Logged out");
    });

})->add('HeaderMiddleware');


// Define the private group */
$app->group('/public', function () use ($app) {


})->add('HeaderMiddleware');


// Run app
$app->run();

?>
