<?php

// 1-) what had been requested => input-name
// 2-) where had been requested => show the tables selected
// 3-) the results by category/collection [IF that was requested]
// 4-) the results by todos [IF that was requested]
// 5-) the results by tags [IF that was requested]
// 6-) a button sending to mytodos.php

 ?>

 <div class = "container todo__mytodos-search--container">
   <h1 class = "todo__main-heading todo__main-heading--mytodos-search"><?php
   if( isset( $search_name ) ){
     echo "Search result(s) for: <span class =\"\" >$search_name</span>";
   }
    ?></h1>
    <?php

    if( isset( $collection_table ) && $collection_table ){

      echo "<div><h3 class = \"todo__mytodos-search--subheading\">Search result(s) by Collection:</h3>";

      if( !empty( $searchResults["collections"] ) ){
        echo "<ul>";
        foreach( $searchResults["collections"] as $item_collection ){
          echo "<div>
                  <h4 class = \"todo__mytodos-search--subheading-item todo__mytodos-search--result-item\"><a href = \"./library.php?id=" .$item_collection["id"]. "\">" .$item_collection["name"].  "</a></h4>
                  <p>" .$item_collection["description"]. "</p>
                </div>";
        }
      }
      echo "</ul></div>";
      echo "<hr>";
    }
    if( isset( $todo_table ) && $todo_table ){


      echo "<div ><h3 class = \"todo__mytodos-search--subheading\">Search result(s) by Todo:</h3>";

      if( !empty( $searchResults["todos"] ) ){
        echo "<ul>";
        foreach( $searchResults["todos"] as $item_todo ){
//var_dump($searchResults["todos"]);exit;
          echo "<div>
                  <h4 class = \"todo__mytodos-search--subheading-item todo__mytodos-search--result-item\"><a href = \"./todo.php?id=" .$item_todo["id"]. "\">" .$item_todo["name"]. "</a></h4>
                  <p>" .$item_todo["description"]. "</p>
                </div>";
        }
      } else{
        echo "There is nothing to show!";
      }
      echo "</ul></div>";
      echo "<hr>";
    }
    if( isset( $tag_table ) && $tag_table ){

      echo "<div><h3 class = \"todo__mytodos-search--subheading\">Search result(s) by Tag:</h3>";

      if( !empty( $searchResults["tags"] ) ){
        echo "<ul>";
        foreach( $searchResults["tags"] as $item_tag ){
          
          echo "<li class = \"todo__mytodos-search--subheading-item\">#" .$item_tag["name"]. "</li>";
          echo "<ul class = \"todo__mytodos-search--sublist-todo\">";
          foreach( $item_tag["todos"] as $item_todo ){
            echo "<div>
                    <h4 class = \"todo__mytodos-search--result-item\"><a href = './todo.php?id=" .$item_todo["id"]. "'>" .$item_todo["name"]. "</a></h4>
                    <p>" .$item_todo["description"]. "</p>
                  </div>";
          }
          echo "</ul>";
        }
      }
      echo "</ul></div>";
    }

    ?>

 </div>
 <div class = "container todo__mytodos-search--container-buttons">
   <button type = "button" onclick = "./mytodos.php" class = "btn todo__btn-modal todo__btn-modal--default">Search again</button>
   <button type = "button" onclick = "./mytodos.php" class = "btn todo__btn-modal todo__btn-modal--info">Go to myTODOs</button>
 </div>
