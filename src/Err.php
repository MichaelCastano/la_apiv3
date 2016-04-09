<?php
function err_auth_error($response, $msg)
{
    $response = $response->withStatus(403);
    $response = err_error($response, "auth_error", $msg);

    return $response;
}

function err_general_error($response, $msg)
{
    $response = err_error($response, "general_error", $msg);
    return $response;
}

function err_error($response, $type, $msg)
{
    $response->getBody()->write('{"error":"' . $type . '","msg":"' . $msg . '"}');

    return $response;
}

?>
