<?php
class TodoLogic extends Todo{

  private $page_title;
  private static $page_heading;
  private $msg;
  private static $state;
  private $todo_id;
  private $user_id;
  private $todo_father_id;
  private $todo_name;
  private $todo_descripiton;
  private $todo_created_date;
  private $todo_updated_date;
  private $todo_tags;
  private $todo_level;
  private static $todo_full_list_collections;

  function __construct( $todo_id, $user_id ){

    $aux = parent::getTodo( $todo_id );

    if( !empty( $aux["id"] ) ){
      $this->set__todo_id( $todo_id );
      $this->set__user_id( $user_id );
      $this->set__todo_name( $aux["name"] );
      $this->set__todo_father_id( $aux["id_collection"] );
      $this->set__todo_description( $aux["description"] );
      $this->set__todo_created_date( $aux["created_date"] );
      $this->set__todo_updated_date( $aux["updated_date"] );
      $this->set__todo_level( $aux["level"] );
      if( !empty( $aux["tags"] ) ){
        $this->set__todo_tags( $aux["tags"] );
      }

      self::$todo_full_list_collections = Collection::getCollections( $this->get__user_id() );
    }
  }

  //*******SETTERS & GETTERS*******
  public function get__todo_id(){
    return $this->todo_id;
  }
  public function get__user_id(){
    return $this->user_id;
  }
  public function get__todo_father_id(){
    return $this->todo_father_id;
  }
  public function get__todo_name(){
    return $this->todo_name;
  }
  public function get__todo_description(){
    return $this->todo_description;
  }
  public static function get__page_heading(){
    return self::$page_heading;
  }
  public function get__select_elements(){
    return $this->select_elements;
  }
  public function get__todo_created_date(){
    return $this->todo_created_date;
  }
  public function get__todo_updated_date(){
    return $this->todo_updated_date;
  }
  public function get__todo_level(){
    return $this->todo_level;
  }
  public function get__todo_tags(){
    return $this->todo_tags;
  }
  public static function get__state(){
    return self::$state;
  }
////////////////////////////////////////////////
  private function set__todo_id( $todo_id ){
    $this->todo_id = $todo_id;
  }
  private function set__user_id( $user_id ){
    $this->user_id = $user_id;
  }
  private function set__todo_name( $todo_name ){
    $this->todo_name = $todo_name;
  }
  private function set__todo_description( $todo_description ){
    $this->todo_description = $todo_description;
  }
  private function set__todo_father_id( $todo_father_id ){
    $this->todo_father_id = $todo_father_id;
  }
  private function set__todo_level( $todo_level ){
    $this->todo_level = $todo_level;
  }
  private function set__todo_tags( $todo_tags ){
    $this->todo_tags = $todo_tags;
  }
  private function set__page_title( $page_title ){
    $this->page_title = $page_title;
  }
  private static function set__page_heading( $page_heading ){
    self::$page_heading = $page_heading;
  }
  public function set__todo_created_date( $todo_created_date ){
    $this->todo_created_date = $todo_created_date;
  }
  public function set__todo_updated_date( $todo_updated_date ){
    $this->todo_updated_date = $todo_updated_date;
  }
  private static function set__state( $state ){
    self::$state = $state;
  }

  function readTodo_logic( $todo_id, $action=null ){
    $output = [];
    if( isset( $action ) && ($action === "edit_todo") ){//EDIT TODO
      self::set__page_heading( "edit todo" );
      self::set__state( "editTodo" );
      $output[0] = $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/auxiliar-templates/pre-body.php";
      $output[1] = $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/todoform.php";
      $output[2] = $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/message.php";
    }
    else{
      self::set__page_heading( $this->get__todo_name() );
      self::set__state( "readTodo" );
      $output[0] = $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/header.php";
      $output[1] = $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/todo.php";
      $output[2] = $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/footer.php";
    }

    return $output;
  }

  static function createTodo_logic(){
    $output = [];
    if( !empty( $action ) ){//EDIT TODO
      self::set__page_heading( "edit todo" );
      self::set__state( "editTodo" );
    }
    else{
    self::set__page_heading( "create todo" );
    self::set__state( "createTodo" );
    }

    $output[0] = $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/header.php";
    $output[1] = $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/todoform.php";
    $output[2] = $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/footer.php";

    return $output;
  }

  static function deleteTodo_logic( $todo_id ){

    if(!empty( $todo_id )){
			if( parent::deleteTodo( $todo_id ) ){
				$msg = "TODO deleted succesfully";
			} else{
				$msg = "Unable to delete TODO: # $todo_id";
			}
		} else{
			$msg = "Unable to delete TODO. Invalid ID";
		}

		header("Location:/TODO-PHP-OOP/views/mytodos.php?msg=$msg"); exit();

  }

  function moveTodo_logic( $todo_id, $todo_name, $collection_id ){

    if( !empty($todo_id) && !empty($collection_id) ){
      if(parent::moveTodo($todo_id, $collection_id)){
        $name_collection = Collection::getCollection($collection_id)["name"];
        $msg = "TODO has been moved successfully";
      }
    }else{
      $msg = "Unable to moved TODO";
    }
    header("Location:/TODO-PHP-OOP/views/todo.php?id=$todo_id&msg=$msg" );
    exit;
  }

  static function editTodo_logic( $array_post ){

    $id = filter_input(INPUT_POST, "edit_todo", FILTER_SANITIZE_NUMBER_INT);
    $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING);
		$level = filter_input(INPUT_POST, "level", FILTER_SANITIZE_STRING);
		$description = filter_input(INPUT_POST, "description", FILTER_SANITIZE_STRING);
		$collection = filter_input(INPUT_POST, "collection", FILTER_SANITIZE_NUMBER_INT);
    if(!empty($array_post["tags"])){
			$tags = filter_input(INPUT_POST, "tags", FILTER_SANITIZE_STRING);
			$tags = explode(",", $tags);
		} else{
			$tags = NULL;
		}

    if( parent::updateTodo( $id, $name, $description, $collection, $tags, 1, $level) ){
      $msg = "TODO: '$name', successfully edited!";
    } else{
      $msg = "Unable to edit TODO: '$name'";
    }
    header("Location:/TODO-PHP-OOP/views/todo.php?id=$id&msg=$msg");
    exit;
  }

  static function addTodo_logic( $array_post ){
    $level = $_POST["level"];
		if(!empty($_POST["description"])){
			$description = trim(filter_input(INPUT_POST, "description", FILTER_SANITIZE_STRING));
		}
		if(!empty($_POST["library"])){//change for father_id
			$library = filter_input(INPUT_POST, "library", FILTER_SANITIZE_NUMBER_INT);
		}
		if(!empty($_POST["tags"])){
			$tags = trim( filter_input(INPUT_POST, "tags", FILTER_SANITIZE_STRING) );
			$tags = explode(",", $tags);    //PATTOR-msg=> I changed this from " " to ", "
		}
		if(!empty($_POST["name"])){
			$name = trim( filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING) );
			if(empty($name)){
				$msg = "A TITLE must be given";
			} else{
				$id = parent::addTodo( $name, $description, $library, $tags, 1, $level);
        $msg = "TODO: '$name' was created successfully!";
				header("Location: /TODO-PHP-OOP/views/todo.php?id=$id&msg=$msg" );
        exit;
			}
		}
    return;
  }

}
