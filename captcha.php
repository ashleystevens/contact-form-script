<?php

session_start();
if ( ($_REQUEST["txtcaptcha"] == $_SESSION["security_code"]) && 

    (!empty($_REQUEST["txtcaptcha"]) && !empty($_SESSION["security_code"])) ) {

  echo "true";

} else {

  echo "Invalid code! Try again!";

}

?>