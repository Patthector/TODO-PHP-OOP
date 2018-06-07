<?php
#-----------------#
# TODO FORM LOGIC #
#-----------------#

include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP [with JS]/classes/collection.php";
include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP [with JS]/classes/todo.php";

$title_page = "Create TODO | Make It Stick";
$name = $message = $description = $library = $tags = "";
$libraries = array();

if($_SERVER["REQUEST_METHOD"] == "GET"){
#this is a GET request
# |
# --->the query-string is clean, so this is the first time you get into this page.
#     call the getlibraries() function
	$libraries = Collection::getCollections();

} else if($_SERVER["REQUEST_METHOD"] == "POST"){
#this is a POST request
# |
# --->the FORM was submitted and the user wants to storage the TODO	
	$level = $_POST["level"];
	if(!empty($_POST["description"])){
		$description = filter_input(INPUT_POST, "description", FILTER_SANITIZE_STRING);
	}
	if(!empty($_POST["library"])){
		$library = filter_input(INPUT_POST, "library", FILTER_SANITIZE_NUMBER_INT);
	}
	if(!empty($_POST["tags"])){
		$tags = filter_input(INPUT_POST, "tags", FILTER_SANITIZE_STRING);
		$tags = explode(" ", $tags);
	}
	if(!empty($_POST["name"])){
		$name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING);
		#if the $name variable is empty=> send a message to the user
		#							 OR=> keep going with the TODO creation
		if(empty($name)){
			$message = "A TITLE must be given";
		} else{ 
			$id = Todo::addTodo( $name, $description, $library, $tags, 1, $level);
			header("Location: /TODO-PHP-OOP [with JS]/views/todo.php?id=" . $id);
		}
	}
	
}

include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP [with JS]/templates/header.php";
include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP [with JS]/templates/todoform.php";
include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP [with JS]/templates/footer.php";
