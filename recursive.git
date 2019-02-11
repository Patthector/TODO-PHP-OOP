<?php

/*

$row = array(
	["id" => 1, "father_id" => null],
	["id" => 2, "father_id" => null],
	["id" => 3, "father_id" => null, 
		"subcollection" => [
			"id" => 4, 
			"father_id" => 3, 
			"name" => "Pattor"
			]
	]
);


$row = array(
	["id" => 1, "father_id" => null],
	["id" => 2, "father_id" => null],
	["id" => 3, "father_id" => null]
);

$subcollection = array("id" => 5, "father_id" => 4, "name" => "Stivali");
*/
function organizeCollections($row, $subcollection){

	if( !empty( $row[ "id" ] ) && $row[ "id" ] == $subcollection[ "id_fatherCollection" ] ){
		//echo "BREAK -- IF \n";
		//echo '$row = '; var_dump($row);
		$row["subcollection"] = $subcollection;
	}

	foreach( $row as $key=>$array ){
		//echo "FOREACH \n";
		//echo '$array = '; var_dump($array);

		if( is_array($array) && $array[ "id" ] != null  ){

			//echo "FOREACH -- IF \n";
			//echo '$row = '; var_dump($row);
			$aux = organizeCollections($array, $subcollection);
			if( !empty( $aux["subcollection"] ) ){
				$row[$key] = $aux;
			}
			
		} else{
			continue;
		}
	}

	return $row;
}

function readCollections($collections){

	foreach($collections as $collection){

		if(is_array($collection)){
			
			var_dump($collection); echo "\n";
			if(!empty($collection["subcollection"])){
				readCollections($collection["subcollection"]);
			}
		}
	}
	return;
}

/*

echo "\n";
echo "--- \n";
echo "ROW";
echo "\n---";
echo "\n";
//$finalResult = createDropdown($row, $subcollection);

echo "\n";
echo "--- \n";
echo "FINAL RESULT";
echo "\n---";
echo "\n";
var_dump($finalResult);
*/

public static function getFullPath( $id, $path = null){

		include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/inc/connection.php";	
		echo "This is the begining .ID: $id \n";

		if(is_null( $id )){
			echo "\n got in \n";
			//var_dump($path);
			return $path;
		}

		$sql = "SELECT * FROM todo_app_collections WHERE id = ?";
		try{
			$result = $db->prepare( $sql );
			$result->bindParam(1, $id, PDO::PARAM_INT);
			$result->execute();
		} catch (Exception $e){
			echo "Bad query in " . __METHOD__ . ", " . $e->getMessage();
			return false;
		}

		$path[] = $result->fetch(PDO::FETCH_ASSOC);
		$new_id = $path[count($path) - 1]["id_fatherCollection"];
		echo "New ID: $new_id \n";
		echo "\n PATH \n";
		var_dump($path);
		$path = self::getFullPath($new_id , $path);

		//self::getFullPath( $path[count($path) - 1]["id"] );
		/*
		foreach($a as $ele){
			echo "Inside FOREACH \n";
			echo "Element: ";
			var_dump($ele);
			echo "\n";
			if($ele["id"] == $id){
				$path[] = $ele;
				echo "PATH \n";
				var_dump($path);
				
					$new_id = $path[count($path) - 1]["father_id"];
					echo "\n newId: $new_id \n";
					$path = self::getFullPath($new_id , $path = $path);				
			}
		}*/
		
		return $path;
	}

}

$db_example = array(
		[	
			"id" => 1,
			"father_id" =>NULL
		],
		[
			"id" => 2,
			"father_id" =>4
		],
		[	
			"id" =>3,
			"father_id" =>2
		],
		[	
			"id" =>4,
			"father_id" =>6
		],
		[	
			"id" =>5,
			"father_id" =>NULL
		],
		[	
			"id" =>6,
			"father_id" =>NULL
		],
		[	
			"id" =>7,
			"father_id" =>6
		]

		);
var_dump(Collection::getFullPath(5));
# 3/2/4/6 