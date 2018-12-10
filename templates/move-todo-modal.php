<!--MOVE MESSAGE -->

<!--********************MOVE MODAL************************-->

<div class="modal fade todo__modal" id="move-todo-modal" tabindex="-1" role="dialog" aria-labelledby="todo__modal-move" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header todo__modal-info">
        <h4 class="modal-title " id="todo__modal-move">Access Permission</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php if(isset($state) && $state === "readTodo"){//READING TODO
          echo '<p>Select the Library where you are going to move this TODO: <b>' .$todo["name"]. '</b>.</p>';
        } else if(isset($state) && $state === "readCollection"){//READING COLLECTION
            echo '<p>Select the Library where you are going to move this Category: <b>' .$collection["name"]. '</b>.</p>';
          }else{//SELECTING ELEMENTS
            echo '<p>Select the Library where you are going to move those elements.</p>';
          }?>
        <form method = "POST" action =<?php if(isset($state) && $state === "readTodo"){ echo "todo.php";} else {echo "library.php";}?>>
          <div class = "form-group">
              <input type = "hidden" class = "form-control" name = "id" value = <?php if(isset($id)){echo $id;}else {echo 1;} ?>/>
          </div>
          <div class = "form-group">
            <select id = "todo__modal-move-select" class = "form-control" name = "collectionSelected" required>
              <option value=''>Select One Library</option>
              <?php
              foreach($collections as $item){
                if(isset($todo)){//=> we are on readTODO
                  if( !( $item["id"] === $todo["id_collection"] ) ){
                      echo "<option value='" . $item["id"] . "'>" . $item["name"] . "</option>";
                  }
                }else{//=> we are on readCollection
                  if( !( $item["id"] === $id ) && !($item["id"] === $collection["id_fatherCollection"]) ){
                      echo "<option value='" . $item["id"] . "'>" . $item["name"] . "</option>";
                  }
                }
              }
              ?>
            </select>
          </div>
          <input type = "hidden" name = <?php if(isset($state) && $state === "readTodo"){ echo "moveTodo";} else if(isset($state) && $state === "readCollection"){echo "moveCollection";}?>
                 value = <?php if(isset($state) && $state === "readTodo"){ echo "moveTodo";} else if(isset($state) && $state === "readCollection" ){echo "moveCollection";}?> />
          <input style = "display:none;" type = "submit" id = "move-todo-submit" />
        </form>
      </div>
      <div class="modal-footer todo__modal-footer">
        <button class="btn todo__btn-modal todo__btn-modal--default" data-dismiss="modal">Cancel</button>
        <?php
          if(isset($state)){// if we have an $state variable we are on readTODO || readCollection
            echo "<label class=\"btn todo__btn-modal todo__btn-modal--info\" for = \"move-todo-\">Move</label>";
          }else{// we are selectingElements
            echo "<button id = \"todo__modal-btn-submit\" class=\"btn todo__btn-modal todo__btn-modal--info\">Move</button";
          }
         ?>
      </div>
    </div>
  </div>
</div>


<!--**********************DELETE MODAL*********************-->

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
