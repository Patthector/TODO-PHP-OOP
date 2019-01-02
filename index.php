<?php
# variables
# ---------
require_once $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/vendor/Mobile_Detect.php";
session_start();
$title_page = "Stick it | Home";
$detect = new Mobile_Detect;

if( isset( $_SESSION[ "user_id" ] ) ){// we are logged in
	include "templates/header.php";
	include "templates/empty-front-page.php";
	include "templates/footer.php";
}
else {// NOT user logged in

	header("Location: views/registration.php");

}
