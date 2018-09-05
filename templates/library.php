<?php //Probably this menu section will be in the future an independent template
  //var_dump($collection);exit;
  include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP [with JS]/templates/action-menu.php";
  include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP [with JS]/templates/message.php";
?>
<main role = "main">

<?php
  include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP [with JS]/templates/single-library.php";
//including the MODALS
  include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP [with JS]/templates/delete-todo-modal.php";
  include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP [with JS]/templates/move-todo-modal.php";
  include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP [with JS]/templates/delete-collection-elements.php";
?>
