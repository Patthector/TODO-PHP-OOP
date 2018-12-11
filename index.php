<?php
# variables
# ---------

$title_page = "Stick it | Home";

if($_SERVER["REQUEST_METHOD"] == "GET"){
	if(!empty($_GET["msg"])){
		$m = trim(filter_input(INPUT_GET, "msg", FILTER_SANITIZE_STRING));
		if(!empty($m)){
			$message = $m;
		} else{
			header("Location: index.php");exit;
		}
	}
}
include "templates/header.php";

	if(!empty($msg)){
		include "/templates/message.php";
	}


$test = 2;
if($test == 1){
	include "views/front-page.php";
	include "templates/footer.php";
} elseif($test == 2){
	include "views/empty-front-page.php";
	include "templates/footer.php";
}
