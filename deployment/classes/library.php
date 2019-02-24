<?php

class Library
{
	public static function retriveFullLibrary( $user_id, $limit, $offset ){

		include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/inc/connection.php";
		require_once $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/classes/collection.php";
		# get all Libraries without restrictions
		#---------------------------------------
		# 1-) get collections
		$sql = "SELECT * FROM todo_app_collections
						WHERE id_user = ?
						ORDER BY created_date, updated_date LIMIT ? OFFSET ?";

		try{
			$collections = $db->prepare( $sql );
			$collections->bindParam( 1, $user_id, PDO::PARAM_INT);
			$collections->bindParam( 2, $limit, PDO::PARAM_INT);
			$collections->bindParam( 3, $offset, PDO::PARAM_INT);
			$collections->execute();
		} catch (Exception $e){
			echo "Bad Query selecting collection in " . __METHOD__ . " ," . $e->getMessage();
			return false;
		}

		# 2-) get subcollectionS where each of the collections retrived are their fathers

		/*while($row = $collections->fetch(PDO::FETCH_ASSOC)){

			$id_row_collection = $row["id"];
			//creationg full path
			/*
			$row["path"] = Collection::getFullPath($id_row_collection);
			//
			$sql = "SELECT * FROM todo_app_collections WHERE id_fatherCollection = ? ORDER BY name";

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

			$sql = "SELECT * FROM todo_app_todos
							WHERE id_collection = ?
							LIMIT 2 ";

			try{
				$todos = $db->prepare($sql);
				$todos->bindParam( 1, $id_row_collection, PDO::PARAM_INT );
				//$todos->bindParam( 2, 3, PDO::PARAM_INT );
				$todos->execute();
			} catch (Exception $e){
				echo "Bad Query selecting todos in " . __METHOD__ . " ," . $e->getMessage();
				return false;
			}
			# 5-) storage the todos on the correspondant collection
			$row["todos"] =  $todos->fetchAll(PDO::FETCH_ASSOC);

			$library[] = $row;

		}
		if( isset( $library ) )return $library;
		return false;*/
		return $collections;

	}

	public static function totalLibraries( $user_id ){

		include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/inc/connection.php";

		$sql = "SELECT COUNT(*) AS 'total_libraries' FROM todo_app_collections
						WHERE id_user = ?";

		try{
			$total_libraries = $db->prepare( $sql );
			$total_libraries->bindParam(1, $user_id, PDO::PARAM_INT);
			$total_libraries->execute();

		} catch (Exception $e){
			echo "Bad query  counting collections in ". __METHOD__ . ", " . $e->getMessage();
			return false;
		}
		return $total_libraries->fetch()['total_libraries'];

	}
}
