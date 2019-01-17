
<div id = "todo_single-todo" class = "col-12 col-md-8 todo__general-container first-container">
  <?php
    //.todo__general-container=> is a class that will center the content from top/bottom and left/right
  ?>
  <div class = "todo__todo-body">

    <div class = "top-right-absolute">
      <?php //.top-right-absolute=> is a class that will send the element with and absolute position to the top right.
      ?>
      <div class = "todo__item-category-name">
        <span>Category</span>
        <?php if( isset( $todo ) && !empty( $todo->get__todo_father_id() ) ){
          echo "<a href='";
          echo "/TODO-PHP-OOP/views/library.php?id=" . $todo->get__todo_father_id() . "\"";
          echo "' title = \"";
          echo $todo_collection->get__collection_name();
          echo "\">";
          if( isset( $todo_collection ) ){
            echo $excerpt->excerpt( $todo_collection->get__collection_name(), $excerpt->get__collection_todo_category() );
          }
          echo "</a>";
        }
        ?>
      </div>
    </div>
    <div class = "todo__todo-title">
      <h2 value = <?php if( isset( $todo ) ) echo $todo->get__todo_id(); ?> id = "todo_todo-name"><span><?php
      include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/inc/levelsOfImportance/12x12/level-".$todo->get__todo_level().".svg";
      ?></span><?php if(  isset( $todo ) && !empty( $todo->get__todo_name() ) )echo $todo->get__todo_name(); ?></h2>
    </div>
    <div class = "todo__todo-description-container">
      <p class = "todo__todo-description">
        <?php if( isset( $todo ) && !empty( $todo->get__todo_description() ) ) echo $todo->get__todo_description();
        ?>
      </p>
    </div>
  </div>

  <div class = "todo__library-tags">
    <ul class = "todo__library-tags-list">
      <?php
      if( isset( $todo ) && !empty( $todo->get__todo_tags() ) ){
        $tags = $todo->get__todo_tags();
        foreach($tags as $t){
          echo "<li><a href = \"";
          echo "./search.php?tag=on&query=$t";
          echo "\">#$t</a></li>";
        }
      }
       ?>
    </ul>
  </div>

  <div class = "todo__library-footer">
    <p>Created be <span><?php echo $user->get__username(); ?></span> on <span>
      <?php
      if( isset( $todo ) && !empty( $todo->get__todo_created_date() ) ) echo $todo->get__todo_created_date();?>
    </span>
      <?php if( isset( $todo ) && !empty( $todo->get__todo_updated_date() ) ) echo ". Last update on <span>". $todo->get__todo_updated_date() ."</span>" ?>
  </p>
  </div>
</div>
