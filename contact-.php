<?php

// Setup Variables
// Test Email
$email_to = "joe@em4b.com";
// Acutal Email
// $email_to = "info@companyname.com";
$host = $_SERVER['HTTP_HOST'];
$subject = "Contact Submission from $host";

// Clean input from the form
clean_input();

// Prevent header injection of from address
$from=urldecode($_REQUEST['email']);
$from=str_replace("\r","",$from);
$from=str_replace("\n","",$from);

$message="The following information was entered from the website's Contact form :\n\n";
foreach($_REQUEST as $key=>$value) {
	if(($key != "txtcaptcha") && ($key != "PHPSESSID")) {
		$message.="" . $key . ": $value;\n";
	}
}

$headers="From: $from\n";
$headers.="Reply-To: $from\n";
$headers.="Return-Path: $from\n";

// For the Captcha
session_start();
if ( ($_REQUEST["txtcaptcha"] == $_SESSION["security_code"]) && 
    (!empty($_REQUEST["txtcaptcha"]) && !empty($_SESSION["security_code"])) ) {
		// Send the Email
		$results=mail($email_to,$subject,$message,"From: $from\n");
	}

header("Location: thankyou.html");
exit;

function clean_input() {
        # Function to strip damaging info from input variables
        # Now look at each of the request variables
        foreach($_REQUEST as $key=>$value) {
                if(is_array($value)){
                        foreach($value as $key2=>$value2){
                                $value[$key2]=strip_input($value2);
                        }
                        $_REQUEST[$key]=$value;
                }else{
			$_REQUEST[$key]=strip_input($_REQUEST[$key]);
                }
        }
}
function strip_input($input) {
        # Function to strip any potential damaging characters from web input
        $input=strip_tags($input);
        $input=preg_replace("/\</","",$input);
        $input=preg_replace("/\>/","",$input);
        $input=trim($input);
        return $input;
}
?>
