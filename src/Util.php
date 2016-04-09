<?php

function validateDate($date)
{
    list($y, $m, $d) = array_pad(explode('-', $date, 3), 3, 0);
    return ctype_digit("$y$m$d") && checkdate($m, $d, $y);
}

function success($response, $msg)
{
    $response->getBody()->write('{"success":"' . $msg . '"}');
    return $response;
}


?>
