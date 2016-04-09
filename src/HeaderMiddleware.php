<?php

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
