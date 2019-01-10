<div class = "todo__container-level-bar">
  <div class = "todo__container-level-bar--header">
    <h3 class = "todo__container-level-bar--header--heading">Levels of Importance</h3>
  </div>
  <div class = "todo__container-level-bar--body">
    <ul>
      <?php
        for($i = 1; $i <= 5; $i++){
          echo "<li><span>";
          include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/inc/levelsOfImportance/12x12/level-".$i.".svg";
          echo "</span>level $i</li>";
        }
      ?>
    </ul>
  </div>
</div>
