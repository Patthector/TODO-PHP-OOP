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
	# READ TODO
	if(!empty($_GET["id"])){
		# this section of the code is getting an ID as possible todo's ID
		# and retriving from the database.
		# If that action is impossible cuz the ID is invalid or any other ERR!
		# the user will be sent to 'myTodos.php' with an err feedback.
		$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);
		$todo = Todo::getTodo($id);
		$collections = Collection::getCollections();

		if($todo){# if we have a todo, set the title heading with the TODO's name
			$title_heading = $todo["name"];
			$collection = Collection::getCollection($todo["id_collection"]);
		} else{
			$message = "TODO NOT FOUND";
			header("Location: /TODO-PHP-OOP [with JS]/views/mytodos.php?msg=" . $message);exit;
		}
	}
	if(!empty($_GET["msg"])){ # redirection from POST cuz the form is not fill out completely
		$msg = trim(filter_input(INPUT_GET, "msg", FILTER_SANITIZE_STRING));
	}
	# CREATE TODO
	else if(count($_GET) == 0){ # if the query is clean, we are in 'createtodo.php', and we want to create a TODO
		header("Location: /TODO-PHP-OOP [with JS]/views/createtodo.php");exit;
	}
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
	if(!empty($_POST["delete"])){

		$id = filter_input(INPUT_POST, "delete", FILTER_SANITIZE_NUMBER_INT);

		if(!empty($id)){
			if( Todo::deleteTodo($id) ){
				$message = "TODO deleted succesfully";
			} else{
				$message = "Unable to delete TODO";
			}
		} else{
			$message = "Unable to delete TODO. Invalid \"ID\"";
		}
		header("Location:/TODO-PHP-OOP [with JS]/views/todo.php?msg=" . $message);
		//header("Location:/TODO-PHP-OOP [with JS]/views/todo.php?msg=" . $message);exit;
	}
	else if(!empty($_POST["move-todo_id-todo"])){//--MOVE--

		$id_todo = filter_input(INPUT_POST, "move-todo_id-todo", FILTER_SANITIZE_NUMBER_INT);
		$id_collection = filter_input(INPUT_POST, "move-todo_id-collection", FILTER_SANITIZE_NUMBER_INT);

		if( !empty($id_todo) && !empty($id_collection) ){
			if(Todo::moveTodo($id_todo, $id_collection)){
				$name_collection = Collection::getCollection($id_collection)["name"];
				$msg = "This TODO has been successfully moved to " . $name_collection;
			}
		}else{
			$msg = "Unable to moved TODO";
		}

		header("Location:/TODO-PHP-OOP [with JS]/views/todo.php?id=". $id_todo ."&msg=" . $msg);
		//header("Location:/TODO-PHP-OOP [with JS]/views/todo.php?msg=" . $message);exit;
	}
	else if(!empty($_POST["edit"])){

		$id = filter_input(INPUT_POST, "edit", FILTER_SANITIZE_NUMBER_INT);
		$level = $_POST["level"];
		$description = filter_input(INPUT_POST, "description", FILTER_SANITIZE_STRING);
		$collection = filter_input(INPUT_POST, "collection", FILTER_SANITIZE_NUMBER_INT);

		if(!empty($_POST["tags"])){
			$tags = filter_input(INPUT_POST, "tags", FILTER_SANITIZE_STRING);
			$tags = explode(" ", $tags);
		} else{
			$tags = NULL;
		}
		if(!empty($_POST["name"])){
			$name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING);
			#if the $name variable is empty=> send a message to the user
			#							 OR=> keep going with the TODO creation
			if(empty($name)){
				$message = "A TITLE must be given";
			} else{
				$id = Todo::updateTodo( $id,$name, $description, $collection, $tags, 1, $level);
				header("Location: /TODO-PHP-OOP [with JS]/views/todo.php?id=" . $id);exit;
			}
		} else{
			$message = "All the required field MUTS be fill out";
			header("Location:/TODO-PHP-OOP [with JS]/views/todo.php?id=" . $id . "&msg=" . $message);exit;
		}
		header("Location:/TODO-PHP-OOP [with JS]/views/todo.php?id=" . $id);exit;
	}
}

include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP [with JS]/templates/blue-header.php";
include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP [with JS]/templates/todo.php";
include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP [with JS]/templates/footer-absolute.php";
