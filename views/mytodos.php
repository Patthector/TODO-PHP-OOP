<?php
session_start();

if( !empty( $_SESSION[ "user_id" ] ) ){// we have a user
	# includes
	#--------------
	include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/classes/collection.php";
	include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/classes/library.php";
	include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/classes/todo.php";
	include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/functions/todo.php";
	include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/functions/library.php";
	include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/functions/excerpt.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/vendor/Mobile_Detect.php";
	# Variables
	# ---------
	$title_page = "Stick it | myTodos";
	$excerpt = new Excerpt();
	$detect = new Mobile_Detect;

		if($_SERVER["REQUEST_METHOD"] == "GET"){
			 if(count($_GET)>0){ #we have query, but seems to be a wrong one

				header("Location: /TODO-PHP-OOP/mytodos.php");exit;

			} else{
				if(!empty($_GET["msg"])){
					$msg = trim(filter_input(INPUT_GET, "msg", FILTER_SANITIZE_STRING));
				}
				$libraries = Library::retriveFullLibrary( $_SESSION[ "user_id" ] );

				if( empty( $libraries ) ){
					include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/header.php";
					include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/message.php";
					include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/empty-front-page.php";
					include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/footer.php";
				} else{

					include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/header.php";
					include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/levels-of-imp-bar.php";
					include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/message.php";
					include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/search-bar.php";
					include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/mytodos.php";
					include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/bubble-creators.php";
					include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/footer.php";
				}
			}
		}
		if($_SERVER["REQUEST_METHOD"] == "POST"){
			$searchResults = [];

			if( !empty( $_POST["search-bar--submit"] ) ){
				if( !empty( $_POST["search-bar--input"] ) ){
					$search_name = trim( filter_input( INPUT_POST, "search-bar--input", FILTER_SANITIZE_STRING ) );
				}
				if( !empty( $_POST["todo__form-radio--todo-name"] ) ){
					$todo_table = true;
				}
				if( !empty( $_POST["todo__form-radio--collection-name"] ) ){
					$collection_table = true;
					$searchResults["collections"] = Collection::searchCollectionByName( $search_name );
					var_dump($searchResults);
				}
				if( !empty( $_POST["todo__form-radio--tag-name"] ) ){
					$tag_table = true;
				}
			}
			include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/header.php";
			include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/levels-of-imp-bar.php";
			include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/message.php";
			include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/search-bar.php";
			include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/mytodos.php";
			include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/footer.php";
			 exit;
		}

} else{
	header( "Location: ./registration.php?msg=You+must+be+registered" );
	exit;
}
