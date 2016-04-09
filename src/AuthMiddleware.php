<?php

class AuthMiddleware
{
    public function __construct()
    {

    }

    public function __invoke($request, $response, $next)
    {
        /* TODO Resolve logged in User */
        session_start();
        if (isset($_SESSION['username'])) {
            $response = $next($request, $response);
        } else {
            $response = err_auth_error($response,"You must login for this feature!");
        }
        return $response;
    }
}


?>
