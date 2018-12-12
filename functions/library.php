<?php

class CollectionLogic extends Collection{

  private $page_title;
  private $page_heading;
  private $msg;
  private static $state;
  private $collection_id;
  private $collection_name;
  private $collection_descripiton;
  private $collection_created_date;
  private $collection_updated_date;
  private $collection_subcollections;
  private $collection_path;
  private $collection_todos;
  private static $collection_full_list_collections;
  //
  private $select_elements = false;

  function __construct($collection_id){
   $this->collection_id = self::getCollection( $collection_id )["id"];

   if( !empty( $this->collection_id ) ){ // => if we have collection, let's finish building it
     $this->collection_name = self::getCollection( $this->get__collection_id() )["name"];
     $this->collection_father_id = self::getCollection( $this->get__collection_id() )["id_fatherCollection"];
     $this->collection_description = self::getCollection( $this->get__collection_id() )["description"];
     $this->collection_created_date = self::getCollection( $this->get__collection_id() )["created_date"];
     $this->collection_updated_date = self::getCollection( $this->get__collection_id() )["updated_date"];
     $this->collection_subcollections = self::getSubcollections( $this->get__collection_id() );
     $this->collection_path = self::getFullPath( $this->get__collection_id() );
     $this->collection_todos = self::getTodosByFatherId( $this->get__collection_id() );

     self::$collection_full_list_collections = self::getCollections();
     $this->title_heading = $this->get__collection_name();
    }
  }

  //*******SETTERS & GETTERS*******
  function get__collection_id(){
    return $this->collection_id;
  }
  function get__collection_father_id(){
    return $this->collection_father_id;
  }
  function get__collection_name(){
    return $this->collection_name;
  }
  function get__collection_description(){
    return $this->collection_description;
  }
  function get__collection_subcollections(){
    return $this->collection_subcollections;
  }
  function get__collection_path(){
    return $this->collection_path;
  }
  function get__collection_todos(){
    return $this->collection_todos;
  }
  function get__page_heading(){
    return $this->page_heading;
  }
  function get__select_elements(){
    return $this->select_elements;
  }
  function get__collection_created_date(){
    return $this->collection_created_date;
  }
  function get__collection_updated_date(){
    return $this->collection_updated_date;
  }
  static function get__state(){
    return self::$state;
  }
  static function get__collection_full_list_collections(){
    return self::$collection_full_list_collections;
  }

  function set__page_title( $page_title ){
    $this->page_title = $page_title;
  }
  function set__page_heading( $page_heading ){
    $this->page_heading = $page_heading;
  }

  function set__select_elements( $value ){
    $this->select_elements = $value;
  }
  static function set__state( $state ){
    self::$state = $state;
  }

  public static function collection_createCollection( $array_post ){

    $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING);
    $description = filter_input(INPUT_POST, "description", FILTER_SANITIZE_STRING);
    $fatherCollection_id = filter_input(INPUT_POST, "collection", FILTER_SANITIZE_STRING);

    $collection = new Collection($name, $description, $fatherCollection_id);
    $id = $collection->addCollection($collection->getName(),
                                     $collection->getDescription(),
                                     $collection->getfatherCollection_id());
    if(!empty($id)){
      header("Location:./library.php?id=".$id);exit;
    } else{
      $msg = "A problem has been encounter while creating this Collection!";
      header("Location:./mytodos.php");exit;
    }
  }

  public function readCollection( $action ){
    switch($action){
      //---EDIT COLLECTION---
      case "editItem":
        $this->set__page_heading( "edit collection" );
        self::set__state( "editCollection" );
        include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/libraryform.php";
        break;
      //---SELECT ELEMENTS---
      case "selectElements":
        $this->set__select_elements(true);
        include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/single-library.php";
        include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/move-todo-modal.php";
        break;
      //---REWIND COLLECTION
      case "reReadCollection":
        self::set__state( "readCollection" );
        include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/single-library.php";
        include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/move-todo-modal.php";
        break;
    }
  }

  public function collection_deleteCollection( $collection_id ){
    if(!empty($collection_id)){
			if( (self::deleteCollection( $collection_id )) == true ){
				$msg = "Library deleted succesfully";
			} else{
				$msg = "Unable to delete Library";
			}
		} else{
			$msg = "Unable to delete Library";
		}
    header("Location:/TODO-PHP-OOP/views/mytodos.php");
    exit;
  }

  public function collection_moveCollection( $id_collection, $id_placer_collection, $collection_name ){
    if( !empty($id_collection) && !empty($id_placer_collection) ){
			if(self::moveCollection($id_collection, $id_placer_collection)){
				$msg = "This COLLECTION has been successfully moved to " . $name_collection;
			}
		}else{
			$msg = "Unable to moved TODO";
		}
		header("Location:/TODO-PHP-OOP/views/library.php?id=". $id_collection);
    exit;
  }

  public function collection_deleteElements( $array_post ){

    foreach($array_post as $key=>$item){
      if( !($key == "action") && !($key == "id") ){
        $cleanKey = preg_replace("/[0-9]+/","", htmlentities($key));//EITHER todo OR subcollection
        if($cleanKey == "todo"){
          $id_item = filter_input(INPUT_POST, $key, FILTER_SANITIZE_NUMBER_INT);
          Todo::deleteTodo($id_item);
        } else{// => SUBCOLLECTION
          $id_item = filter_input(INPUT_POST, $key, FILTER_SANITIZE_NUMBER_INT);
          self::deleteCollection($id_item);
        }
      }
    }
    $this->set__page_heading( $this->get__collection_name() );
    self::set__state( "readCollection" );
    $msg = "Elements deleted successfully";
    include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/single-library.php";
    include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/message.php";
    return;
  }

  public function collection_moveElements( $array_post, $id_fatherCollection ){

    foreach( $array_post as $key => $item ){
      if( !($key == "action") && !($key == "id") && !($key == "fatherCollection") ){
        $cleanKey = preg_replace("/[0-9]+/","", htmlentities($key));//EITHER todo OR subcollection

        if($cleanKey == "todo"){
          $id_item = filter_input(INPUT_POST, $key, FILTER_SANITIZE_NUMBER_INT);

          Todo::moveTodo($id_item, $id_fatherCollection);
        } else{// => SUBCOLLECTION
          $id_item = filter_input(INPUT_POST, $key, FILTER_SANITIZE_NUMBER_INT);
          self::moveCollection($id_item, $id_fatherCollection);
        }
      }
    }
    //variables
    $this->set__page_heading( $this->get__collection_name() );
    self::set__state( "readCollection" );
    $msg = "Elements moved successfully";
    include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/single-library.php";
    include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/message.php";
    return;
  }

  //******HELPERS*****/
  public static function sanitizer($dirty_var_key_name, $type_var){
    switch ($type_var){
      case "int":
        return filter_input(INPUT_GET, $dirty_var_key_name, FILTER_SANITIZE_NUMBER_INT);
      case "string":
        return filter_input(INPUT_GET, $dirty_var_key_name, FILTER_SANITIZE_STRING);
    }
    return "";
  }
}
?>
