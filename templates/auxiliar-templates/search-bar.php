<div class = "todo__search-bar-container">
  <form id = "todo__search-bar--form" action = "../views/search.php" method = "POST" class = "input-group">
      <div class="input-group-prepend position-relative">
        <!--<button class="btn btn-outline-secondary dropdown-toggle todo__btn-search-bar" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Search BY</button>-->
        <button id = "todo__btn--searchBy" class="btn dropdown-toggle todo__btn-search-bar" type="button">
          <span class = "todo__btn-search-bar--svg"><?php include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/inc/filter-solid.svg";?></span>
          <span class = "todo__btn-search-bar--text">Search BY</span>
       </button>

        <div class="todo__search-by--menu-container" id="searchByMenuContainer">
          <div>
            <?php
            if ( $detect->isMobile() ) {
              echo "<div class = \"todo__search-by--mobile-heading\"><span>Search By</span><hr/></div>";
            }
            ?>
            <div class="custom-control custom-checkbox todo__custom-control">
              <input type="checkbox" id="todo__form-radio--collection-name" name="todo__form-radio--collection-name" class="custom-control-input" checked>
              <label class="custom-control-label" for="todo__form-radio--collection-name">Collection Name</label>
            </div>
            <div class="custom-control custom-checkbox todo__custom-control">
              <input type="checkbox" id="todo__form-radio--todo-name" name="todo__form-radio--todo-name" class="custom-control-input" checked>
              <label class="custom-control-label" for="todo__form-radio--todo-name">Todo Name</label>
            </div>
            <div class="custom-control custom-checkbox todo__custom-control">
              <input type="checkbox" id="todo__form-radio--tag-name" name="todo__form-radio--tag-name" class="custom-control-input" checked>
              <label class="custom-control-label" for="todo__form-radio--tag-name">Tag Name</label>
            </div>
          </div>
        </div>

      </div>

      <input name = "search-bar--input" id = "search-bar--input" type="text" class="form-control todo__input-search form-control-lg" aria-label="Text input with dropdown button" placeholder="Search by TODO name, Category name or Tag name" />
      <input name = "search-bar--submit"  type="hidden" />
      <div class="input-group-append">
        <button type = "submit" id = "search-bar--submit"  class="btn todo__btn-search-bar--inverse" >GO<span>!</span></button>
     </div>
     <div class="invalid-feedback">
       The field cannot be empty.
     </div>
  </form>
</div>
