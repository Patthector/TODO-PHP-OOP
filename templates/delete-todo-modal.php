<!-- DELETE MESSAGE -->
<!-- Modal -->
<div class="modal fade todo__modal" id="delete-todo-modal" tabindex="-1" role="dialog" aria-labelledby="todo__modal-delete" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header todo__modal-danger">
        <h4 class="modal-title" id="todo__modal-delete">Access Permission</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php
        if(isset($state) && $state === "readTodo"){//=> we are readingTodo
          echo "<p>You are about to proceed with the next action <b>DELETE ".$todo["name"] ."</b>. Are you sure you want to delete this item?</p>";
        } else if(isset($state) && $state === "readCollection"){//=> we are readingCollection
          echo "<p>You are about to proceed with the next action <b>DELETE " .$collection["name"]. "</b>. Are you sure you want to delete this item?</p>";
        } else{//=> we are selecting elements
          echo "<p>You are about to proceed with the next action <b>DELETE ELEMENTS</b>. Are you sure you want to delete those elements?</p>";
        }
        ?>
      </div>
      <div class="modal-footer todo__modal-footer">
        <button class="btn todo__btn-modal todo__btn-modal--default" data-dismiss="modal">Cancel</button>
        <?php
        if(isset($state)){// if we have an $state variable we are on readTODO || readCollection
          echo "<label class=\"btn todo__btn-modal todo__btn-modal--danger\" for = \"delete-todo-submit\">Delete</label>";
        } else{// we are selectingElements
          echo "<button id = \"todo__modal-btn-submit\" class=\"btn todo__btn-modal todo__btn-modal--danger\">Delete</button";
        }
        ?>
      </div>
    </div>
  </div>
</div>
<!--
<div class = "todo__delete-message">
  <form name = "delete_todo" method = "POST" action = <?php //if($state === "readTodo"){ echo "todo.php";} else if($state === "readCollection"){echo "library.php";}?>>
    <input type = "hidden" value = <?php //if(isset($id)){echo $id;}else {echo 1;} ?>
      name = <?php //if($state === "readTodo"){echo "deleteTodo";} else if($state === "readCollection"){echo "deleteCollection";} ?> />
    <input type = "submit" id = "delete-todo-submit" />
  </form>
</div>
-->
