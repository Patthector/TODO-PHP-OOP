<?php
# Includes
# ---------
require_once $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP [with JS]/classes/collection.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP [with JS]/classes/library.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP [with JS]/classes/todo.php";

# Variables
# ---------
$title_page = "Library | Stick it";
$title_heading = $message = $collection_title = $collection_description ="";

# Requests
# ---------
if($_SERVER["REQUEST_METHOD"] == "GET"){
	# READ Collection
	if(!empty($_GET["id"])){
		# this section of the code is getting an ID as possible collection's ID
		# and retriving from the database. 
		# If that action is impossible cuz the ID is invalid or any other ERR!
		# the user will be sent to 'myTodos.php' with an err feedback.
		$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

		$collection = Collection::getCollection($id); 
		$collection["todos"] = Todo::getTodosByFatherId( $id );
		if($collection){# if we have a collection, set the title heading with the Collection's name
			$title_heading = $collection["name"];
		} else{
			$message = "Library NOT FOUND";
			header("Location: /TODO-PHP-OOP [with JS]/views/mytodos.php?msg=" . $message);exit;
		}
	}
	else if(!empty($_GET["msg"])){ # redirection from POST cuz the form is not fill out completely
		$m = trim(filter_input(INPUT_GET, "msg", FILTER_SANITIZE_STRING));
		if(!empty($m)){
			$message = $m;
		}
	}
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
	if(!empty($_POST["delete"])){

		$id = filter_input(INPUT_POST, "delete", FILTER_SANITIZE_NUMBER_INT);

		if(!empty($id)){
			if( Collection::deleteCollection($id) ){
				$message = "Library deleted succesfully";
			} else{
				$message = "Unable to delete Library";
			}
		} else{
			$message = "Unable to delete Library";			
		}		
		header("Location:/TODO-PHP-OOP [with JS]/views/mytodos.php?msg=" . $message);exit;
	}
}

include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP [with JS]/templates/header.php";
include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP [with JS]/templates/library.php";
include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP [with JS]/templates/footer.php";
