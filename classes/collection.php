<?php

# This is COLLECTION object, this could be a:->Collection
#											:->Subcollection
# with the next Properties:
# -------------------------
# name,
# description,
# fatherCollection_id,
# todoList,
# subCollectionList[],
# created_date

# and Methods:
# -------------
# addCollection($name, $desciption = null, $fatherCollection_id)
# getCollection($id)
# updateCollection($id, $name = null, $description = null, 		  	subCollectionList[]=null)
# deleteCollection($id)
#

/**
 *
 */
class Collection
{
	private $name;
	private $user_id;
	private $description;
	private $todoList = array();
	private $fatherCollection_id;

	function __construct( $name, $user_id, $description = null, $fatherCollection_id = null )
	{
		$this->name = $name;
		$this->user_id = $user_id;
		$this->description = $description;
		if(empty($fatherCollection_id)){
			$this->fatherCollection_id = 1;//the collection UNKONWN is the main father/collection
		}else {
			$this->fatherCollection_id = $fatherCollection_id;
		}

	}

	public function getName( ){
		return $this->name;
	}
	public function getUserId( ){
		return $this->user_id;
	}
	public function getDescription( ){
		return $this->description;
	}
	public function getfatherCollection_id( ){
		return $this->fatherCollection_id;
	}

	public function addCollection( $name, $user_id, $description = null, $fatherCollection_id = null ){
		include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/inc/connection.php";
		# this method could be use to add either a new collection or subcollection, if a subcollection is added $fatherCollection_id will be filled.

		#--------------------------------#
		# JSON approch needs to be check #
		#--------------------------------#
		$sql = "INSERT INTO todo_app_collections VALUES (NULL, ?, ?, ?, CURRENT_TIMESTAMP(), ?, NULL)";

		try{
			$result = $db->prepare( $sql );
			$result-> bindParam( 1, $name, PDO::PARAM_STR );
			$result-> bindParam( 2, $description, PDO::PARAM_STR );
			$result-> bindParam( 3, $user_id, PDO::PARAM_INT );
			$result-> bindParam( 4, $fatherCollection_id, PDO::PARAM_INT );
			$result->execute();

		} catch(Exception $e){
			echo "Bad query in " . __METHOD__ . ", " . $e->getMessage();
			return false;
		}
		$id_collection = $this->getCollectionByName( $name );

		return $id_collection["id"];
	}

	public static function getCollection( $id ){
		include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/inc/connection.php";

		$sql = "SELECT * FROM todo_app_collections WHERE id = ?";

		try{
			$result = $db->prepare($sql);
			$result->bindParam(1, $id, PDO::PARAM_INT);
			$result->execute();

		} catch(Exception $e){
			echo "Bad query in " . __METHOD__ . ", " . $e->getMessage();
			return false;
		}
		return $result->fetch(PDO::FETCH_ASSOC);
	}

	public function getCollectionByName( $name ){
		include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/inc/connection.php";
		$name = strtolower( $name );

		$sql = "SELECT id FROM todo_app_collections WHERE LOWER(name) = ?";

		try{
			$result = $db->prepare($sql);
			$result->bindParam(1, $name, PDO::PARAM_STR);
			$result->execute();

		} catch(Exception $e){
			echo "Bad query in " . __METHOD__ . ", " . $e->getMessage();
			return false;
		}
		return $result->fetch(PDO::FETCH_ASSOC);
	}

