<?php
# Includes
# ---------
require_once $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP [with JS]/classes/todo.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP [with JS]/classes/collection.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP [with JS]/classes/library.php";

# Variables
# ---------
$title_page = "TODO | Stick it";
$title_heading = $message = $todo_title = $todo_description ="";

# Requests
# ---------
if($_SERVER["REQUEST_METHOD"] == "GET"){
	////////////////
	//READ TODO  //
	///////////////
	if(!empty($_GET["id"])){
		# this section of the code is getting an ID as possible todo's ID
		# and retriving from the database.
		# If that action is impossible cuz the ID is invalid or any other ERR!
		# the user will be sent to 'myTodos.php' with an err feedback.
		$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);
		$todo = Todo::getTodo($id);
		$collections = Collection::getCollections();

		if($todo){ # if we have a todo, set the title heading with the TODO's name
			$collection = Collection::getCollection($todo["id_collection"]);

			//HERE WE DECIDE IF WE ARE IN READ TODO OR EDIT TODO
			if(!empty($_GET["action"])){
				$action = filter_input(INPUT_GET, "action", FILTER_SANITIZE_STRING);

				switch($action){
				//---EDIT TODO---
					case "editItem":
						$todo_heading = "edit todo";
						$name = $todo["name"];
						$level = $todo["level"];
						$description = trim($todo["description"]);
						$tags = $todo["tags"];
						$action = filter_input(INPUT_GET, "action", FILTER_SANITIZE_STRING);
						$state = "editTodo";
						include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP [with JS]/templates/todoform.php";
						break;
				}
			} else{//VIEW MODE
					$title_heading = $todo["name"];
					$state = "readTodo";
					/*if(!empty($_GET["msg"])){ # redirection from POST cuz the form is not fill out completely
						$msg = trim(filter_input(INPUT_GET, "msg", FILTER_SANITIZE_STRING));
					} else{
						$message = "TODO NOT FOUND";
						header("Location: /TODO-PHP-OOP [with JS]/views/mytodos.php?msg=" . $message);exit;
					}*/

					//INCLUDE THE FILES
					include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP [with JS]/templates/header.php";
					include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP [with JS]/templates/todo.php";
					include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP [with JS]/templates/footer.php";
			}
		}
	}
	# CREATE TODO
	else if(count($_GET) == 0){ # if the query is clean, we are in 'createtodo.php', and we want to create a TODO
		#this is a GET request
		# |
		# --->the query-string is clean, so this is the first time you get into this page.
		#     call the getlibraries() function
		$todo_heading = "create todo";
		$collections = Collection::getCollections();
		$state = "createTodo";

		//INCLUDE THE FILES
		include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP [with JS]/templates/header.php";
		include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP [with JS]/templates/todoform.php";
		include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP [with JS]/templates/footer.php";
	}
}
////////////////
//DELETE TODO//
///////////////
if($_SERVER["REQUEST_METHOD"] == "POST"){
	if(!empty($_POST["deleteTodo"])){

		$id = filter_input(INPUT_POST, "deleteTodo", FILTER_SANITIZE_NUMBER_INT);

		if(!empty($id)){
			if( Todo::deleteTodo($id) ){
				$message = "TODO deleted succesfully";
			} else{
				$message = "Unable to delete TODO";
			}
		} else{
			$message = "Unable to delete TODO. Invalid \"ID\"";
		}
		header("Location:/TODO-PHP-OOP [with JS]?msg=" . $message);
	}
	////////////////
	//MOVE TODO//
	///////////////
	else if(!empty($_POST["moveTodo"])){

		$id_todo = filter_input(INPUT_POST, "id", FILTER_SANITIZE_NUMBER_INT);
		$id_collection = filter_input(INPUT_POST, "collectionSelected", FILTER_SANITIZE_NUMBER_INT);

		if( !empty($id_todo) && !empty($id_collection) ){
			if(Todo::moveTodo($id_todo, $id_collection)){
				$name_collection = Collection::getCollection($id_collection)["name"];
				$msg = "This TODO has been successfully moved to " . $name_collection;
			}
		}else{
			$msg = "Unable to moved TODO";
		}

		header("Location:/TODO-PHP-OOP [with JS]/views/todo.php?id=". $id_todo ."&msg=" . $msg);exit;
	}
	////////////////
	//EDIT TODO//
	///////////////
	else if(!empty($_POST["edit_todo"])){

		$name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING);
		$id = filter_input(INPUT_POST, "edit_todo", FILTER_SANITIZE_NUMBER_INT);
		$level = filter_input(INPUT_POST, "level", FILTER_SANITIZE_STRING);
		$description = filter_input(INPUT_POST, "description", FILTER_SANITIZE_STRING);
		$collection = filter_input(INPUT_POST, "collection", FILTER_SANITIZE_NUMBER_INT);

		if(!empty($_POST["tags"])){
			$tags = filter_input(INPUT_POST, "tags", FILTER_SANITIZE_STRING);
			$tags = explode(",", $tags);
		} else{
			$tags = NULL;
		}

		if(empty($name)){
			$msg = "A TITLE must be given";
		} else{
			if( Todo::updateTodo( $id,$name, $description, $collection, $tags, 1, $level)){
				$msg = "&msg=TODO successfully edited";
			} else{
				$msg = "&msg=Unable to edit TODO";
			}
		}
		header("Location:/TODO-PHP-OOP [with JS]/views/todo.php?id=" . $id . "&msg=todo%20succesfully%20edited");exit;
	}
	////////////////
	//CREATE TODO//
	///////////////
	else if(!empty($_POST["create_todo"])){
	#this is a POST request
	# |
	# --->the FORM was submitted and the user wants to create the TODO
		$level = $_POST["level"];
		if(!empty($_POST["description"])){
			$description = filter_input(INPUT_POST, "description", FILTER_SANITIZE_STRING);
		}
		if(!empty($_POST["library"])){
			$library = filter_input(INPUT_POST, "library", FILTER_SANITIZE_NUMBER_INT);
		}
		if(!empty($_POST["tags"])){
			$tags = filter_input(INPUT_POST, "tags", FILTER_SANITIZE_STRING);
			$tags = explode(",", $tags);    //PATTOR-msg=> I changed this from " " to ", "
		}
		if(!empty($_POST["name"])){
			$name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING);
			#if the $name variable is empty=> send a message to the user
			#							 OR=> keep going with the TODO creation
			if(empty($name)){
				$message = "A TITLE must be given";
			} else{
				$id = Todo::addTodo( $name, $description, $library, $tags, 1, $level);
				header("Location: /TODO-PHP-OOP [with JS]/views/todo.php?id=" . $id ."&todo%20successfully%20added");
			}
		}
	}
}
