<?php
# Includes
# ---------
require_once $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/classes/collection.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/classes/library.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/classes/todo.php";

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
		$collections = Collection::getCollections();

		if( !empty($collection) ){# if we have a collection, set the title heading with the Collection's name
			$collection["subcollections"] = Collection::getSubcollections($id);
			$collection["path"] = Collection::getFullPath($collection["id"]);
			$collection["todos"] = Todo::getTodosByFatherId( $id );//here we are adding all the todos associate with that collection
			$title_heading = $collection["name"];

			if(!empty($_GET["action"])){
				$action = filter_input(INPUT_GET, "action", FILTER_SANITIZE_STRING);

				switch($action){
					//---EDIT COLLECTION---
					case "editItem":
						$collection_heading = "edit collection";
						$name = $collection["name"];
						$description = trim($collection["description"]);
						$action = filter_input(INPUT_GET, "action", FILTER_SANITIZE_STRING);
						$state = "editCollection";
						include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/libraryform.php";
						break;
					case "selectElements":
						$select_elements_on = true;
						include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/single-library.php";
				}
			} else{
				$state = "readCollection";
				//this variable should be remove
				//$delete_elements_on = true;
				//INCLUDE THE FILES
				include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/header.php";
				include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/library.php";
				include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/footer.php";
			}
		} else{
			$message = "Collection NOT FOUND";
			header("Location: /TODO-PHP-OOP/views/mytodos.php?msg=" . $message);exit;
		}
		if(!empty($_GET["msg"])){ # redirection from POST cuz the form is not fill out completely
			$m = trim(filter_input(INPUT_GET, "msg", FILTER_SANITIZE_STRING));
			if(!empty($m)){
				$message = $m;
			}
		}
	}else {///create collection
		if(!empty($_GET["coll"])){
			$fatherCollection = filter_input(INPUT_GET, "coll", FILTER_SANITIZE_NUMBER_INT);
		}
		$collections = Collection::getCollections();
		$library_heading = "create library";
		$state = "createCollection";

		//INCLUDE THE FILES
		include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/header.php";
		include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/libraryform.php";
		include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/footer.php";
	}
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
	if(!empty($_POST["deleteCollection"])){

		$id = filter_input(INPUT_POST, "deleteCollection", FILTER_SANITIZE_NUMBER_INT);

		if(!empty($id)){
			if( Collection::deleteCollection($id) ){
				$message = "Library deleted succesfully";
			} else{
				$message = "Unable to delete Library";
			}
		} else{
			$message = "Unable to delete Library";
		}
		header("Location:/TODO-PHP-OOP?msg=" . $message);exit;
	}
	else if(!empty($_POST["moveCollection"])){

		$id = filter_input(INPUT_POST, "id", FILTER_SANITIZE_NUMBER_INT);
		$id_collection = filter_input(INPUT_POST, "collectionSelected", FILTER_SANITIZE_NUMBER_INT);

		if( !empty($id) && !empty($id_collection) ){
			if(Collection::moveCollection($id, $id_collection)){
				$name_collection = Collection::getCollection($id_collection)["name"];
				$msg = "This COLLECTION has been successfully moved to " . $name_collection;
			}
		}else{
			$msg = "Unable to moved TODO";
		}

		header("Location:/TODO-PHP-OOP/views/library.php?id=". $id ."&msg=" . $msg);exit;
	}
	else if(!empty($_POST["action"])){
		$state = filter_input(INPUT_POST, "action", FILTER_SANITIZE_STRING);
		if($state == "createCollection"){

			$name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING);
			$description = filter_input(INPUT_POST, "description", FILTER_SANITIZE_STRING);
			$fatherCollection_id = filter_input(INPUT_POST, "collection", FILTER_SANITIZE_STRING);
			//FUNCTION
			$collection = new Collection($name, $description, $fatherCollection_id);
			$id = $collection->addCollection($collection->getName(),
																			 $collection->getDescription(),
																		 	 $collection->getfatherCollection_id());
			if(!empty($id)){
				header("Location:./library.php?id=".$id);exit;
			} else{
				header("Location:./mytodos.php?msg=collection%20not%20found");exit;
			}
		} else if($state == "deleteElements"){
			$array_post = $_POST;
			foreach($array_post as $key=>$item){
				if( !($key == "action") && !($key == "id") ){
					$cleanKey = preg_replace("/[0-9]+/","", htmlentities($key));//EITHER todo OR subcollection

					if($cleanKey == "todo"){
						$id_item = filter_input(INPUT_POST, $key, FILTER_SANITIZE_NUMBER_INT);

						Todo::deleteTodo($id_item);
					} else{// => SUBCOLLECTION
						$id_item = filter_input(INPUT_POST, $key, FILTER_SANITIZE_NUMBER_INT);
						Collection::deleteCollection($id_item);
					}
				}
			}
			//variables
			$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);
			$collection = Collection::getCollection($id);
			$collections = Collection::getCollections();
			$collection["subcollections"] = Collection::getSubcollections($id);
			$collection["path"] = Collection::getFullPath($collection["id"]);
			$collection["todos"] = Todo::getTodosByFatherId( $id );//here we are adding all the todos associate with that collection
			$title_heading = $collection["name"];
			$state = "readCollection";
			include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/single-library.php";
		} else{//moveElements
			$array_post = $_POST;
			foreach($array_post as $key=>$item){
				if( !($key == "action") && !($key == "id") ){
					$cleanKey = preg_replace("/[0-9]+/","", htmlentities($key));//EITHER todo OR subcollection

					if($cleanKey == "todo"){
						$id_item = filter_input(INPUT_POST, $key, FILTER_SANITIZE_NUMBER_INT);

						//Todo::deleteTodo($id_item);
					} else{// => SUBCOLLECTION
						$id_item = filter_input(INPUT_POST, $key, FILTER_SANITIZE_NUMBER_INT);
						//Collection::deleteCollection($id_item);
					}
				}
			}
			//variables
			$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);
			$collection = Collection::getCollection($id);
			$collections = Collection::getCollections();
			$collection["subcollections"] = Collection::getSubcollections($id);
			$collection["path"] = Collection::getFullPath($collection["id"]);
			$collection["todos"] = Todo::getTodosByFatherId( $id );//here we are adding all the todos associate with that collection
			$title_heading = $collection["name"];
			$state = "readCollection";
			include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/single-library.php";
		}
	}
}
