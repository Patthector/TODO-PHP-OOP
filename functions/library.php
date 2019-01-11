<?php

class CollectionLogic extends Collection{

  private $page_title;
  private $page_heading;
  private static $msg;
  private static $state;
  private $collection_id;
  private $user_id;
  private $collection_name;
  private $collection_descripiton;
  private $collection_created_date;
  private $collection_updated_date;
  private $collection_subcollections;
  private $collection_path;
  private $collection_todos;
  //
  private $select_elements = false;

  function __construct( $collection_id, $get_full_library =  null ){

   $aux = self::getCollection( $collection_id );
   $this->set__collection_id( $aux["id"] );

   if( !empty( $this->collection_id ) ){ // => if we have collection, let's finish building it
     $this->collection_name = $aux["name"];
     $this->user_id = $aux["id_user"];

     if( !empty( $get_full_library ) && $get_full_library ){
       $this->set__collection_father_id( $aux["id_fatherCollection"] );
       $this->set__collection_description( $aux["description"] );
       $this->set__collection_created_date( $aux["created_date"] );
       $this->set__collection_updated_date( $aux["updated_date"] );
       $this->set__collection_subcollections( self::getSubcollections( $this->get__collection_id() ) );
       $this->set__collection_path( self::getFullPath( $this->get__collection_id() ) );
       $this->set__collection_todos( self::getTodosByFatherId( $this->get__collection_id() ) );
       $this->set__title_heading( $this->get__collection_name() );
     }
    }
  }

  //*******SETTERS & GETTERS*******
  public function get__collection_id(){
    return $this->collection_id;
  }
  public function get__user_id(){
    return $this->user_id;
  }
  public function get__collection_father_id(){
    return $this->collection_father_id;
  }
  public function get__collection_name(){
    return $this->collection_name;
  }
  public function get__collection_description(){
    return $this->collection_description;
  }
  public function get__collection_subcollections(){
    return $this->collection_subcollections;
  }
  public function get__collection_path(){
    return $this->collection_path;
  }
  public function get__collection_todos(){
    return $this->collection_todos;
  }
  public function get__page_heading(){
    return $this->page_heading;
  }
  public function get__select_elements(){
    return $this->select_elements;
  }
  public function get__collection_created_date(){
    return $this->collection_created_date;
  }
  public function get__collection_updated_date(){
    return $this->collection_updated_date;
  }
  public static function get__state(){
    return self::$state;
  }
  public static function get__msg(){
    return self::$msg;
  }
  public static function get__full_list_collections( $user_id ){
    return parent::getCollections( $user_id );
  }
//////////////////////////////////////////////////////
  protected function set__collection_id( $collection_id ){
    $this->collection_id = $collection_id;
  }
  protected function set__collection_father_id( $collection_father_id ){
    $this->collection_father_id = $collection_father_id;
  }
  protected function set__collection_name( $collection_name ){
    $this->collection_name = $collection_name;
  }
  protected function set__collection_description( $collection_description ){
    $this->collection_description = $collection_description;
  }
  protected function set__collection_subcollections( $collection_subcollections ){
    $this->collection_subcollections = $collection_subcollections;
  }
  protected function set__collection_path( $collection_path ){
    $this->collection_path = $collection_path;
  }
  protected function set__collection_todos( $collection_todos ){
    $this->collection_todos = $collection_todos;
  }
  protected function set__collection_created_date( $collection_created_date ){
    $this->collection_created_date = $collection_created_date;
  }
  protected function set__collection_updated_date( $collection_updated_date ){
    $this->collection_updated_date = $collection_updated_date;
  }
  protected function set__page_title( $page_title ){
    $this->page_title = $page_title;
  }
  protected function set__page_heading( $page_heading ){
    $this->page_heading = $page_heading;
  }
  protected function set__title_heading( $title_heading ){
    $this->title_heading = $title_heading;
  }
  protected function set__select_elements( $value ){
    $this->select_elements = $value;
  }
  public static function set__state( $state ){
    self::$state = $state;
  }
  public static function set__msg( $msg ){
    self::$msg = $msg;
  }

  public static function collection_createCollection( $array_post, $user ){

    $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING);
    $description = filter_input(INPUT_POST, "collection_description", FILTER_SANITIZE_STRING);
    $fatherCollection_id = filter_input(INPUT_POST, "father_collection", FILTER_SANITIZE_STRING);
    $user_id = filter_var( $user->get__userId(), FILTER_SANITIZE_STRING );

