
<div class = "todo__general-container first-container col-12 col-md-8">
  <div class = "todo__collection-header">
    <div class = "todo__collection-header-path top-right-absolute">
      <ul id = "path-carousel" class = "carousel todo__collection-header-path-list">
        <div class = "todo__inner--carousel">
      <?php
        $pathCollection = $collection->get__collection_path();

        for( $i = 0; $i < count($pathCollection); $i++ ){

          if( $pathCollection[$i]["name"] == $collection->get__collection_name() ){

            echo "<li class=\"slide todo__collection-header-path-item todo__collection-header-path-item--selected\">";
            echo  $excerpt->excerpt( $collection->get__collection_name(), $excerpt->get__collection_path() );
            echo "<span>";
            include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/inc/grip-lines-vertical-solid.svg";
            echo "</span>";
            echo "</li>";
          }
          else{
            echo "<li class=\"slide todo__collection-header-path-item\">";
            echo "<a href = ./library.php?id=" . $pathCollection[$i]["id"] . " >";
            echo $excerpt->excerpt( $pathCollection[$i]["name"], $excerpt->get__collection_path() ) . "</a>";
            echo "<span>";
            include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/inc/grip-lines-vertical-solid.svg";
            echo "</span>";
            echo "</li>";

          }
        }
        echo "<li class=\"slide todo__collection-header-path-item\"><a href =' ./mytodos.php?pg=1' >myTodos</a></li>";
      ?>
        </div>
      </ul>
      <div class="arrow arrow-left arrow--path"><?php include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/inc/arrow-left-solid.svg"; ?></div>
      <div class="arrow arrow-right arrow--path"><?php include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/inc/arrow-right-solid.svg"; ?></div>
    </div>
    <div>
      <h2 id = <?php echo $collection->get__collection_id(); ?> class = "todo__collection-header-title"><?php echo $collection->get__collection_name(); ?></h2>
    </div>
    <div>
      <p class = "todo__collection-header-description"><?php if( !empty($collection->get__collection_description())){echo $collection->get__collection_description();} ?></p>
    </div>
  </div>

  <div class = "todo__collection-body">
    <?php //SUBCATEGORIES ?>
    <div class = "todo__collection-body-category">
      <h3 class = "todo__collection-body--heading">
        Subcategory(s)
      </h3>
      <ul id = "subcollection-carousel" class = "todo__collection-body-subcategory-list carousel">
        <div class = "todo__inner--carousel">
          <?php
          //if there are not subcategories echo a message that explain that and
          //display a link to create new collections/categories/libraries
          $subcollections = $collection->get__collection_subcollections();
          if(count($subcollections) == 0){
            echo "<li style = \"margin:auto\">There are not subcategories available. Do you want to create a <a href = \"../views/library.php?id_collection=$id\"><b>new subcategory?</b></a></li>";
          } else{
            foreach($subcollections as $subcollection){
              if( !empty($collection->get__select_elements()) && $collection->get__select_elements()){
                //"$delete_elements_on" is a variable that will be set to true via AJAx request to indicate the ACTION
                //delete elements has been selected
                //=>
                //we will show the checkbox element next to the name of the subcategories  ******
                echo "<li class = \"slide\">
                        <label class=\"checkbox-container checkbox-container--subcollection\" for = 'delete-subcollection-" . $subcollection["id"] ."'>
                        <span class=\"checkmark\"></span>
                            ". $excerpt->excerpt( $subcollection["name"], $excerpt->get__collection_subcollection() ) ."
                        </label>
                      </li>";
              } else{
                echo "<li class = \"slide\"><a class = \"todo__collection-body-subcategory-list-item\" href = \"./library.php?id=" . $subcollection["id"] . "\">
                ". $excerpt->excerpt( $subcollection["name"], $excerpt->get__collection_subcollection() ) ."</a></li>";
              }
            }
          }
          ?>
        </div>
      </ul>
      <div class="arrow arrow-left arrow--subcategory"><?php include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/inc/arrow-left-solid.svg"; ?></div>
      <div class="arrow arrow-right arrow--subcategory"><?php include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/inc/arrow-right-solid.svg"; ?></div>
    </div>
    <?php //TODOS ?>
    <div class = "todo__collection-body-todo">
      <h3 class = "todo__collection-body--heading">Todo(s)</h3>
      <?php
      $todosCollection = $collection->get__collection_todos();
      if(count($todosCollection) == 0){
        echo "<p style = \"text-align:center\">There are not todos available. Do you want to create a <a href = \"../views/todo.php?id_collection=$id\"><b>new todo?</b></a></p>";
      } else{
        foreach( $todosCollection as $item){
          $item_todo = new TodoLogic( $item["id"], $_SESSION[ "user_id" ] );
          if( !empty($collection->get__select_elements()) && $collection->get__select_elements()){
            echo "<label class = \" checkbox-container checkbox-container--todo todo__collection-body-todo-container\" for = 'delete-todo-" . $item_todo->get__todo_id() ."'>
                    <span class=\"checkmark checkmark--todo\"></span>
                    <div class = \"todo__todo-title\">
                      <h4 class = \"todo__todo-title-collection\"><span>";
                      include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/inc/levelsOfImportance/12x12/level-".$item_todo->get__todo_level().".svg";
                      ?></span><?php echo ucfirst( $excerpt->excerpt( $item_todo->get__todo_name(), $excerpt->get__collection_todo_name() ) );
            echo      "</h4>
                    </div>
                    <div class = \"todo__todo-description-container\">
                      <p class = \"todo__todo-description\">";
                      if( !empty( $item_todo->get__todo_description()) ){
                        echo $excerpt->excerpt( $item_todo->get__todo_description(), $excerpt->get__collection_todo_description() );
                      }else{
                        echo "There is not data available";
                      }
            echo    "</p>
                    </div></label>";
          } else{
              echo "<div class = \"todo__collection-body-todo-container\">
                      <div class = \"todo__todo-title\">
                        <h4 class = \"todo__todo-title-collection\"><span>";
                        include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/inc/levelsOfImportance/12x12/level-".$item_todo->get__todo_level().".svg";
                        ?></span><a href = "<?php echo "/TODO-PHP-OOP/views/todo.php?id=" . $item_todo->get__todo_id() ?>" title = "<?php echo $item_todo->get__todo_name() ?>"><?php echo ucfirst( $excerpt->excerpt( $item_todo->get__todo_name(), $excerpt->get__collection_todo_name() ) );
              echo      "</a></h4>
                      </div>
                      <div class = \"todo__todo-description-container\">
                        <p class = \"todo__todo-description\">";
                        if( !empty( $item_todo->get__todo_description() )){
                          echo $excerpt->excerpt( $item_todo->get__todo_description(), $excerpt->get__collection_todo_description() );
                        }else{
                          echo "There is not data available";
                        }
              echo    "</p>
                      </div>
                    </div>";
          }
        }
      }
      ?>
    </div>
    <div class = "todo__library-footer">
      <p>Created by <span><?php echo $user->get__username(); ?></span> on <span><?php if( !empty($collection->get__collection_created_date())) echo $collection->get__collection_created_date();?></span><span><?php if( !empty($collection->get__collection_updated_date())) echo "Last update on " .  $collection->get__collection_updated_date();?></span></p>
    </div>
  </div>
</div>
