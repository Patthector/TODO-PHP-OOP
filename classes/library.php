<?php

class Library
{
	public static function retriveFullLibrary( $limit = 12, $offset = null ){

		include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/inc/connection.php";
		require_once $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/classes/collection.php";
		# get all Libraries without restrictions
		#---------------------------------------
		# 1-) get collections
		$sql = "SELECT * FROM todo_app_collections ORDER BY created_date, updated_date LIMIT ?";

		try{
			$collections = $db->prepare( $sql );
			$collections->bindParam( 1, $limit, PDO::PARAM_INT);
			$collections->execute();
		} catch (Exception $e){
			echo "Bad Query selecting collection in " . __METHOD__ . " ," . $e->getMessage();
			return false;
		}

		# 2-) get subcollectionS where each of the collections retrived are their fathers

		while($row = $collections->fetch(PDO::FETCH_ASSOC)){

			$id_row_collection = $row["id"];
			//creationg full path
			$row["path"] = Collection::getFullPath($id_row_collection);
			//
			$sql = "SELECT * FROM todo_app_collections WHERE id_fatherCollection = ? ORDER BY name LIMIT 6 ";

			try{
				$subcollections = $db->prepare($sql);
				$subcollections->bindParam( 1, $id_row_collection, PDO::PARAM_INT );
				$subcollections->execute();
			} catch (Exception $e){
				echo "Bad Query in selecting subcollections " . __METHOD__ . " ," . $e->getMessage();
				return false;
			}

			# 3-) storage the subcollections on the correspondant collection
			$row["subcollections"] =  $subcollections->fetchAll(PDO::FETCH_ASSOC);


			# 4-) get at least [if exists] 6 TODO's for each COLLECTION
			$sql = "SELECT * FROM todo_app_todos WHERE id_collection = ? LIMIT 6 ";

			try{
				$todos = $db->prepare($sql);
				$todos->bindParam( 1, $id_row_collection, PDO::PARAM_INT );
				$todos->execute();
			} catch (Exception $e){
				echo "Bad Query selecting todos in " . __METHOD__ . " ," . $e->getMessage();
				return false;
			}
			# 5-) storage the todos on the correspondant collection
			$row["todos"] =  $todos->fetchAll(PDO::FETCH_ASSOC);

			$library[] = $row;

		}
		return $library;

	}

	public static function renderFullPath($fullPath){
		$path = "<ul>";
		$fullPath = array_reverse($fullPath);
		foreach($fullPath as $key=>$collection){
			if( $key == (count($fullPath) - 1 ) ){
				$path .= "<li>" . $collection["name"] . "</li>";
			} else{
				$path .= "<li><a href ='" . $collection["id"] . "'>" . $collection["name"] . "</a></li>";
			}
		}
		$path .= "</ul>";
		return $path;
	}

}
