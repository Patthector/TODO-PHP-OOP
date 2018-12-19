<?php
//CLASSES
//----------
require_once $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/classes/todo.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/classes/collection.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/classes/library.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/classes/tag.php";
//require_once $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/functions/todo.php";
//require_once $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/functions/library.php";

//GET
if( $_SERVER[ "REQUEST_METHOD" ] == "GET" ){
  //qualcuno a voluto vedere un po' di pui
  // e debi andare via da qui
  header( "location:./mytodos.php" );
  exit;
}
else if( $_SERVER[ "REQUEST_METHOD" ] == "POST" ){
  //questa e una chiamata de elementi venuta di
  // mytodos.php search-bar
  $searchResults = [];

  if( !empty( $_POST["search-bar--submit"] ) ){
    if( !empty( $_POST["search-bar--input"] ) ){
      $search_name = trim( filter_input( INPUT_POST, "search-bar--input", FILTER_SANITIZE_STRING ) );
    }
    if( !empty( $_POST["todo__form-radio--todo-name"] ) ){
      $todo_table = true;
      $searchResults["todos"] = Todo::searchTodoByName( $search_name );
    }
    if( !empty( $_POST["todo__form-radio--collection-name"] ) ){
      $collection_table = true;
      $searchResults["collections"] = Collection::searchCollectionByName( $search_name );
    }
    if( !empty( $_POST["todo__form-radio--tag-name"] ) ){
      $tag_table = true;
      $searchResults["tags"] = Tag::searchTagByName( $search_name );
    }
    include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/header.php";
    include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/levels-of-imp-bar.php";
    include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/message.php";
    //include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/search-bar.php";
    include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/search.php";
    include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/footer.php";
  }
}
