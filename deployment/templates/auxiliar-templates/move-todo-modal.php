<!--********************MOVE MODAL************************-->

<div class="modal todo__modal " id="move-todo-modal" tabindex="-1" role="dialog" aria-labelledby="todo__modal-move" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header todo__modal-info">
        <h4 class="modal-title " id="todo__modal-move">Access Permission</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div><!--end-modal-header-->

      <div class="modal-body todo__modal-body">
        <?php
        if( isset( $todo ) && !empty(TodoLogic::get__state()) && ( TodoLogic::get__state() === "readTodo" )){
          //READING TODO
          echo '<p>Select the Library where you are going to move the next TODO: <span>' .$todo->get__todo_name(). '</span>.</p>';
        }
        else if( isset( $collection ) && !empty(CollectionLogic::get__state()) && CollectionLogic::get__state() === "readCollection" ){//READING COLLECTION
          echo '<p>Select the Library where you are going to move this Category: <span>' .$collection->get__collection_name(). '</span>.</p>';
        }
        else{//SELECTING ELEMENTS
          echo '<p>Select the Library where you are going to move those elements.</p>';
        }
        ?>
        <form method = "POST" action =<?php if( isset( $todo ) && !empty(TodoLogic::get__state()) && TodoLogic::get__state() === "readTodo" ){ echo "todo.php";} else {echo "library.php";}?>>
          <div class = "form-group">
              <input type = "hidden" class = "form-control" name = "id" value =
              <?php if( isset($todo) )
              {
                echo $todo->get__todo_id();
              }
              else if(isset($collection)){
                echo $collection->get__collection_id();
              }
              else{
                echo 1;
              } ?>/>
          </div><!--end-form-group-->

          <div class = "form-group">
            <label for = "todo__modal-move-select">Select Library</label>
            <select id = "todo__modal-move-select" class = "form-control custom-select custom-select-lg" name = "collectionSelected" required>
              <!--<option value='1'>Root</option>-->
              <?php

              $collections = CollectionLogic::get__full_list_collections( $user->get__userId() );

              foreach($collections as $item){

                $item_collection = new CollectionLogic( $item["id"] );
                if( isset( $todo ) ){//=> we are on readTODO
                  if( !( $item_collection->get__collection_id() === $todo->get__todo_father_id() ) ){
                      echo "<option value='" . $item_collection->get__collection_id() . "'>" . $item_collection->get__collection_name() . "</option>";
                  }
                }else{//=> we are on readCollection
                  if( !( $item_collection->get__collection_id() === $collection->get__collection_id() ) && !( $item_collection->get__collection_id() === $collection->get__collection_father_id()) ){
                      echo "<option value='" . $item_collection->get__collection_id() . "'>" . $item_collection->get__collection_name() . "</option>";
                  }
                }
              }
              ?>
            </select>
          </div><!--end-form-group-->

          <input type = "hidden" name =
          <?php
          if( isset( $todo ) && !empty( TodoLogic::get__state() ) && TodoLogic::get__state() === "readTodo"){ echo "'moveTodo' value = 'moveTodo'";}
          else if( isset( $collection ) && !empty( CollectionLogic::get__state() ) ){echo "'moveCollection' value = 'moveCollection'";}?>         />
          <input style = "display:none;" type = "submit" id = "move-todo-submit" />
        </form>
      </div><!--end-modal-body-->

      <div class="modal-footer todo__modal-footer">
        <button class="btn todo__btn-modal todo__btn-modal--default" data-dismiss="modal">Cancel</button>
        <?php
          if( ( isset( $todo ) && !empty( TodoLogic::get__state() ) ) || ( isset( $collection ) && !empty( CollectionLogic::get__state() ) ) ){// if we have an $state variable we are on readTODO || readCollection
            echo "<label class=\"btn todo__btn-modal todo__btn-modal--info\" for = \"move-todo-submit\">Move</label>";
          }else{// we are selectingElements
            //echo "<button id = \"todo__modal-btn-submit\" class=\"btn todo__btn-modal todo__btn-modal--info\" data-dismiss=\"modal\">Move</button>";
            echo "<button type = \"button\" id = \"todo__move-modal-btn-submit\" class=\"btn todo__btn-modal todo__btn-modal--info\" data-dismiss=\"modal\">Move</button>";
          }
         ?>
      </div><!--end-modal-footer-->
    </div><!--end-modal-content-->
  </div><!--end-modal-dialog-->
</div><!--modal-->


<!--**********************DELETE MODAL*********************

<div class="modal todo__modal" id="delete-todo-modal" tabindex="-1" role="dialog" aria-labelledby="todo__modal-delete" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header todo__modal-danger">
        <h4 class="modal-title" id="todo__modal-delete">Access Permission</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body todo__modal-body">
        <?php
        if( !empty(TodoLogic::get__state()) && TodoLogic::get__state() === "readTodo" ){//=> we are readingTodo
          echo "<p>You are about to proceed with the next action: <span>DELETE ".$todo->get__todo_name() ."</span>.<br/> Are you sure you want to delete this item?</p>";
        } else if( !empty(CollectionLogic::get__state()) && CollectionLogic::get__state() === "readCollection" ){//=> we are readingCollection
          echo "<p>You are about to proceed with the next action <span>DELETE " .$collection->get__collection_name(). "</span>. Are you sure you want to delete this item?</p>";
        } else{//=> we are selecting elements
          echo "<p>You are about to proceed with the next action <b>DELETE ELEMENTS</b>. Are you sure you want to delete those elements?</p>";
        }
        ?>
      </div>
      <div class="modal-footer todo__modal-footer">
        <button class="btn todo__btn-modal todo__btn-modal--default" data-dismiss="modal">No, cancel</button>
        <?php
        if( !empty( TodoLogic::get__state() ) || !empty( CollectionLogic::get__state() ) ){// if we have an $state variable we are on readTODO || readCollection
          echo "<label class=\"btn todo__btn-modal todo__btn-modal--danger\" for = \"delete-todo-submit\">Yes, delete</label>";
        } else{// we are selectingElements
          //echo "<button id = \"todo__modal-btn-submit\" class=\"btn todo__btn-modal todo__btn-modal--danger\" data-dismiss=\"modal\">Yes, delete</button";
          echo "<button id = \"todo__delete-modal-btn-submit\" class=\"btn todo__btn-modal todo__btn-modal--danger\" data-dismiss=\"modal\">Yes, delete</button";
        }
        ?>
      </div>
    </div>
  </div>
</div>
<form style = "display:none" name = "delete_todo" method = "POST" action = <?php if(TodoLogic::get__state() === "readTodo"){ echo "todo.php";} else if(CollectionLogic::get__state() === "readCollection"){echo "library.php";}?>>
  <input type = "hidden" value = <?php if( isset($todo) ){echo $todo->get__todo_id();}else if(isset($collection)){echo $collection->get__collection_id();}else{echo 1;} ?>
    name = <?php if(TodoLogic::get__state() === "readTodo"){echo "deleteTodo";} else if(CollectionLogic::get__state() === "readCollection"){echo "deleteCollection";} ?> />
  <input type = "submit" id = "delete-todo-submit" />
</form>-->
