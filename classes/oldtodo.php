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
		include($_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/inc/connection.php");
		require_once $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/classes/tag.php";
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
		#$tags which is an array
		# iterate for the array and in each tag check the next possibilities
		# 1-check if the "tag" doesn't exist on the todo_app_tags TABLE
		#   ----> if does, retrive the ID
		#   ----> if does NOT, add it
		#_______________________________
		# 2-retrive the id_todo and the id_tag and add them on the relational TABLE todo_tag

		$id_todo = self::getTodoByName( $name )["id"];

		foreach($tags as $t){
			$tag = new Tag( $t );

			$existTag = $tag->existTag( $t );
			if( $existTag ){ # NOT FALSE => the TAG exist
				$id_tag = $existTag["id"];

			} else{ # the TAG does exist
				#then added on TABLE tag
				$tag->addTag( $tag->getName() );
				$id_tag = $tag->getTagByName( $tag->getName() )["id"];
			}				
			# add the pair id_todo-id_tag to the table "todo_tag"
			$sql = "INSERT INTO todo_app_todo_tag ( id_tag, id_todo ) VALUES (?,?)";

			try{
				$db->query("SET FOREIGN_KEY_CHECKS=0");
				$result = $db->prepare( $sql );
				$result->bindParam( 1, $id_tag, PDO::PARAM_STR );
				$result->bindParam( 2, $id_todo, PDO::PARAM_STR );
				$result->execute();
				$db->query("SET FOREIGN_KEY_CHECKS=1");

			} catch (Exception $e){
				echo "Bad query on, " . __METHOD__ . " " . $e->getMessage();
				return false;
			}
		}
		return $id_todo;	
	}

	public static function getTodo($id){

		include($_SERVER['DOCUMENT_ROOT']. "/TODO-PHP-OOP/inc/connection.php");

		$sql = "SELECT todo_app_todos.*, todo_app_tags.name AS 'tag_name' 
				FROM todo_app_todos
				LEFT JOIN todo_app_todo_tag ON (todo_app_todos.id = todo_app_todo_tag.id_todo)
				LEFT JOIN todo_app_tags ON (todo_app_todo_tag.id_tag = todo_app_tags.id)
				WHERE todo_app_todos.id = ?";
		try{
			$result = $db->prepare($sql);
			$result->bindParam(1, $id, PDO::PARAM_INT);
			$result->execute();
		} catch (Exception $e){
			echo "Bad query in '" . __METHOD__ . "', " . $e->getMessage();
			return false;
		}

		return $result->fetchAll(PDO::FETCH_ASSOC);
	}

	public static function getTodoByName( $name ){
		include($_SERVER['DOCUMENT_ROOT']. "/TODO-PHP-OOP/inc/connection.php");
		$name = strtolower($name);

		$sql = "SELECT * FROM todo_app_todos WHERE name = ?";

		try{
			$result = $db->prepare($sql);
			$result->bindParam(1, $name, PDO::PARAM_STR);
			$result->execute();
		}catch (Exception $e){
			echo "Bad query in '" . __METHOD__ . "', " . $e->getMessage();
			return false;
		}

		return $result->fetch(PDO::FETCH_ASSOC);
	}

	public static function getTodosByFatherId( $id ){
		include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/inc/connection.php";

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

		require($_SERVER['DOCUMENT_ROOT']. "/TODO-PHP-OOP/inc/connection.php");
		require_once($_SERVER['DOCUMENT_ROOT']. "/TODO-PHP-OOP/classes/tag.php");

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

	public static function updateTodo( $id, $name = null, $description = null, $id_collection = null, $tags = null, $id_user = null, $level )
	{
		include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/inc/connection.php";
		require_once $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/classes/tag.php";
		require_once $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/inc/functions.php";

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
						"level"=>$level
					);
		foreach($updateTodo as $key=>$value){
			if(empty($value)){
				$updateTodo[$key] = $todo[$key];
			}
		}
		//TAGS
		$tags = Tag::getIdTagByIdTodo( $id );
		foreach( $tags as $t ){
			$arrayTag[] = Tag::getTag( $t["id"] )["name"];
		}
		$tagsComparation = compareArrays($tags, $arrayTag);
		if( !$tagsComparation ){
			Tag::upateTag( $id, $tags );
		}
		
		$sql = "UPDATE todo_app_todos SET name = ?, description = ?, updated_date = CURRENT_TIMESTAMP, id_collection = ? , level = ? WHERE id = ?";		

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

		return true;	
	}

}