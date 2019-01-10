<?php

if( $_SERVER["REQUEST_METHOD"] == "GET" ){
  if( !empty( $_GET["action"])){
    $action = filter_input( INPUT_GET, "action", FILTER_SANITIZE_STRING );
    if( $action === "selectionForDelete" ){
      $selectionForDelete = true;
      include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/auxiliar-templates/post-action-menu.php";exit;

    } else if( $action === "selectionForMove" ){
      $selectionForMove = true;
      include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/auxiliar-templates/post-action-menu.php";exit;

    } else{
      //$action is not equal to non value
      //return the general menu
      include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/auxiliar-templates/action-menu.php";exit;
    }
    //include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/post-action-menu.php";exit;
  }
  else{
    //return the general menu
    include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/auxiliar-templates/action-menu.php";exit;
  }
}

 ?>
