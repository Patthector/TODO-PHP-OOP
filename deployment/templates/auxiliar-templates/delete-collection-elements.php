<form id = "delete-form" action = "library.php" method = "POST" style = "display:none">
<?php
//SUBCATEGORIES
$subcollections = $collection->get__collection_subcollections();
if(!(count($subcollections) == 0)){
  foreach($subcollections as $subcollection){
    echo "<input type = 'checkbox' name = 'subcollection";
    echo    $subcollection["id"];
    echo "' class = \"collection_delete_checker\" id = 'delete-subcollection-";
    echo    $subcollection["id"];
    echo  "' value =";
    echo    $subcollection["id"];
    echo " />";
  }
}
//TODOS
$todosCollection = $collection->get__collection_todos();
if(!(count($todosCollection) == 0)){
  foreach( $todosCollection as $item_todo){
    echo "<input type = 'checkbox' class = \"collection_delete_checker\"  name = 'todo";
    echo    $item_todo["id"];
    echo "' id = 'delete-todo-";
    echo    $item_todo["id"];
    echo "' value =";
    echo    $item_todo["id"];
    echo " />";
  }
}
//<input type = "submit" id = "action-menu_collection" name = "submit"/>

 ?>
  <input type = "hidden" name = "id" value = "<?php echo $id;?>"/>
</form>
