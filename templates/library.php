<?php //Probably this menu section will be in the future an independent template
  include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/action-menu.php";
  include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/message.php";
?>
<main role = "main">

<?php
  include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/single-library.php";
//including the MODALS
  include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/delete-todo-modal.php";
  include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/move-todo-modal.php";
  include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/delete-collection-elements.php";
?>
