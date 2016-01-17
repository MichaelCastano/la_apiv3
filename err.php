<?php
function err_auth_error($response, $msg){
  dbclose();
  http_response_code(403);
  die('{"error":"auth_error","msg":"' . $msg . '"}');
}

function err_api_error($msg){
  dbclose();
  http_response_code(500);
  die('{"error":"api_error","msg":"' . $msg . '"}');
}

function err_database_error($msg, $errno, $error){
  dbclose();
  http_response_code(500);
  die('{"error":"database_error","msg":"' . $msg . '","mysql_error":"' . $error . '","mysql_errno":"' . $errno . '"}');
}

function err_prepare_error($errno, $error){
  database_error("Prepare failed.",$errno, $error);
}

?>