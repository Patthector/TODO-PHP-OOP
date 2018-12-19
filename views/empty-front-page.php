<div class = "empty-front-page">
  <h2 class = "empty-front-page--heading">myTODOs</h2>
  <p class = "welcome-message">Hello <?php if(isset($name)) echo $name; ?>. Welcome to <span class = "">Make<i>it</i>Stick.</span> This is temporarily empty. Type what's next on your TODO-List!</p>
  <div class = "container-buttons">
    <div class = "left" id = "todo__createlibrary" onclick = "createLibraryClicked()">
      <h2 class = "button-heading">create library</h2>
      <p>[Create a <span>Library/Category</span> for grouping TODOs that follow a related topic]</p>
    </div>
    <div class = "right" id = "todo__createtodo"  onclick = "createTodoClicked()">
      <h2 class = "button-heading">create todo</h2>
      <p>[Create a <span>todo</span> and describe a particular task that you want to get done]</p>
    </div>
  </div>
</div>
<div class = "container-question">
  <div class = "question-mark-svg"><?php include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/inc/question-mark.svg";?></div>
  <p> If you have any question in how to procede in this application; visit the <a href = "#">help section</a> for more information.</p>
</div>

<script>
function createTodoClicked(){
  window.location = "http://localhost/TODO-PHP-OOP/views/todo.php";

}
function createLibraryClicked(){
  window.location = "http://localhost/TODO-PHP-OOP/views/library.php";
}
</script>
