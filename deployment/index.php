<?php
# variables
# ---------
require_once $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/vendor/php/Mobile_Detect.php";
session_start();
$title_page = "Stick it | Home";
$detect = new Mobile_Detect;

if( isset( $_SESSION[ "user_id" ] ) ){// we are logged in
	include "templates/header.php";
	include "templates/front-page.php";
	include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/auxiliar-templates/bubble-creators.php";
	include "templates/footer.php";
}
else {// NOT user logged in

	header("Location: views/registration.php");

}
