<!--
<div class = "todo__search-bar-container">
  <form action = "./views/mytodos.php" method = "POST" class = "d-flex">
      <div class="input-group-prepend">
        <button class="btn btn-outline-secondary dropdown-toggle todo__btn-search-bar" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Search BY</button>
        <div class="dropdown-menu">
          <a class="dropdown-item" href="#">Collection Name</a>
          <a class="dropdown-item" href="#">Todo Name</a>
          <a class="dropdown-item" href="#">Tag Name</a>
          <div role="separator" class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">All Components</a>
        </div>
      </div>
      <div class="form-group input-group input-group-lg todo__search-bar-input-container">
        <input name = "search-bar--input" id = "search-bar--input" type="text" class="form-control todo__input-search form-control-lg" aria-label="Text input with dropdown button" placeholder="Search by TODO name, Category name or Tag name" />
      </div>
      <div class="input-group-append">
        <input type = "submit" id = "search-bar--submit" name = "search-bar--submit" value = "GO!" class="btn btn-outline-secondary todo__btn-search-bar--inverse" ></input>
     </div>
  </form>
</div>
-->
<div class = "todo__search-bar-container">
  <form action = "../views/search.php" method = "POST" class = "input-group">
      <div class="input-group-prepend">
        <button class="btn btn-outline-secondary dropdown-toggle todo__btn-search-bar" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Search BY</button>

        <div class="dropdown-menu" style = "padding-left:12px">
          <div class="dropdown-item custom-control custom-checkbox">
            <input type="checkbox" id="todo__form-radio--collection-name" name="todo__form-radio--collection-name" class="custom-control-input">
            <label class="custom-control-label" for="todo__form-radio--collection-name">Collection Name</label>
          </div>
          <div class="dropdown-item custom-control custom-checkbox">
            <input type="checkbox" id="todo__form-radio--todo-name" name="todo__form-radio--todo-name" class="custom-control-input">
            <label class="custom-control-label" for="todo__form-radio--todo-name">Todo Name</label>
          </div>
          <div class="dropdown-item custom-control custom-checkbox">
            <input type="checkbox" id="todo__form-radio--tag-name" name="todo__form-radio--tag-name" class="custom-control-input">
            <label class="custom-control-label" for="todo__form-radio--tag-name">Tag Name</label>
          </div>
        </div>

      </div>
      <input name = "search-bar--input" id = "search-bar--input" type="text" class="form-control todo__input-search form-control-lg" aria-label="Text input with dropdown button" placeholder="Search by TODO name, Category name or Tag name" />
      <div class="input-group-append">
        <input type = "submit" id = "search-bar--submit" name = "search-bar--submit" value = "GO!" class="btn btn-outline-secondary todo__btn-search-bar--inverse" ></input>
     </div>
  </form>
</div>
