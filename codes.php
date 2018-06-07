<?php
public static function getCollections($limit = null, $offset = null){

		include($_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/inc/connection.php");
		include($_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/recursive.php");

		# HOW TO CREATE A DROPDOWN COLLECTION/SUBCOLLECTION
		# retrive all main collection FROM collection TABLE

		$sql = "SELECT * FROM todo_app_collections WHERE id_fatherCollection IS NULL"; # just MAIN Collections!
		try{
			$collections = $db->prepare( $sql );
			$collections->execute();

		} catch(Exception $e){
			echo "Bad query in " . __METHOD__ . ", " . $e->getMessage();
			return false;
		}

		$collections = $collections->fetchAll(PDO::FETCH_ASSOC);
		

		# call all the subcollections
		$sql = "SELECT * FROM todo_app_collections WHERE id_fatherCollection IS NOT NULL"; 
		try{
			$subcollections = $db->prepare( $sql );
			$subcollections->execute();

		} catch(Exception $e){
			echo "Bad query in " . __METHOD__ . ", " . $e->getMessage();
			return false;
		}

		while( $row = $subcollections->fetch(PDO::FETCH_ASSOC)){
			# execute the WHILE as far as we have SUBCOLLECTIONS
			# with each subcollections given, one by one recreate/reorganize the array collection in a way that each subcollection is with its respective collection
			# for this task use the recursive function organizeCollections();

			$collections = organizeCollections( $collections, $row );
			# $collections : the entire ARRAY of Collections
			# $row : the particular subcollection we want to add

		}
		return $collections;
	}


	public static function readCollections($collections){

		foreach($collections as $collection){

			if(is_array($collection)){
				
				var_dump($collection["name"]); echo "\n";
				if(!empty($collection["subcollection"])){
					readCollections($collection["subcollection"]);
				}
			}
		}
		return;
	}

	public function getSubcollections( $id ){
		include "inc/connection.php";

		# retrive all the subcollection of a given collection

		$sql = "SELECT id FROM todo_app_collections WHERE id_fatherCollection = ?";
		try{
			$results = $db->prepare($sql);
			$results->bindParam(1, $id, PDO::PARAM_INT);
			$results->execute();
		} catch (Exception $e){
			echo "Bad query in " .__METHOD__. ", " . $e->getMessage();
			return false;
		}
		return $results->fetchAll(PDO::FETCH_ASSOC);
	}


	