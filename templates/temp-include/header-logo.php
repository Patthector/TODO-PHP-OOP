<?php
if( class_exists( "TodoLogic" ) && !empty( TodoLogic::get__state() ) ){
  switch ( TodoLogic::get__state() ) {
    case "createTodo":
      include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/inc/blue-logo.html";
      break;

    case "editTodo":
      include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/inc/blue-logo.html";
      break;

    case "readTodo":
     include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/inc/white-logo.html";
      break;

    default:
      include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/inc/white-logo.html";
      break;
  }
} else if( class_exists( "CollectionLogic" ) && !empty( CollectionLogic::get__state() ) ){
  switch ( CollectionLogic::get__state() ) {
    case "createCollection":
      include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/inc/blue-logo.html";
      break;

    case "editCollection":
      include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/inc/blue-logo.html";
      break;

    case "readCollection":
     include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/inc/white-logo.html";
      break;

    default:
      include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/inc/white-logo.html";
      break;
  }
} else{
  include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/inc/white-logo.html";
}
?>
