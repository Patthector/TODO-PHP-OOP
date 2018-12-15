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
	private $description;
	private $todoList = array();
	private $fatherCollection_id;

	function __construct( $name, $description = null, $fatherCollection_id = null )
	{
		$this->name = $name;
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
	public function getDescription( ){
		return $this->description;
	}
	public function getfatherCollection_id( ){
		return $this->fatherCollection_id;
	}

	public function addCollection( $name, $description = null, $fatherCollection_id = null, $user = 1 ){

		include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/inc/connection.php";
		# this method could be use to add either a new collection or subcollection, if a subcollection is added $fatherCollection_id will be filled.

		#--------------------------------#
		# JSON approch needs to be check #
		#--------------------------------#
		$sql = "INSERT INTO todo_app_collections VALUES (NULL, ?, ?, 1, CURRENT_TIMESTAMP(), ?, NULL)";

		try{
			$result = $db->prepare( $sql );
			$result-> bindParam( 1, $name, PDO::PARAM_STR );
			$result-> bindParam( 2, $description, PDO::PARAM_STR );
			$result-> bindParam( 3, $fatherCollection_id, PDO::PARAM_INT );
			$result->execute();

		} catch(Exception $e){
			echo "Bad query in " . __METHOD__ . ", " . $e->getMessage();
			return false;
		}
		$id_collection = $this->getCollectionByName( $name );

		return $id_collection["id"];
	}

	public static function getCollection($id){
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
	public static function getCollections($limit = null, $offset = null){

		include($_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/inc/connection.php");

		$sql = "SELECT id FROM todo_app_collections ORDER BY name ASC";
		try{
			$collections = $db->prepare( $sql );
			$collections->execute();

		} catch(Exception $e){
			echo "Bad query in " . __METHOD__ . ", " . $e->getMessage();
			return false;
		}
		return $collections->fetchAll(PDO::FETCH_ASSOC);
	}
  /*
	public static function getCollections($limit = null, $offset = null){

		include($_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/inc/connection.php");

		$sql = "SELECT * FROM todo_app_collections ORDER BY name ASC";
		try{
			$collections = $db->prepare( $sql );
			$collections->execute();

		} catch(Exception $e){
			echo "Bad query in " . __METHOD__ . ", " . $e->getMessage();
			return false;
		}
		return $collections->fetchAll(PDO::FETCH_ASSOC);
	}*/

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











}
