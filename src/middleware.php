<?php

class AuthRequiredMiddleware
{
    public function __construct()
    {

    }

    public function __invoke($request, $response, $next)
    {
        if (!isset($_SESSION['loggedin'])) {
            $response = $next($request, $response);
        } else {
            $response = err_auth_error($response);
        }
        return $response;
    }
}

class HeaderMiddleware
{
    public function __construct()
    {

    }

    public function __invoke($request, $response, $next)
    {
        $response = $response->withHeader('Content-type', 'application/json');
        $response = $next($request, $response);
        return $response;
    }
}


?>
