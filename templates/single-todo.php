<!--<div id = "action-menu" class = "todo__action-menu-container">
  <ul class = "todo__action-menu">

    <li id = "todo_todo-button-edit" data-toggle="modal" data-target="#edit-todo-modal"><?php //include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/inc/edit-regular.svg"; ?><span>Edit</span></li>
    <li data-toggle="modal" data-target="#move-todo-modal"><?php //include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/inc/exchange-alt-solid.svg"; ?><span>Move</span></li>
    <li data-toggle="modal" data-target="#delete-todo-modal"><?php //include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/inc/trash-alt-solid.svg"; ?><span>Delete</span></li>
  </ul>
</div>-->
<?php
  include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/action-menu.php";
  include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/message.php";
?>
<main role = "main">
<div id = "todo_single-todo" class = "todo__general-container first-container">

  <?php
    //.todo__general-container=> is a class that will center the content from top/bottom and left/right
  ?>
  <div class = "todo__todo-body">

    <div class = "top-right-absolute">
      <?php //.top-right-absolute=> is a class that will send the element with and absolute position to the top right.
      ?>
      <div class = "todo__item-category-name">
        <span>Category</span>
        <?php if(isset($todo['id_collection'])){
          echo "<a href='";
          echo "/TODO-PHP-OOP/views/library.php?id=" . $todo["id_collection"] . "\"";
          echo "'>";
          if(isset($collection["name"])){
            echo $collection["name"];
          }
          echo "</a>";
        }
        ?>
      </div>
    </div>
    <div class = "todo__todo-title">
      <h2 value = <?php echo $id;?> id = "todo_todo-name"><span><?php
      include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/inc/levelsOfImportance/12x12/level-".$todo["level"].".svg";
      ?></span><?php if(isset($todo["name"]))echo $todo["name"]; ?></h2>
    </div>
    <div class = "todo__todo-description-container">
      <p class = "todo__todo-description">
        <?php if(isset($todo["description"])) echo $todo["description"];
        ?>
      </p>
    </div>
  </div>

  <div class = "todo__library-tags">
    <ul class = "todo__library-tags-list">
      <?php
      if(!empty($todo["tags"])){
        foreach($todo["tags"] as $t){
          echo "<li><a href = \"#\">#$t</a></li>";
        }
      }
       ?>
    </ul>
  </div>

  <div class = "todo__library-footer">
    <p>Created be <span>@username</span> on <span><?php if(isset($todo["created_date"])) echo $todo["created_date"];?></span>. Last update on <span><?php if(isset($todo["created_date"])) echo $todo["updated_date"];?></span></p>
  </div>
</div>

<?php
//include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/update-todo-modal.php";
include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/delete-todo-modal.php";
include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/move-todo-modal.php";
?>
