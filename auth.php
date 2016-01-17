<?php

require_once('err.php')

function auth_required(){
  if(! isset($_SESSION['username'])){
    auth_error("This action requires authentication!");
  }
}




?>