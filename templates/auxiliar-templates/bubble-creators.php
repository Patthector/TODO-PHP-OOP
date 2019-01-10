<?php

?>

<div class = "todo__bubble-creator--outer-container">
  <div class = "todo__bubble-creator--inner-container">
    <div class = "todo__bubble-creator--collection-container">
      <a href = "#" onclick = "createLibraryClicked()">
        <span class = "todo__bubble--logo">
          <?php include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/inc/archive-solid.svg"; ?>
        </span>
          <span>collection</span>
      </a>
    </div>
    <div class = "todo__bubble-creator--todo-container">
      <a href = "#" onclick = "createTodoClicked()">
        <span class = "todo__bubble--logo">
          <?php include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/inc/file-regular.svg"; ?>
        </span>
          <span>todo</span>
      </a>
    </div>
  </div>
</div>
