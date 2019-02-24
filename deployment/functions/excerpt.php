<?php

class Excerpt{

  private $excerpt_collection_name;
  private $excerpt_collection_description;
  private $excerpt_collection_path;
  private $excerpt_collection_subcollection;
  private $excerpt_collection_todo_description;
  private $excerpt_collection_todo_name;
  private $excerpt_todo_category;

  function __construct(){
    $this->set__collection_name( 48 );
    $this->set__collection_description( 100 );
    $this->set__collection_path( 24 );
    $this->set__collection_subcollection( 18 );
    $this->set__collection_todo_description( 245 );
    $this->set__collection_todo_name( 48 );
    $this->set__collection_todo_category( 18 );
  }
  //GETTER && SETTER
  public function get__collection_name(){
    return $this->excerpt_collection_name;
  }
  private function set__collection_name( $length ){
    $this->excerpt_collection_name = $length;
    return;
  }
  public function get__collection_description(){
    return $this->excerpt_collection_description;
  }
  private function set__collection_description( $length ){
    $this->excerpt_collection_description = $length;
    return;
  }
  public function get__collection_path(){
    return $this->excerpt_collection_path;
  }
  private function set__collection_path( $length ){
    $this->excerpt_collection_path = $length;
    return;
  }
  public function get__collection_subcollection(){
    return $this->excerpt_collection_subcollection;
  }
  private function set__collection_subcollection( $length ){
    $this->excerpt_collection_subcollection = $length;
    return;
  }
  //TODO-----
  public function get__collection_todo_description(){
    return $this->excerpt_collection_todo_description;
  }
  private function set__collection_todo_description( $length ){
    $this->excerpt_collection_todo_description = $length;
    return;
  }
  public function get__collection_todo_name(){
    return $this->excerpt_collection_todo_name;
  }
  private function set__collection_todo_name( $length ){
    $this->excerpt_collection_todo_name = $length;
    return;
  }
  public function get__collection_todo_category(){
    return $this->excerpt_collection_todo_category;
  }
  private function set__collection_todo_category( $length ){
    $this->excerpt_collection_todo_category = $length;
    return;
  }
  ////////////////////////////////////////////////////////////

  public function excerpt( $string, $length ){
    if( strlen( $string ) > $length ){

      $string = substr( $string, 0 , $length );
      $string .= "...";

    }
    return $string;
  }
}
