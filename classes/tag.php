<?php
/**
 *
 */
class Tag
{
	private $name;

	function __construct($name)
	{
		$this->name = $name;
	}

	function getName(){
		return $this->name;
	}
	public static function addTag( $tag ){
		include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP [with JS]/inc/connection.php";
		$tag = strtolower( $tag );

		$sql = "INSERT INTO todo_app_tags (name) VALUES (?)";

		try{
			$result = $db->prepare( $sql );
			$result->bindParam( 1, $tag, PDO::PARAM_STR );
			$result->execute();

		} catch( Exception $e){
			echo "Bad query in " . __METHOD__ . ", " . $e->getMessage();
			return false;
		}
		return true;
	}

	public static function addingTodoTagRelationship( $id_todo, $tags ){
		include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP [with JS]/inc/connection.php";
		# 1-check if "tags[i]" exists on the todo_app_tags TABLE
		#   ----> if does, retrive the ID
		#   ----> if does NOT, add it on th TABLE

		foreach($tags as $t){
			$existTag = self::existTag( $t );
			if( $existTag ){ # TRUE => the TAG exist
				$id_tag = $existTag["id"];

			} else{ # the TAG does exist
				#then added on TABLE tag
				self::addTag( $t );
				$id_tag = self::getLastTag( )["id"];
				var_dump($id_tag);
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
		return true;
	}

	public function existTag( $tag ){
		include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP [with JS]/inc/connection.php";
		$tag  = strtolower( $tag );

		$sql = "SELECT * FROM todo_app_tags WHERE name = LOWER(?)";

		try{
			$result = $db->prepare( $sql );
			$result->bindParam( 1, $tag, PDO::PARAM_STR);
			$result->execute();

		} catch(Exception $e){
			echo "Bad query in " . __METHOD__ . ", " . $e->getMessage();
			return false;
		}
		return empty($result) ? false : $result->fetch(PDO::FETCH_ASSOC);
	}

	public static function getTag( $id ){
		include($_SERVER['DOCUMENT_ROOT']. "/TODO-PHP-OOP [with JS]/inc/connection.php");

		$sql = "SELECT * FROM todo_app_tags WHERE id = ?";

		try{
			$result = $db->prepare($sql);
			$result->bindParam(1, $id, PDO::PARAM_INT);
			$result->execute();
		}catch (Exception $e){
			echo "Bad query in '" . __METHOD__ . "', " . $e->getMessage();
			return false;
		}

		return $result->fetch(PDO::FETCH_ASSOC);
	}

	public static function getLastTag( )
	{
		include($_SERVER['DOCUMENT_ROOT']. "/TODO-PHP-OOP [with JS]/inc/connection.php");
		$sql =	"SELECT * FROM todo_app_tags ORDER BY  id DESC LIMIT 1";

		try{
			$result = $db->prepare($sql);
			$result->execute();
		}catch (Exception $e){
			echo "Bad query in '" . __METHOD__ . "', " . $e->getMessage();
			return false;
		}
		return $result->fetch(PDO::FETCH_ASSOC);

	}

	public static function getTagByName( $name ){
		include($_SERVER['DOCUMENT_ROOT']. "/TODO-PHP-OOP [with JS]/inc/connection.php");
		$name = strtolower($name);

		$sql = "SELECT * FROM todo_app_tags WHERE name LIKE ?";

		try{
			$result = $db->prepare($sql);
			$result->bindValue(1, "%" . $name . "%", PDO::PARAM_STR);
			$result->execute();
		}catch (Exception $e){
			echo "Bad query in '" . __METHOD__ . "', " . $e->getMessage();
			return false;
		}

		return $result->fetchAll(PDO::FETCH_ASSOC);
	}

	public static function deleteTagById( $id ){
		include($_SERVER['DOCUMENT_ROOT']. "/TODO-PHP-OOP [with JS]/inc/connection.php");

		$sql = "DELETE FROM todo_app_tags WHERE id = ?";

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

		return true;
	}

	public static function deleteTodoTagRelation($id_todo){
		include($_SERVER['DOCUMENT_ROOT']. "/TODO-PHP-OOP [with JS]/inc/connection.php");

		$sql = "DELETE FROM todo_app_todo_tag WHERE id_todo = ?";

		try{
			$db->query("SET FOREIGN_KEY_CHECKS=0");
			$result = $db->prepare($sql);
			$result->bindParam(1, $id_todo, PDO::PARAM_INT);
			$result->execute();
			$db->query("SET FOREIGN_KEY_CHECKS=1");
		}catch (Exception $e){
			echo "Bad query in '" . __METHOD__ . "', " . $e->getMessage();
			return false;
		}

		return true;
	}

	#-------------------
	# Auxiliar Functions
	#-------------------

	public static function getIdTagByIdTodo($id_todo){
		include($_SERVER['DOCUMENT_ROOT']. "/TODO-PHP-OOP [with JS]/inc/connection.php");

		$sql = "SELECT id_tag FROM todo_app_todo_tag WHERE id_todo = ? ";

		try{
			$result = $db->prepare($sql);
			$result->bindParam(1, $id_todo);
			$result->execute();

		}catch (Exception $e){
			echo "Bad query in '" . __METHOD__ . "', " . $e->getMessage();
			return false;
		}

		return $result->fetchAll(PDO::FETCH_ASSOC);
	}

	# this function will check if after the deletion of todo_tag relationship the tag still remains in the TABLE 	"todo_app_todo_tag".
	public static function idTagExists($id){
		include($_SERVER['DOCUMENT_ROOT']. "/TODO-PHP-OOP [with JS]/inc/connection.php");

		$sql = "SELECT * FROM todo_app_todo_tag WHERE id_tag = (?)";

		try{
			$result = $db->prepare( $sql );
			$result->bindParam( 1, $id, PDO::PARAM_INT);
			$result->execute();

		} catch(Exception $e){
			echo "Bad query in " . __METHOD__ . ", " . $e->getMessage();
			return false;
		}
		return empty($result->fetch()) ? false : true;
	}

	public static function updateTag( $id_todo, $tags ){
		include($_SERVER['DOCUMENT_ROOT']. "/TODO-PHP-OOP [with JS]/inc/connection.php");

		# WORKING WITH OLD TAGS
		#------------------------------------------------------------
		# 1- delete all the tags related with this particular todo
		# 2- if the tag(s) doesn't have any other TODO related, then delete it
		#
		# WORKING WITH NEW TAGS
		#------------------------------------------------------------
		# 1- Add the tags on the tags TABLE
		# 2- Add the relation TODO_TAG on the TABLE todo_tag

		# get the $id_tag for a couple of checks
		$ids_tag = Tag::getIdTagByIdTodo( $id_todo );
		# Then delete the todo_tag relationship
		Tag::deleteTodoTagRelation( $id_todo );

		# check if the tag is still present in TABLE todo_app_todo_tag
		# ---> if it's that means the tag has a relationship with another TODO and cannot be deleted BUT
		# ---> if it's NOT that means that tag was related just with the TODO that was deleted and we can 			delete the tag as well.

		foreach( $ids_tag as $tag){
			if( !Tag::idTagExists( $tag["id_tag"] ) ){ #FALSE

				Tag::deleteTagById( $tag["id_tag"] );
			}
		}
		# WORKING WITH NEW TAGS
		self::addingTodoTagRelationship( $id_todo, $tags );
		return true;
	}

}
