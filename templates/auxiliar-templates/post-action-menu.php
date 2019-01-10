<div id = "action-menu" class = "todo__action-menu-container">
  <div class = "todo__action-menu-container--aux">
      <ul id = "todo__action-menu-list" class = "todo__action-menu">
        <!--CANCEL BUTTON-->
        <?php
        echo "<button id = \"todo__btn-menu--cancel\" class = \"todo__btn-collection todo__btn-cancel\">";
              include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/inc/times-solid.svg";
        echo    "<span>CANCEL</span></button>";
        ?>
        <!--CLEAR BUTTON-->
        <?php
        echo "<button id = \"todo__action-menu-btn-clear\" class = \"todo__btn-collection todo__btn-clear\">";
              include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/inc/redo-alt-solid.svg";
        echo    "<span>CLEAR</span></button>";

        if( isset( $selectionForDelete ) && $selectionForDelete ){
          echo "<button id = \"todo__collection-button-delete\" class = \"todo__btn-collection todo__btn-collection--selected\" data-toggle=\"modal\" data-target=\"#delete-todo-modal\">";
          include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/inc/trash-alt-solid.svg";
          echo "<span>delete</span></button>";
        } else if( isset( $selectionForMove ) && $selectionForMove ){
          echo "<button id = \"todo__collection-button-move\" class = \"todo__btn-collection todo__btn-collection--selected\" data-toggle=\"modal\" data-target=\"#move-todo-modal\">";
          include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/inc/exchange-alt-solid.svg";
          echo "<span>move</span></button>";
        }
        ?>
      </ul>
    </div>
  </div>
