<?php

class User{
  private $user_id;
  private $username;
  private $password;

  function __construct( $user_id, $username, $password )
	{
    $this->set__userId( $user_id );
    $this->set__username( $username );
    $this->set__password( $password );
	}

  function get__userId(){
    return $this->user_id;
  }
  function get__username(){
    return $this->username;
  }
  function get__password(){
    return  $this->password;
  }

  private function set__userId( $user_id ){
    $this->user_id = $user_id;
  }
  private function set__username( $username ){
    $this->username = $username;
  }
  private function set__password( $password ){
    $this->password = $password;
  }

  public static function userExist ( $username ){
    include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/inc/connection.php";
    $username = strtolower( $username );

    $query = "SELECT id FROM todo_app_users WHERE user_name = ?";

    try{
      $result = $db->prepare( $query );
      $result->bindParam( 1, $username, PDO::PARAM_STR );
      $result->execute();

    } catch( Exception $e ){
      echo "Bad query in " .__METHOD__. ", " . $e->getMessage();
      exit;
    }
    return $result->fetchAll( PDO::FETCH_ASSOC );
  }

  public function getUser ( $user_id ){
    include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/inc/connection.php";

    $query = "SELECT * FROM todo_app_users WHERE id = ?";

    try{
      $result = $db->prepare( $query );
      $result->bindParam( 1, $user_id, PDO::PARAM_INT );
      $result->execute();

    } catch( Exception $e)
    {
      echo "Bad query in" . __METHOD__ . ", " . $e->getMessage();
      exit;
    }
    return $result->fetchAll( PDO::FETCH_ASSOC );

  }

  public static function addUser( $username, $password ){
     include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/inc/connection.php";

     $query = "INSERT INTO todo_app_users (id, user_name, password) VALUES(NULL, ?, ?)";

      try{
        $result = $db->prepare( $query );
        $result->bindParam( 1, $username, PDO::PARAM_STR );
        $result->bindParam( 2, $password, PDO::PARAM_STR );
        $result->execute();
      } catch( Exception $e){
        echo "Bad query in ". __METHOD__ . ", " . $e->getMessage();
        exit;
      }
      return true;
   }

}
