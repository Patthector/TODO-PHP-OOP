<?php
session_start();
include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/classes/user.php";

if( !empty( $_SESSION[ "user_id" ] ) ){// we have a user
	$user = new User( $_SESSION[ "user_id" ] );
}

if( !empty( $user ) ){
	# Includes
	# ---------
	require_once $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/classes/collection.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/classes/library.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/classes/todo.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/functions/library.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/functions/todo.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/functions/excerpt.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/vendor/php/Mobile_Detect.php";
	# Variables
	# ---------
	$title_page = "Library | Stick it";
	$detect = new Mobile_Detect;
	$excerpt = new Excerpt();
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
			$collection = new CollectionLogic( $id, true );

			if( !empty( $collection->get__collection_id() )){# if we have a collection, set the title heading with the Collection's name

				if(!empty($_GET["action"])){
					$action = filter_input(INPUT_GET, "action", FILTER_SANITIZE_STRING);
					$files = $collection->collection_determineAction( $action );
					$msg = CollectionLogic::get__msg();
					foreach( $files as $file ){
						include $file;
					}
				  exit;
				}
				else{
					CollectionLogic::set__state( "readCollection" );
					$files = $collection->collection_readCollection();
					foreach( $files as $file ){
						include $file;
					}
				  exit;
				}
			} else{
				$msg = "Collection NOT FOUND";
				header("Location: /TODO-PHP-OOP/views/mytodos.php?msg=$msg");exit;
			}
			if(!empty($_GET["msg"])){ # redirection from POST cuz the form is not fill out completely
				$m = trim(filter_input(INPUT_GET, "msg", FILTER_SANITIZE_STRING));
				if(!empty($m)){
					$message = $m;
				}
			}
		}
		else {///create collection
			if(!empty($_GET["coll"])){
				$fatherCollection = filter_input(INPUT_GET, "coll", FILTER_SANITIZE_NUMBER_INT);
			}
			$library_heading = "create library";
			CollectionLogic::set__state( "createCollection" );
			$files = CollectionLogic::collection_formCollection();
			$msg = "Editing Collection. Change all the fields you wish!";
			foreach( $files as $file ){
				include $file;
			}
			exit;
		}
	}

	if($_SERVER["REQUEST_METHOD"] == "POST"){

		if(!empty($_POST["deleteCollection"])){
			$id = filter_input(INPUT_POST, "deleteCollection", FILTER_SANITIZE_NUMBER_INT);

			$collection = new CollectionLogic( $id );
			$collection->collection_deleteCollection( $id );
		}
		else if(!empty($_POST["moveCollection"])){

			$id_collection = filter_input(INPUT_POST, "id", FILTER_SANITIZE_NUMBER_INT);
			$id_placer_collection = filter_input(INPUT_POST, "collectionSelected", FILTER_SANITIZE_NUMBER_INT);

			$collection = new CollectionLogic( $id_collection );
			$collection->collection_moveCollection( $id_collection, $id_placer_collection, $collection->get__collection_name() );
		}
		else if(!empty($_POST["editCollection"])){
			CollectionLogic::collection_editCollection( $_POST );
			/*
			$id_collection = filter_input(INPUT_POST, "editCollection", FILTER_SANITIZE_NUMBER_INT);
			$id_placer_collection = filter_input(INPUT_POST, "collectionSelected", FILTER_SANITIZE_NUMBER_INT);

			$collection = new CollectionLogic( $id_collection );
			$collection->collection_moveCollection( $id_collection, $id_placer_collection, $collection->get__collection_name() );
			*/
		}
		else if(!empty($_POST["action"])){

				$state = filter_input(INPUT_POST, "action", FILTER_SANITIZE_STRING);

				if($state == "createCollection"){
					CollectionLogic::collection_createCollection( $_POST, $user );
				}
				else if($state == "deleteElements"){
					$id = filter_input(INPUT_POST, "id", FILTER_SANITIZE_NUMBER_INT);

					$collection = new CollectionLogic( $id );
					$files = $collection->collection_deleteElements( $_POST );
					$collection = new CollectionLogic( $id, true );
					$msg = CollectionLogic::get__msg();
					foreach( $files as $file){
						include $file;
					}
					exit;
				}
				else if($state == "moveElements"){//****moveElements****
					$id = filter_input(INPUT_POST, "id", FILTER_SANITIZE_NUMBER_INT);
					$id_fatherCollection = filter_input(INPUT_POST, "fatherCollection", FILTER_SANITIZE_NUMBER_INT);

					$collection = new CollectionLogic( $id );
					$files = $collection->collection_moveElements( $_POST, $id_fatherCollection );
					//updeting collection...
					$collection = new CollectionLogic( $id, true );
					$msg = CollectionLogic::get__msg();
					foreach( $files as $file){
						include $file;
					}
					exit;
				}
		}
	}
} else{
	header( "Location: ./registration.php?msg=You+must+be+registered" );
	exit;
}
