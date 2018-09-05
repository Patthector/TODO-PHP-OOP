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

	if(!empty($message)){
		echo "<div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\">
			  	<strong>Alright!</strong>" ." ".  $message . "
			 	<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
			    <span aria-hidden=\"true\">&times;</span>
			  	</button>
			</div>";
	}


$test = 2;
if($test == 1){
	include "views/front-page.php";
	include "templates/footer.php";
} elseif($test == 2){
	include "views/empty-front-page.php";
	include "templates/footer.php";
}
