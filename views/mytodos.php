<?php

# includes
#--------------
include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP [with JS]/classes/collection.php";
include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP [with JS]/classes/library.php";

# Variables
# ---------
$title_page = "Stick it | myTodos";

if($_SERVER["REQUEST_METHOD"] == "GET"){
	if(!empty($_GET["msg"])){ # redirection from todo.php for invalid ID

		$message = trim(filter_input(INPUT_GET, "msg", FILTER_SANITIZE_STRING));
		$libraries = Library::retriveFullLibrary();

	} else if(count($_GET)>0){ #we have query, but seems to be a wrong one
		
		header("Location: /TODO-PHP-OOP [with JS]/mytodos.php");exit;
		
	} else{
		$libraries = Library::retriveFullLibrary();
	}
}


include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP [with JS]/templates/header.php";
include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP [with JS]/templates/mytodos.php";
include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP [with JS]/templates/footer.php";