	public static function getCollections( $user_id, $limit = null, $offset = null){

		include($_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/inc/connection.php");

		$sql = "SELECT id FROM todo_app_collections WHERE id_user = ? ORDER BY name ASC";
		try{
			$collections = $db->prepare( $sql );
			$collections->bindParam( 1, $user_id, PDO::PARAM_INT );
			$collections->execute();

		} catch(Exception $e){
			echo "Bad query in " . __METHOD__ . ", " . $e->getMessage();
			return false;
		}
		return $collections->fetchAll(PDO::FETCH_ASSOC);
	}

	public static function getSubcollections( $id ){
		include($_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/inc/connection.php");

		$sql = "SELECT * FROM todo_app_collections WHERE id_fatherCollection = ?";
		try{
			$subCollections = $db->prepare( $sql );
			$subCollections->bindParam( 1, $id, PDO::PARAM_INT );
			$subCollections->execute();

		} catch(Exception $e){
			echo "Bad query in " . __METHOD__ . ", " . $e->getMessage();
			return false;
		}
		return $subCollections->fetchAll(PDO::FETCH_ASSOC);
	}

	public static function moveCollection($id, $id_collection){
		include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/inc/connection.php";

		$sql = "UPDATE todo_app_collections SET id_fatherCollection = ?
				WHERE id = ?";

		try{
			$result = $db->prepare($sql);
			$result->bindValue(1, $id_collection, PDO::PARAM_INT);
			$result->bindValue(2, $id, PDO::PARAM_INT);
			$result->execute();
		} catch (Exception $e){
			echo "Bad query in the " . __METHOD__ . ", " . $e->getMessage();
			return false;
		}
		return true;
	}

	public static function updateCollection($id, $name = null, $description = null, $fatherCollection_id = null ){
		include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/inc/connection.php";

		$old_collection = self::getCollection( $id );
		$new_collection = self::generationCollectionSchema( $id, $name, $description, $fatherCollection_id );

		$sql = "UPDATE todo_app_collections SET name = ?, description = ?, id_fatherCollection = ?
				WHERE id = ?";

		try{
			$result = $db->prepare($sql);
			$result->bindValue(1, $name, PDO::PARAM_STR);
			$result->bindValue(2, $description, PDO::PARAM_STR);
			$result->bindValue(3, $fatherCollection_id, PDO::PARAM_INT);
			$result->bindValue(4, $id, PDO::PARAM_INT);
			$result->execute();
		} catch (Exception $e){
			echo "Bad query in the " . __METHOD__ . ", " . $e->getMessage();
			return false;
		}
		return true;
	}

	public static function unlinkFatherCollection( $father_id ){
		include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/inc/connection.php";

		$sql = "UPDATE todo_app_collections SET id_fatherCollection = 1
				WHERE id_fatherCollection = ?";

		try{
			$result = $db->prepare( $sql );
			$result->bindValue( 1, $father_id, PDO::PARAM_INT );
			$result->execute();
		} catch (Exception $e){
			echo "Bad query in the " . __METHOD__ . ", " . $e->getMessage();
			return false;
		}
		return true;
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

	public static function deleteCollection( $id ){
		include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/inc/connection.php";
		require_once $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/classes/todo.php";

		# Update the value of the subcategories "fatherCollection_id" to NULL
		# Delete the TODOs
		# Delete the category
		#____________________________________________________________________

		# 1- Unlink Subcollections
		self::unlinkFatherCollection( $id );

		# 2- Delete TODOs
		$todos = self::getTodosByFatherId( $id );
		foreach( $todos as $t ){
			Todo::deleteTodo( $t["id"] );
		}
		# 3- Delete Collection
		$sql = "DELETE FROM todo_app_collections WHERE id = ?";
		try{
			$result = $db->prepare($sql);
			$result->bindParam(1, $id, PDO::PARAM_INT);
			$result->execute();
		} catch (Exception $e){
			echo "Bad query in " .__METHOD__. ", " . $e->getMessage();
			return false;
		}
		return true;
	}

	public static function getFullPath( $id, $path = null){

		include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/inc/connection.php";
		# This function will generate a full path of a particular Collection
		# example-----------------------------------------------------------
		# Main Collection/Second Collection/Third Collection/The Collection
		#-------------------------------------------------------------------
		# the function will have a reference of the collection (ID). Will use
		# that ID to retrive the collection, and then will reset the ID's method
		# with the id_fatherCollection of the gotten Collection, and by this
		# way will be asking for father collections until finds the Main Collection


		if(is_null( $id )){
			# if ID is NULL it means we found the Main Collection
			return $path;
		}

		# retrive the collection from the DB base on the ID
		$sql = "SELECT id,name,id_fatherCollection FROM todo_app_collections WHERE id = ?";
		try{
			$result = $db->prepare( $sql );
			$result->bindParam(1, $id, PDO::PARAM_INT);
			$result->execute();
		} catch (Exception $e){
			echo "Bad query in " . __METHOD__ . ", " . $e->getMessage();
			return false;
		}
		# save the collection into an auxiliar array
		$path[] = $result->fetch(PDO::FETCH_ASSOC);
		# get the father ID of the collection to add it to the path
		$new_id = $path[count($path) - 1]["id_fatherCollection"];
		# restart the whole process again with the new ID
		$path = self::getFullPath($new_id , $path);

		return $path;
	}

	public static function generationCollectionSchema( $id, $name = null, $description = null, $fatherCollection_id = null ){

		# the objective of this function is generated the whole schema of a collection to avoid
		# NULL elements on the Table when updated and the value are not provided.

		$old_collection = self::getCollection( $id );
		$new_collection = array(
			"name" => $name,
			"description" => $description,
			"id_fatherCollection" => $fatherCollection_id );

		foreach( $new_collection as $key=>$value){
			echo "$key";
			if( is_null( $value ) ){
				$new_collection[ $key ] = $old_collection[ $key ];
			}
		}
		return $new_collection;
	}

	public static function searchCollectionByName( $name, $user_id ){
		include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/inc/connection.php";

		$sql = "SELECT id, name, description FROM todo_app_collections WHERE name LIKE ? AND id_user = ?";
		try{
			$results = $db->prepare( $sql );
			$results->bindValue(1, '%'.$name.'%', PDO::PARAM_STR );
			$results->bindParam(2, $user_id, PDO::PARAM_INT );
			$results->execute();
		} catch (Exception $e){
			echo "Bad query in " . __METHOD__ . ", " . $e->getMessage();
			return false;
		}
		return $results->fetchAll( PDO::FETCH_ASSOC );
}

	public static function preparingSearchResult( $name, $user_id ){
		include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/inc/connection.php";

		$sql = "SELECT id, name FROM todo_app_collections WHERE id_user = ?";

		try{
			$user_collections = $db->prepare( $sql );
			$user_collections->bindParam( 1, $user_id, PDO::PARAM_INT);
			$user_collections->execute();
		} catch( Exception $e ){
			echo "Bad query in ".__METHOD__.", ".$e->getMessage();
			exit;
		}
		//=>
		//the user's collections
		while( $row = $user_collections->fetch( PDO::FETCH_ASSOC ) ){

			//$row["collections"]
			//$row["todos"]
			//$row["tags"]

			$id_collection = $row["id"];
			//check the $search_name === $collection_name------------------------------------
			$sql = "SELECT id, name, description FROM todo_app_collections WHERE (id = ?) AND (name LIKE ? OR name = ?)";
			try{
				$user_search_collection = $db->prepare( $sql );
				$user_search_collection->bindParam( 1, $id_collection, PDO::PARAM_INT );
				$user_search_collection->bindValue( 2, "%" . $name . "%", PDO::PARAM_STR );
				$user_search_collection->bindParam( 3,  $name, PDO::PARAM_STR );
				$user_search_collection->execute();
			} catch ( Exception $e ){
				echo "Bad query in " . __METHOD__ . ", " . $e->getMessage();
				exit;
			}
			//=> the collection_name is equal to $search_name-----------------------------------
			$aux_collection = $user_search_collection->fetch( PDO::FETCH_ASSOC );
			if( !empty($aux_collection) ){
				$search_results["collections"][] = $aux_collection;
			}

			//----------------------------------------------------------------------------------
			//TODOS
			$row["todos"] = self::getTodosByFatherId( $id_collection );
			foreach( $row["todos"] as $item_todo ){

				$sql = "SELECT id, name, description FROM todo_app_todos WHERE (id = ?) AND (name LIKE ? OR name = ?)";
				try{
					$user_search_todo = $db->prepare( $sql );
					$user_search_todo->bindParam( 1, $item_todo["id"], PDO::PARAM_INT );
					$user_search_todo->bindValue( 2, "%" . $name . "%", PDO::PARAM_STR );
					$user_search_todo->bindParam( 3,  $name, PDO::PARAM_STR );
					$user_search_todo->execute();
				} catch ( Exception $e ){
					echo "Bad query in " . __METHOD__ . ", " . $e->getMessage();
					exit;
				}
				//=> the todo_name is equal to $search_name-----------------------------------
				$aux_todo = $user_search_todo->fetch( PDO::FETCH_ASSOC );
				if( !empty( $aux_todo ) ){
					$search_results["todos"][] = $aux_todo;
				}
				//----------------------------------------------------------------------------------
				//TAGS
				$sql = "SELECT id_tag, id_todo FROM todo_app_todo_tag WHERE (id_todo = ?)";
				try{
					$user_tags = $db->prepare( $sql );
					$user_tags->bindParam( 1, $item_todo["id"], PDO::PARAM_INT );
					$user_tags->execute();
				} catch ( Exception $e ){
					echo "Bad query in " . __METHOD__ . ", " . $e->getMessage();
					exit;
				}
				while( $tags = $user_tags->fetch( PDO::FETCH_ASSOC ) ){
					$sql = "SELECT id, name FROM todo_app_tags WHERE ( name LIKE ? OR name = ?) AND id = ?";
					try{
						$user_search_tag = $db->prepare( $sql );
						$user_search_tag->bindValue( 1, "%" . $name . "%", PDO::PARAM_STR );
						$user_search_tag->bindValue( 2, "%" . $name . "%", PDO::PARAM_STR );
						$user_search_tag->bindParam( 3, $tags["id_tag"], PDO::PARAM_INT );
						$user_search_tag->execute();
					} catch ( Exception $e ){
						echo "Bad query in " . __METHOD__ . ", " . $e->getMessage();
						exit;
					}
					//=> the tag_name is equal to $search_name-----------------------------------
					$aux_tag = $user_search_tag->fetch( PDO::FETCH_ASSOC );

					if( !empty($aux_tag) ){
						$search_results["tags"][$tags["id_tag"]] = $aux_tag;

						$sql = "SELECT id, name, description FROM todo_app_todos WHERE id = ?";
						try{
							$user_search_tag_todo = $db->prepare( $sql );
							$user_search_tag_todo->bindParam( 1, $tags["id_todo"], PDO::PARAM_INT );
							$user_search_tag_todo->execute();
						} catch ( Exception $e ){
							echo "Bad query in " . __METHOD__ . ", " . $e->getMessage();
							exit;
						}
						$search_results["tags"][$tags["id_tag"]]["todos"][] = $user_search_tag_todo->fetch(PDO::FETCH_ASSOC);
					}
				}
			}
		}
// what should i return where there are not solutions
		if(isset($search_results)){return $search_results;}
		else{return false;}
	}









}
