<?php
# Includes
# ---------
require_once $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/classes/todo.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/classes/collection.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/classes/library.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/functions/todo.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/functions/library.php";
# Variables
# ---------
$title_page = "TODO | Stick it";
# Requests
# ---------
if($_SERVER["REQUEST_METHOD"] == "GET"){
	if(!empty($_GET["id"])){// TODO
		# this section of the code is getting an ID as possible todo's ID
		# and retriving from the database.
		# If that action is impossible cuz the ID is invalid or any other ERR!
		# the user will be sent to 'myTodos.php' with an err feedback.
		$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);
		$todo = new TodoLogic( $id );

		if( !empty( $todo->get__todo_id() )){ # if we have a todo, set the title heading with the TODO's name
			$todo_collection = new CollectionLogic( $todo->get__todo_father_id() );
			//HERE WE DECIDE IF WE ARE IN READ TODO OR EDIT TODO
			if(!empty($_GET["action"])){// EDIT TODO
				$action = filter_input(INPUT_GET, "action", FILTER_SANITIZE_STRING);
				$files = $todo->readTodo_logic( $todo->get__todo_id(), $action );

				foreach( $files as $file ){
					include $file;
				}exit;
			}
			else{//READ TODO
				$files = $todo->readTodo_logic( $todo->get__todo_id() );

				foreach( $files as $file ){
					include $file;
				}exit;
			}
		} else{
			$message = "TODO with ID: $id was not found on the DataBase!";
			header("Location: /TODO-PHP-OOP/views/mytodos.php?msg=" . $message);exit;
		}
	}
 // CREATE TODO
	else { # if the query is clean, we are in 'createtodo.php', and we want to create a TODO
		#this is a GET request
		# |
		# --->the query-string is clean, so this is the first time you get into this page.
		#     call the getlibraries() function
		$files = TodoLogic::createTodo_logic();
		$collections = Collection::getCollections();
		foreach( $files as $file ){
			include $file;
		}exit;
	}
}
///POST
if($_SERVER["REQUEST_METHOD"] == "POST"){

	if(!empty($_POST["deleteTodo"])){//DELETE TODO
		$id_todo = filter_input(INPUT_POST, "deleteTodo", FILTER_SANITIZE_NUMBER_INT);
		TodoLogic::deleteTodo_logic( $id_todo );
	}

	else if(!empty($_POST["moveTodo"])){//MOVE TODO

		$id_todo = filter_input(INPUT_POST, "id", FILTER_SANITIZE_NUMBER_INT);
		$id_collection = filter_input(INPUT_POST, "collectionSelected", FILTER_SANITIZE_NUMBER_INT);
		$todo = new TodoLogic( $id_todo );
		$todo->moveTodo_logic( $todo->get__todo_id(), $todo->get__todo_name(), $id_collection );

	}

	else if(!empty($_POST["edit_todo"])){//EDIT TODO
		TodoLogic::editTodo_logic( $_POST );
	}

	else if(!empty($_POST["create_todo"])){//CREATE TODO//
	# --->the FORM was submitted and the user wants to create the TODO
	TodoLogic::addTodo_logic( $_POST );
	}
}
