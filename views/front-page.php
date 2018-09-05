<div class = "front-page">
  <div class = "front-page__first-block">
    <div class = "left w-50">
      <h3 class = "front-page__heading-3">Don't let your ideas go away!</h3>
      <ul class = "introduction-list">
        <li><span class = "red-dot"><?php include __DIR__ . "/../inc/levelsOfImportance/6x6/level-4.svg"; ?></span><p>Keep all your tasks organize in a matter that fits your thinking process</p></li>
        <li><span class = "red-dot"><?php include __DIR__ . "/../inc/levelsOfImportance/6x6/level-4.svg"; ?></span><p>Use categories and subcategories to have a better understand of your thoughts</p></li>
        <li><span class = "red-dot"><?php include __DIR__ . "/../inc/levelsOfImportance/6x6/level-4.svg"; ?></span><p>Work in groups by making others part of your ideas</p></li>
      </ul>
    </div>
    <div class = "right w-50">
      <?php include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP [with JS]/inc/todo-wireframe.php"; ?>
    </div>
  </div>

  <div class = "front-page__second-block">
    <div class = "left w-50">
      <h2 class = "front-page__button-library"><a href = "./views/createlibrary.php">create library</a></h2>
      <ul class = "front-page__list-description">
        <li>A <span class = "high-sapphire">library/category</span> is created as a general topic, that will storage<span class = "high-sapphire">tasks/todos</span> related in one way or another.</li>
        <li><span class = "high-sapphire">library/category</span> could have a meaningful description that described the general topic of the <span class = "high-sapphire">library/category</span>.</li>
        <li><span class = "high-sapphire">library/category</span> could also have <span class = "high-sapphire">subcategory(s)</span> linked within to add a deeper level of organization between a general topic and a subtopic.</li>
        <li><span class = "high-sapphire">tags</span> are other way of grouping concepts. They are short but meaningful, and their main objective is described the <span class = "high-sapphire">category/library</span> to be searchable in the future.</li>
      </ul>
    </div>
    <div class = "right w-50">
      <h2 class = "front-page__button-todo"><a href = "./views/createtodo.php">create todo</a></h2>
      <ul class = "front-page__list-description">
        <li>A <span class = "high-sapphire">todo/task</span> is created to list a particular and individual task. All <span class = "high-sapphire">todos</span> must be named and could have a meaningful description</li>
        <li><span class = "high-sapphire">todos</span> could be assign into <span class = "high-sapphire">libraries/categories</span> related with them. If a category is not specified; the default one is Unkown.</li>
        <li><span class = "high-sapphire">todos</span> will have level og importance. From 1 to 5, 1 being the less important and 5 the most. If a level of importance is not specify, level 1 will be the default value.</li>
        <li><span class = "high-sapphire">tags</span> are other way of grouping concepts. They are short but meaningful, and their main objective is decribe <span class = "high-sapphire">todos/tasks</span> to be searchable in the future.</li>
      </ul>
    </div>
  </div>

  <div class = "front-page__third-block">
    <h3 class = "front-page__example-heading">#example</h3>
    <div class = "front-page__example-svg">
      <?php include $_SERVER['DOCUMENT_ROOT'] . "/TODO-PHP-OOP [with JS]/inc/todo-library-example.php"; ?>
    </div>
  </div>
</div>
