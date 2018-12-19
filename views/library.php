<?php
# Includes
# ---------
require_once $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/classes/collection.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/classes/library.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/classes/todo.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/functions/library.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/functions/todo.php";
# Variables
# ---------
$title_page = "Library | Stick it";
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
	else if(!empty($_POST["action"])){
		$state = filter_input(INPUT_POST, "action", FILTER_SANITIZE_STRING);

		if($state == "createCollection"){
			CollectionLogic::collection_createCollection( $_POST );
		}
		else if($state == "deleteElements"){
			$id = filter_input(INPUT_POST, "id", FILTER_SANITIZE_NUMBER_INT);

			$collection = new CollectionLogic( $id );
			$files = $collection->collection_deleteElements( $_POST );
			foreach( $files as $file){
				include $file;
			}
			exit;
		}
		else if($state == "moveElements"){//****moveElements****
			$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);
			$id_fatherCollection = filter_input(INPUT_POST, "fatherCollection", FILTER_SANITIZE_NUMBER_INT);

			$collection = new CollectionLogic( $id );
			$files = $collection->collection_moveElements( $_POST, $id_fatherCollection );
			foreach( $files as $file){
				include $file;
			}
			exit;
		}
	}
}
