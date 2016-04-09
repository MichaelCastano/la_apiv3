<?php

class AuthMiddleware
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


?>