    $collection = new Collection($name, $user_id, $description, $fatherCollection_id);
    $id = $collection->addCollection($collection->getName(),
                                     $collection->getUserId(),
                                     $collection->getDescription(),
                                     $collection->getfatherCollection_id());
    if(!empty($id)){
      $msg = "Collection \"$name\" created successfully.";
      header("Location:./library.php?id=$id&msg=$msg");exit;
    } else{
      $msg = "A problem has been encounter while creating this Collection!";
      header("Location:./mytodos.php?msg=$msg");exit;
    }
  }

  public function collection_readCollection(  ){
    $output = [];
    $output[0] = $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/header.php";
    $output[1] = $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/library.php";
    $output[2] = $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/footer.php";
    return $output;
  }

  public static function collection_formCollection(  ){
    $output = [];
    $output[0] = $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/header.php";
		$output[1] = $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/libraryform.php";
		$output[2] = $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/footer.php";
    return $output;
  }

  public static function collection_editCollection( ){

    $id = filter_input(INPUT_POST, "editCollection", FILTER_SANITIZE_NUMBER_INT);
    $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING);
    $description = filter_input(INPUT_POST, "collection_description", FILTER_SANITIZE_STRING);
    $fatherCollection = filter_input(INPUT_POST, "father_collection", FILTER_SANITIZE_NUMBER_INT);

    if( parent::updateCollection( $id, $name, $description, $fatherCollection ) ){
      $msg = "Collection: '$name', successfully edited!";
    } else{
      $msg = "Unable to edit Collection: '$name'";
    }
    header("Location:/TODO-PHP-OOP/views/library.php?id=$id&msg=$msg");
    exit;
  }

  public function collection_determineAction( $action ){
    $output = [];
    switch($action){
      //---EDIT COLLECTION---
      case "editCollection":
        $this->set__page_heading( "edit collection" );
        self::set__state( "editCollection" );
        self::set__msg( "Update all the fields that you wish in your collection!" );
        $output[0] = $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/auxiliar-templates/pre-body.php";
        $output[1] = $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/libraryform.php";
        $output[2] = $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/message.php";
        break;
      //---SELECT ELEMENTS---
      case "selectElements":
        $this->set__select_elements(true);
        self::set__msg( "Select the elements you want to move/delete and the click in the menu icon to proceed with the action." );
        $output[0] = $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/message.php";
        $output[1] = $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/auxiliar-templates/single-library.php";
        $output[2] = $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/auxiliar-templates/delete-collection-elements.php";
        $output[3] = $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/auxiliar-templates/move-todo-modal.php";
        $output[4] = $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/auxiliar-templates/delete-todo-modal.php";
        break;
      //---REWIND COLLECTION
      case "reReadCollection":
        self::set__state( "readCollection" );
        self::set__msg( "Don't worry. Everything is back to normal." );
        $output[0] = $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/message.php";
        $output[1] = $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/auxiliar-templates/single-library.php";
        $output[2] = $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/auxiliar-templates/move-todo-modal.php";
        $output[3] = $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/auxiliar-templates/delete-todo-modal.php";
        break;
    }
    return $output;
  }

  public function collection_deleteCollection( $collection_id ){
    if(!empty($collection_id)){
			if( (self::deleteCollection( $collection_id )) == true ){
				$msg = "Library deleted succesfully";
			} else{
				$msg = "Unable to delete Library";
			}
		} else{
			$msg = "Unable to delete Library. Invalid ID.";
		}
    header("Location:/TODO-PHP-OOP/views/mytodos.php?msg=$msg");
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
		header("Location:/TODO-PHP-OOP/views/library.php?id=". $id_collection ."&msg=".$msg);
    exit;
  }

  public function collection_deleteElements( $array_post ){
    $output = [];
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
    self::set__msg( "Elements deleted successfully" );
    $output[0] = $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/auxiliar-templates/single-library.php";
    $output[1] = $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/message.php";
    return $output;
  }

  public function collection_moveElements( $array_post, $id_fatherCollection ){
    $output = [];
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
    self::set__msg( "Elements moved successfully" );
    $output[0] = $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/auxiliar-templates/single-library.php";
    $output[1] = $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/message.php";
    return $output;
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
