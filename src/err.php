<?php
function err_auth_error($response, $msg){
  $response = $response->withStatus(403);
  $response = err_general_error($response, "auth_error", "Please login to use this feature!");

  return $response;
}


function err_general_error($response, $type, $msg){
  $response->getBody()->write('{"error":"'.$type.'","msg":"'.$msg.'"}');

  return $response;
}

?>
