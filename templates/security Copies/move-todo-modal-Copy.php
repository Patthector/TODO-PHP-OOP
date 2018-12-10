<!--MOVE MESSAGE -->
<!--Modal-->
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
        <p>Select the Library where you are going to move this item</p>
        <form method = "POST" action =<?php if($state === "readTodo"){ echo "todo.php";} else if($state === "readCollection"){echo "library.php";}?>>
          <div class = "form-group">
              <input type = "hidden" class = "form-control" name = "id" value = <?php if(isset($id)){echo $id;}else {echo 1;} ?>/>
          </div>
          <div class = "form-group">
            <select class = "form-control" name = "collectionSelected" required>
              <option value=''>Select One Library</option>
              <?php
              foreach($collections as $item){
                if( !( $item["id"] === $todo["id_collection"] ) ){
                    echo "<option value='" . $item["id"] . "'>" . $item["name"] . "</option>";
                }
              }
              ?>
            </select>
          </div>
          <input type = "hidden" name = <?php if($state === "readTodo"){ echo "moveTodo";} else if($state === "readCollection"){echo "moveCollection";}?>
                 value = <?php if($state === "readTodo"){ echo "moveTodo";} else if($state === "readCollection" ){echo "moveCollection";}?> />
          <input style = "display:none;" type = "submit" id = "move-todo-submit" />
        </form>
      </div>
      <div class="modal-footer todo__modal-footer">
        <button class="btn todo__btn-modal todo__btn-modal--default" data-dismiss="modal">Cancel</button>
        <label class="btn todo__btn-modal todo__btn-modal--info" for = "move-todo-submit">Move</label>
      </div>
    </div>
  </div>
</div>
