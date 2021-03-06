<?php
  if( isset( $todo ) && !empty( $todo::get__state()) && ($todo::get__state() == "readTodo") ){
    $default_collection = $todo->get__todo_father_id();
    echo "<div id = \"action-menu\" class = \"todo__action-menu-container\">
            <div class = \"todo__action-menu-container--aux\">
              <ul class = \"todo__action-menu\">";

    echo      "<div class = \"dropdown\">
                  <li id = \"todo_collection-button-create\" class = \"todo__btn-collection\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\" >";
                    include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/inc/plus-solid.svg";
      echo          "<span>Create</span></li>
                  <div class=\"dropdown-menu\" aria-labelledby=\"todo_collection-button-create\">
                    <button class=\"dropdown-item todo__collection-elements\" onclick = \"createLibraryClicked( $default_collection )\">Create Collection</button>
                    <button class=\"dropdown-item todo__collection-elements\" onclick = \"createTodoClicked( $default_collection )\">Create Todo</button>
                  </div>
              </div>";

    echo            "<li class = \"todo__btn-todo\" data-toggle=\"modal\" data-target=\"#delete-todo-modal\">";
                include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/inc/trash-alt-solid.svg";
      echo      "<span>Delete</span></li>
                <li id = \"todo_todo-button-edit\" class = \"todo__btn-todo\" value = \" " . $todo->get__todo_id() ."\" >";
                include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/inc/edit-regular.svg";
      echo      "<span>Edit</span></li>
                <li class = \"todo__btn-todo\" data-toggle=\"modal\" data-target=\"#move-todo-modal\">";
                 include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/inc/exchange-alt-solid.svg";
      echo       "<span>Move</span></li>
              </ul>
            </div>
          </div>";

  } else{
?>

    <div id = "action-menu" class = "todo__action-menu-container">
      <div class = "todo__action-menu-container--aux">
          <ul id = "todo__action-menu-list" class = "todo__action-menu">
            <?php
            echo "<div class = \"dropdown\">
                    <li id = \"todo_collection-button-create\" class = \"todo__btn-collection\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\" >";
                      include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/inc/plus-solid.svg";
            echo     "<span>Create</span></li>
                    <div class=\"dropdown-menu\" aria-labelledby=\"todo_collection-button-create\">
                      <button class=\"dropdown-item todo__collection-elements\" onclick = \"window.location = 'http://localhost/TODO-PHP-OOP/views/library.php'\">Create Collection</button>
                      <button class=\"dropdown-item todo__collection-elements\" onclick = \"window.location = 'http://localhost/TODO-PHP-OOP/views/todo.php'\">Create Todo</button>
                    </div>
                  </div>";


                  //--DELETE BUTTON--
                  //EITHER DROPDOWN OR THE SINGLE-BUTTON
                  if( isset($collection) && !empty($collection->get__select_elements()) && ($collection->get__select_elements() === true) ){
                    echo "<label id = \"todo_collection-button-delete\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\" class = \" todo__btn-collection\">";
                             include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/inc/trash-alt-solid.svg";
                    echo      "<span>Delete</span>
                          </label>";
                  } else{
                    echo "<div class = \"dropdown\">
                            <li id = \"todo_collection-button-delete\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\" class = \" todo__btn-collection \">";
                             include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/inc/trash-alt-solid.svg";
                    echo      "<span>Delete</span></li>
                            <div class=\"dropdown-menu\" aria-labelledby=\"todo_collection-button-delete\">
                              <button class=\"dropdown-item\" data-toggle=\"modal\" data-target=\"#delete-todo-modal\">Delete Collection</button>
                              <button id = \"collection-delete\" class=\"dropdown-item todo__collection-elements\">Delete Elements</button>
                            </div>
                          </div>";
                  }
            ?>
            <!--EDIT BUTTON-->
            <li id = "todo_collection-button-edit" class = " todo__btn-collection">
              <?php include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/inc/edit-regular.svg"; ?>
              <span>Edit</span>
            </li>
            <!--MOVE BUTTON-->
            <?php
              //EITHER DROPDOWN OR THE SINGLE-BUTTON
              if( isset($collection) && !empty($collection->get__select_elements()) && ($collection->get__select_elements() === true) ){
                echo "<label id = \"todo_collection-button-move\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\" class = \" todo__btn-collection\">";
                         include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/inc/exchange-alt-solid.svg";
                echo      "<span>Move</span>
                      </label>";
              } else{
                echo "<div class = \"dropdown\">
                        <li id = \"todo_collection-button-move\" class = \"todo__btn-collection\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\" >";
                          include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/inc/exchange-alt-solid.svg";
                echo     "<span>Move</span></li>
                        <div class=\"dropdown-menu\" aria-labelledby=\"todo_collection-button-move\">
                          <button class=\"dropdown-item\" data-toggle=\"modal\" data-target=\"#move-todo-modal\">Move Collection</button>
                          <button id = \"collection-move\" class=\"dropdown-item todo__collection-elements\">Move Elements</button>
                        </div>
                      </div>";
              }
            ?>

          </ul>
        </div>
      </div>
<?php
}
?>
