<?php
  if($state === "readTodo"){
    echo "<div id = \"action-menu\" class = \"todo__action-menu-container\">
            <div class = \"todo__action-menu-container--aux\">
              <ul class = \"todo__action-menu\">
                <li id = \"todo_todo-button-edit\" class = \"todo__btn-todo\">";
                include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP [with JS]/inc/edit-regular.svg";
      echo      "<span>Edit</span></li>
                <li class = \"todo__btn-todo\" data-toggle=\"modal\" data-target=\"#move-todo-modal\">";
                 include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP [with JS]/inc/exchange-alt-solid.svg";
      echo       "<span>Move</span></li>
                <li class = \"todo__btn-todo\" data-toggle=\"modal\" data-target=\"#delete-todo-modal\">";
      echo      include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP [with JS]/inc/trash-alt-solid.svg";
      echo      "<span>Delete</span></li>
              </ul>
            </div>
          </div>";

  } else if($state === "readCollection"){
    /*echo "<div id = \"action-menu\" class = \"todo__action-menu-container\">
            <div class = \"todo__action-menu-container--aux\">
            <a class = \"btn btn-danger todo__btn-clear\">CANCEL</a>
              <ul class = \"todo__action-menu\">

                <li id = \"todo_collection-button-edit\" class = \"border-bottom-left-radius todo__btn-collection\">";
                include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP [with JS]/inc/edit-regular.svg";
    echo      "<span>Edit</span></li>
                <div class = \"dropwdown\">
                  <li id = \"todo_collection-button-move\" class = \"todo__btn-collection\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\" >";
                   include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP [with JS]/inc/exchange-alt-solid.svg";
    echo           "<span>Move</span></li>
                  <div class=\"dropdown-menu\" aria-labelledby=\"todo_collection-button-move\">
                    <button class=\"dropdown-item\" data-toggle=\"modal\" data-target=\"#move-todo-modal\">Move Collection</button>
                    <button id = \"collection-move\" class=\"dropdown-item todo__collection-elements\">Move Elements</button>
                  </div>
                </div>
                <div class = \"dropdown\">
                  <li id = \"todo_collection-button-delete\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\" class = \"border-bottom-right-radius todo__btn-collection\">";
                   include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP [with JS]/inc/trash-alt-solid.svg";
  echo             "<span>Delete</span></li>
                  <div class=\"dropdown-menu\" aria-labelledby=\"todo_collection-button-delete\">
                    <button class=\"dropdown-item\" data-toggle=\"modal\" data-target=\"#delete-todo-modal\">Delete Collection</button>
                    <button id = \"collection-delete\" class=\"dropdown-item todo__collection-elements\">Delete Elements</button>
                  </div>
                </div>
              </ul>
              <button class = \"btn btn-danger todo__btn-clear\">Clear Selection</button>
            </div>
          </div>";
  }*/
?>

    <div id = "action-menu" class = "todo__action-menu-container">
      <div class = "todo__action-menu-container--aux">
        <a id = "todo__btn-menu--cancel" class = "btn todo__btn-cancel">CANCEL</a>
          <ul class = "todo__action-menu">
            <!--EDIT BUTTON-->
            <li id = "todo_collection-button-edit" class = "border-bottom-left-radius todo__btn-collection">
              <?php include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP [with JS]/inc/edit-regular.svg"; ?>
              <span>Edit</span>
            </li>
            <!--MOVE BUTTON-->
            <?php
              //EITHER DROPDOWN OR THE SINGLE-BUTTON
              if( isset($delete_elements_on) && $delete_elements_on ){

              } else{
                echo "<div class = \"dropdown\">
                        <li id = \"todo_collection-button-move\" class = \"todo__btn-collection\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\" >";
                          include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP [with JS]/inc/exchange-alt-solid.svg";
                echo     "<span>Move</span></li>
                        <div class=\"dropdown-menu\" aria-labelledby=\"todo_collection-button-move\">
                          <button class=\"dropdown-item\" data-toggle=\"modal\" data-target=\"#move-todo-modal\">Move Collection</button>
                          <button id = \"collection-move\" class=\"dropdown-item todo__collection-elements\">Move Elements</button>
                        </div>
                      </div>";
              }

              //--DELETE BUTTON--
              //EITHER DROPDOWN OR THE SINGLE-BUTTON
              if( isset($delete_elements_on) && $delete_elements_on ){
                echo "<label id = \"todo_collection-button-delete\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\" class = \"border-bottom-right-radius todo__btn-collection\">";
                         include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP [with JS]/inc/trash-alt-solid.svg";
                echo      "<span>Delete</span>
                      </label>";
              } else{
                echo "<div class = \"dropdown\">
                        <li id = \"todo_collection-button-delete\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\" class = \"border-bottom-right-radius todo__btn-collection\">";
                         include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP [with JS]/inc/trash-alt-solid.svg";
                echo      "<span>Delete</span></li>
                        <div class=\"dropdown-menu\" aria-labelledby=\"todo_collection-button-delete\">
                          <button class=\"dropdown-item\" data-toggle=\"modal\" data-target=\"#delete-todo-modal\">Delete Collection</button>
                          <button id = \"collection-delete\" class=\"dropdown-item todo__collection-elements\">Delete Elements</button>
                        </div>
                      </div>";
              }
            ?>
          </ul>
          <button class = "btn btn-danger todo__btn-clear">Clear Selection</button>
        </div>
      </div>
<?php
}
?>
