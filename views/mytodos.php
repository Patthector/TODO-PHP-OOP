<?php

# includes
#--------------
include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/classes/collection.php";
include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/classes/library.php";

# Variables
# ---------
$title_page = "Stick it | myTodos";

if($_SERVER["REQUEST_METHOD"] == "GET"){
	if(!empty($_GET["msg"])){ # redirection from todo.php for invalid ID

		$message = trim(filter_input(INPUT_GET, "msg", FILTER_SANITIZE_STRING));
		$libraries = Library::retriveFullLibrary();

	} else if(count($_GET)>0){ #we have query, but seems to be a wrong one

		header("Location: /TODO-PHP-OOP/mytodos.php");exit;

	} else{
		$libraries = Library::retriveFullLibrary();
	}
}


include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/header.php";
include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/levels-of-imp-bar.php";
include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/search-bar.php";
include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/mytodos.php";
include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/footer.php";
