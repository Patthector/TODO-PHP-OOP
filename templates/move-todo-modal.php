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
      </div><!--end-modal-header-->

      <div class="modal-body">
        <?php if( !empty(CollectionLogic::$state) && CollectionLogic::$state === "readTodo" ){//READING TODO
          echo '<p>Select the Library where you are going to move this TODO: <b>' .$todo["name"]. '</b>.</p>';
        } else if( !empty(CollectionLogic::$state) && CollectionLogic::$state === "readCollection" ){//READING COLLECTION
            echo '<p>Select the Library where you are going to move this Category: <b>' .$collection["name"]. '</b>.</p>';
          }else{//SELECTING ELEMENTS
            echo '<p>Select the Library where you are going to move those elements.</p>';
          }?>
        <form method = "POST" action =<?php if( !empty(CollectionLogic::$state) && CollectionLogic::$state === "readTodo" ){ echo "todo.php";} else {echo "library.php";}?>>
          <div class = "form-group">
              <input type = "hidden" class = "form-control" name = "id" value =
              <?php if( isset($todo) )
              {
                echo $id;
              }else if(isset($collection)){
                echo $collection->get__collection_id();
              }else
              {
                echo 1;
              } ?>/>
          </div><!--end-form-group-->

          <div class = "form-group">
            <select id = "todo__modal-move-select" class = "form-control" name = "collectionSelected" required>
              <option value=''>Select One Library</option>
              <?php
              $collections = CollectionLogic::get__collection_full_list_collections();
              foreach($collections as $item){
                if(isset($todo)){//=> we are on readTODO
                  if( !( $item["id"] === $todo["id_collection"] ) ){
                      echo "<option value='" . $item["id"] . "'>" . $item["name"] . "</option>";
                  }
                }else{//=> we are on readCollection
                  if( !( $item["id"] === $collection->get__collection_id() ) && !($item["id"] === $collection->get__collection_father_id()) ){
                      echo "<option value='" . $item["id"] . "'>" . $item["name"] . "</option>";
                  }
                }
              }
              ?>
            </select>
          </div><!--end-form-group-->

          <input type = "hidden" name = <?php if(isset($state) && $state === "readTodo"){ echo "moveTodo";} else if(isset($state) && $state === "readCollection"){echo "moveCollection";}?>
                 value = <?php if(isset($state) && $state === "readTodo"){ echo "moveTodo";} else if(isset($state) && $state === "readCollection" ){echo "moveCollection";}?> />
          <input style = "display:none;" type = "submit" id = "move-todo-submit" />
        </form>
      </div><!--end-modal-body-->

      <div class="modal-footer todo__modal-footer">
        <button class="btn todo__btn-modal todo__btn-modal--default" data-dismiss="modal">Cancel</button>
        <?php
          if(isset($state)){// if we have an $state variable we are on readTODO || readCollection
            echo "<label class=\"btn todo__btn-modal todo__btn-modal--info\" for = \"move-todo-submit\">Move</label>";
          }else{// we are selectingElements
            echo "<button id = \"todo__modal-btn-submit\" class=\"btn todo__btn-modal todo__btn-modal--info\" data-dismiss=\"modal\">Move</button>";
          }
         ?>
      </div><!--end-modal-footer-->
    </div><!--end-modal-content-->
  </div><!--end-modal-dialog-->
</div><!--modal-->


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
        if( !empty(CollectionLogic::$state) && CollectionLogic::$state === "readTodo" ){//=> we are readingTodo
          echo "<p>You are about to proceed with the next action <b>DELETE ".$todo["name"] ."</b>. Are you sure you want to delete this item?</p>";
        } else if( !empty(CollectionLogic::$state) && CollectionLogic::$state === "readCollection" ){//=> we are readingCollection
          echo "<p>You are about to proceed with the next action <b>DELETE " .$collection->get__collection_name(). "</b>. Are you sure you want to delete this item?</p>";
        } else{//=> we are selecting elements
          echo "<p>You are about to proceed with the next action <b>DELETE ELEMENTS</b>. Are you sure you want to delete those elements?</p>";
        }
        ?>
      </div>
      <div class="modal-footer todo__modal-footer">
        <button class="btn todo__btn-modal todo__btn-modal--default" data-dismiss="modal">Cancel</button>
        <?php
        if( !empty(CollectionLogic::get__state()) ){// if we have an $state variable we are on readTODO || readCollection
          echo "<label class=\"btn todo__btn-modal todo__btn-modal--danger\" for = \"delete-todo-submit\">Delete</label>";
        } else{// we are selectingElements
          echo "<button id = \"todo__modal-btn-submit\" class=\"btn todo__btn-modal todo__btn-modal--danger\" data-dismiss=\"modal\">Delete</button";
        }
        ?>
      </div>
    </div>
  </div>
</div>
<form style = "display:none" name = "delete_todo" method = "POST" action = <?php if(CollectionLogic::get__state() === "readTodo"){ echo "todo.php";} else if(CollectionLogic::get__state() === "readCollection"){echo "library.php";}?>>
  <input type = "hidden" value = <?php if( isset($todo) ){echo $id;}else if(isset($collection)){echo $collection->get__collection_id();}else{echo 1;} ?>
    name = <?php if(CollectionLogic::get__state() === "readTodo"){echo "deleteTodo";} else if(CollectionLogic::get__state() === "readCollection"){echo "deleteCollection";} ?> />
  <input type = "submit" id = "delete-todo-submit" />
</form>
