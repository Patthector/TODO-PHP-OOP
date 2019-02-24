<?php
session_start();
include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/classes/user.php";

	if( !empty( $_SESSION[ "user_id" ] ) ){// we have a user
		$user = new User( $_SESSION[ "user_id" ] );
	}

	if( !empty( $user ) ){
		# includes
		#--------------
		include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/classes/collection.php";
		include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/classes/library.php";
		include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/classes/todo.php";
		include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/functions/todo.php";
		include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/functions/library.php";
		include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/functions/excerpt.php";
		require_once $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/vendor/php/Mobile_Detect.php";
		# Variables
		# ---------
		$title_page = "Stick it | myTodos";
		$excerpt = new Excerpt();
		$detect = new Mobile_Detect;

			if($_SERVER["REQUEST_METHOD"] == "GET"){

				if( empty( $_GET ) ){
					//SHOW THE EMPTY PAGE
					include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/header.php";
					include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/message.php";
					include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/empty-front-page.php";
					include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/footer.php";
					exit;
				}
				else if( !empty($_GET["pg"]) ){
					$page = filter_input(INPUT_GET, "pg", FILTER_SANITIZE_NUMBER_INT);
					if( !empty($_GET["msg"]) ){
						$msg = trim(filter_input(INPUT_GET, "msg", FILTER_SANITIZE_STRING));
					}
					//VARIABLES
					$total_libraries = Library::totalLibraries( $user->get__userId() ); //this should be a function call ==> Library::totalLibraries( $user->get__userId() );

					if( $total_libraries > 0 ){
						$libraries_per_page = 6; // a fixed amount the could be change al vostro parere
						$total_pages = ( ceil( $total_libraries / $libraries_per_page) );

						//PAGE VALIDATION
						if( $page <= 0){
							$page = 1;
							header( "location: ./mytodos.php?pg=$page" );exit;
						} else if( $page > $total_pages ){
							$page = $total_pages;
							header( "location: ./mytodos.php?pg=$page" );exit;
						}
						$offset = ( $page - 1 ) * $libraries_per_page;
						$libraries = Library::retriveFullLibrary( $user->get__userId(), $libraries_per_page, $offset );
						//FILES
						include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/header.php";
						include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/auxiliar-templates/levels-of-imp-bar.php";
						include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/message.php";
						include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/auxiliar-templates/search-bar.php";
						include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/mytodos.php";
						include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/auxiliar-templates/bubble-creators.php";
						include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/footer.php";
					}
					else{
						//SHOW THE EMPTY PAGE
						header("location: ./mytodos.php"); exit;
					}
				}
				else if( count($_GET) > 0 ){ #we have query, but seems to be a wrong one
					header("Location: /TODO-PHP-OOP/views/mytodos.php?pg=1");exit;
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
				include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/auxiliar-templates/levels-of-imp-bar.php";
				include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/message.php";
				include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/auxiliar-templates/search-bar.php";
				include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/mytodos.php";
				include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/footer.php";
				 exit;
			}

	} else{
		header( "Location: ./registration.php?msg=You+must+be+registered" );
		exit;
	}
