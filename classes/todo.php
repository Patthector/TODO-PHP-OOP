<?php

# This is TODO object, which has the next
# properties:
#------------
# todo_name
# todo_body
# created_date
# updated_date
# id_collection (collection father)

# and Methods:
# ------------
# addTodo($name, $description)
# getTodo($id)
# deleteTodo($id)
# updateTodo($id, $name = null, $description = null, $id_collection = null)

/**
 *
 */
class Todo
{
	private $name;
	private $description;
	private $id_collection;

	function __construct($name, $description = null, $id_collection = null)
	{
		$this->name = $name;
		$this->description = $description;
		$this->id_collection = $id_collection;
	}

	#--------------------
	# Getters
	#--------------------
	public function getName(){
		return $this->name;
	}
	public function getDescription(){
		return $this->description;
	}
	public function getIdCollection(){
		# if the value is not set I dont want to return anything
		if(is_null($this->id_collection))return;
		else{
			return $this->id_collection;
		}
	}

	#---------------
	# CRUD-functions
	#---------------
	public static function addTodo($name, $description = null, $id_collection = null, $tags = null, $id_user = 1, $level = null)
	{
		include($_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP [with JS]/inc/connection.php");
		require_once $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP [with JS]/classes/tag.php";
		$name = strtolower($name);

		$sql = "INSERT INTO todo_app_todos VALUES(NULL, ?, ?, CURRENT_TIMESTAMP(), NULL, ?, ?, ?)";

		try{
			$db->query("SET FOREIGN_KEY_CHECKS=0");
			$results = $db->prepare( $sql );
			$results->bindParam( 1, $name, PDO::PARAM_STR);
			$results->bindParam( 2, $description, PDO::PARAM_STR);
			$results->bindParam( 3, $id_collection, PDO::PARAM_INT );
			$results->bindParam( 4, $id_user, PDO::PARAM_INT );
			$results->bindParam( 5, $level, PDO::PARAM_INT );

			$results->execute();
			$db->query("SET FOREIGN_KEY_CHECKS=1");

		} catch ( Exception $e ){
			echo "Bad query in " . __METHOD__ . ", " . $e->getMessage();
			return false;
		}
		#-------------------#
		## TAGS ##
		#
		# $tags which is an array
		# iterate for the array and in each tag check the next possibilities

		$id_todo = self::getTodoByName( $name )[0]["id"];
		if(!empty($tags)){var_dump($tags);
				Tag::addingTodoTagRelationship( $id_todo, $tags );
		}
		return $id_todo;
	}

	public static function getTodo($id){

		include($_SERVER['DOCUMENT_ROOT']. "/TODO-PHP-OOP [with JS]/inc/connection.php");
		require_once($_SERVER['DOCUMENT_ROOT']. "/TODO-PHP-OOP [with JS]/classes/tag.php");

		$sql = "SELECT * FROM todo_app_todos
				WHERE id = ?";
		try{
			$result = $db->prepare($sql);
			$result->bindParam(1, $id, PDO::PARAM_INT);
			$result->execute();
		} catch (Exception $e){
			echo "Bad query in '" . __METHOD__ . "', " . $e->getMessage();
			return false;
		}

		$result = $result->fetch(PDO::FETCH_ASSOC);
		# in this section of the method getTodo() we will retrive the tags related with it and will storege them in an array with the associate key "tags"
		$tags = Tag::getIdTagByIdTodo( $id );
		foreach( $tags as $t ){
			$result["tags"][] = Tag::getTag( $t["id_tag"] )["name"];
		}
		return $result;
	}

	public static function getTodoByName( $name ){
		include($_SERVER['DOCUMENT_ROOT']. "/TODO-PHP-OOP [with JS]/inc/connection.php");
		$name = strtolower($name);

		$sql = "SELECT * FROM todo_app_todos WHERE name LIKE ?";

		try{
			$result = $db->prepare($sql);
			$result->bindValue(1, "%".$name."%", PDO::PARAM_STR);
			$result->execute();
		}catch (Exception $e){
			echo "Bad query in '" . __METHOD__ . "', " . $e->getMessage();
			return false;
		}
		return $result->fetchAll(PDO::FETCH_ASSOC);
	}

	public static function getTodosByFatherId( $id ){
		include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP [with JS]/inc/connection.php";

		$sql = "SELECT * FROM todo_app_todos WHERE id_collection = ?";

		try{
			$result = $db->prepare($sql);
			$result->bindParam(1, $id, PDO::PARAM_INT);
			$result->execute();

		} catch(Exception $e){ 
			echo "Bad query in " . __METHOD__ . ", " . $e->getMessage();
			return false;
		}
		return $result->fetchAll(PDO::FETCH_ASSOC);
	}

	public static function deleteTodo($id){

		require($_SERVER['DOCUMENT_ROOT']. "/TODO-PHP-OOP [with JS]/inc/connection.php");
		require_once($_SERVER['DOCUMENT_ROOT']. "/TODO-PHP-OOP [with JS]/classes/tag.php");

		# get the $id_tag for a couple of checks
		$ids_tag = Tag::getIdTagByIdTodo( $id );
		# Then delete the todo_tag relationship
		Tag::deleteTodoTagRelation( $id );

		$sql = "DELETE FROM todo_app_todos WHERE id = ?";

		try{
			$db->query("SET FOREIGN_KEY_CHECKS=0");
			$result = $db->prepare($sql);
			$result->bindParam(1, $id, PDO::PARAM_INT);
			$result->execute();
			$db->query("SET FOREIGN_KEY_CHECKS=1");
		}catch (Exception $e){
			echo "Bad query in '" . __METHOD__ . "', " . $e->getMessage();
			return false;
		}

		# check if the tag is still present in TABLE todo_app_todo_tag
		# ---> if it's that means the tag has a relationship with another TODO and cannot be deleted BUT
		# ---> if it's NOT that means that tag was related just with the TODO that was delete and we can 			delete the tag as well.

		foreach( $ids_tag as $tag){
			if( !Tag::idTagExists( $tag["id_tag"] ) ){ #FALSE

				Tag::deleteTagById( $tag["id_tag"] );
			}
		}

		return true;
	}

	public static function moveTodo($id_todo, $id_collection){
		include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP [with JS]/inc/connection.php";

		$sql = "UPDATE todo_app_todos SET id_collection = ? WHERE id = ?";

		try{
			$db->query("SET FOREIGN_KEY_CHECKS=0");
			$result = $db->prepare($sql);
			$result->bindParam(1, $id_collection, PDO::PARAM_INT);
			$result->bindParam(2, $id_todo, PDO::PARAM_INT);
			$result->execute();
			$db->query("SET FOREIGN_KEY_CHECKS=1");
		}catch (Exception $e){
			echo "Bad query in '" . __METHOD__ . "', " . $e->getMessage();
			return false;
		}
		return true;
	}

	public static function updateTodo( $id, $name = null, $description = null, $id_collection = null, $tags = null, $id_user = null, $level )
	{
		include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP [with JS]/inc/connection.php";
		require_once $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP [with JS]/classes/tag.php";
		require_once $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP [with JS]/inc/functions.php";

		//TODOS
		$todo = self::getTodo( $id );
		$updateTodo = array(
						"id"=>$id,
						"name"=>$name,
						"description"=>$description,
						"created_date"=>NULL,
						"updated_date"=>NULL,
						"id_collection"=>$id_collection,
						"id_user"=>$id_user,
						"level"=>$level,
						"tags"=>$tags
					);
		foreach($updateTodo as $key=>$value){
			if(empty($value)){
				$updateTodo[$key] = $todo[$key];
			}
		}
		//TAGS
		$tagsById = Tag::getIdTagByIdTodo( $id );#get the $id_tag(s) base on the $id_todo.
		$arrayTag = array();
		foreach( $tagsById as $t ){
			$arrayTag[] = Tag::getTag( $t["id_tag"] )["name"];#get the tag_name using the $id_tag
		}

		$tagsComparation = compareArrays($tags, $arrayTag);#compare the $tags array given by the user with the array $arrayTag retrived from the DB
		if( !$tagsComparation ){# if the comparation field, this means the tags field was changed
			Tag::updateTag( $id, $tags );
		}

		$sql = "UPDATE todo_app_todos SET name = ?, description = ?, updated_date = CURRENT_TIMESTAMP(), id_collection = ? , level = ? WHERE id = ?";

		try{
			$results = $db->prepare($sql);
			$results->bindValue(1, $updateTodo["name"], PDO::PARAM_STR);
			$results->bindValue(2, $updateTodo["description"], PDO::PARAM_STR);
			$results->bindValue(3, $updateTodo["id_collection"], PDO::PARAM_INT);
			$results->bindValue(4, $updateTodo["level"], PDO::PARAM_INT);
			$results->bindValue(5, $updateTodo["id"], PDO::PARAM_INT);
			$results->execute();

		} catch (Exception $e){
			echo "Bad query in " . __METHOD__ . ", " . $e->getMessage();
			return false;
		}
		return $id;
	}

}
