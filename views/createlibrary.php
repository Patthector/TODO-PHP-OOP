<?php

#--------------------#
# LIBRARY FORM LOGIC #
#--------------------#

include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP [with JS]/classes/collection.php";
include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP [with JS]/classes/todo.php";

$title_page = "Create Library | Make It Stick";
$name = $message = $description = $collection = $tags = "";
$collections = array();

if($_SERVER["REQUEST_METHOD"] == "GET"){
#this is a GET request
# |
# --->the query-string is clean, so this is the first time you get into this page.
#     call the getlibraries() function
	$collections = Collection::getCollections();

} else if($_SERVER["REQUEST_METHOD"] == "POST"){
#this is a POST request
# |
# --->the FORM was submitted and the user wants to storage the Library
	if(!empty($_POST["description"])){
		$description = filter_input(INPUT_POST, "description", FILTER_SANITIZE_STRING);
	}
	if(!empty($_POST["collection"])){
		$collection = filter_input(INPUT_POST, "collection", FILTER_SANITIZE_NUMBER_INT);
	}
	if(!empty($_POST["name"])){
		$name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING);
		#if the $name variable is empty=> send a message to the user
		#							 OR=> keep going with the TODO creation
		if(empty($name)){
			$message = "A TITLE must be given";
		} else{
			$new_collection = new Collection( $name, $description, $collection );
			$id = $new_collection->addCollection(
										$new_collection->getName( $name ),
										$new_collection->getDescription( $description ),
										$new_collection->getfatherCollection_id( $collection ),
										1);
			header("Location: /TODO-PHP-OOP [with JS]/views/library.php?id=" . $id);
		}
	}

}

include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP [with JS]/templates/header.php";
include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP [with JS]/templates/libraryform.php";
include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP [with JS]/templates/footer.php";
