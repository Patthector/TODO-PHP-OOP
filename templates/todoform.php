<!-- TODO FORM TEMPLATE -->
<div class = "todo__form">
	<div class = "jumbotron_container row">
		<h1 class = "col-12 col-md-6"><?php if( !empty( TodoLogic::get__page_heading() )){ echo TodoLogic::get__page_heading();}?></h1>
		<div class = "col-12 col-md-6 guidelines_container">
			<ul>
				<li>Include levels of importance to prioritaze your tasks</li>
				<li>Give a meaningful description for a later view</li>
				<li>Attach into a category with releated topics</li>
				<li>Add some <b>#tags</b> for and easier search</li>
			</ul>
		</div>
	</div>
<div class = "row justify-content-center">
	<div class = "todo_container col-11 col-md-8">
		<form id = "todo_todo-form" action = "todo.php" method = "post" class = "">
			<span class = "form-subheading">General Information</span>
			<div class = "row todo__form-separator">
				<div class = "col-12 col-md-9">
					<label for = "todo_name">Title <span id = "todo__todo-form--chars-name">[Characters availability: <span>50]</span></span></label>
					<input type = "text" name = "name" id = "todo_name" class = "form-control todo__input-form" placeholder="Give a name to your TODO"
					<?php
					if( isset( $todo ) && !empty( $todo->get__todo_name() )){
						echo "value='" . $todo->get__todo_name() ."'";
					}
					?>
					required/>
				 </div>
				<div class = "col-12 col-md-3">
					<label for = "level_of_importance">Levels</label>
					<select name = "level" id = "level_of_importance" class = "form-control custom-select custom-select-m todo__input-form">
						<option value = "1">Level 1</option>
						<?php
						foreach(array(2,3,4,5) as $i){
							if( isset( $todo ) && !empty( $todo->get__todo_level() ) && $i == $todo->get__todo_level() ){//SELECTED
								echo "<option value = $i selected>Level $i</option>";
							} else{
								echo "<option value = $i >";
								echo "Level $i</option>";
							}
						}
						?>
					</select>
				</div>
			</div>
			<div class = "row todo__form-separator">
				<div class = "col-12">
					<label for = "todo_description">Description <span id = "todo__todo-form--chars-description">[Characters availability: <span>500</span>]</span></label>
					<textarea name = "description" id = "todo_description" class = "form-control todo__input-form" placeholder = "Type a short description [optional]"><?php if( isset( $todo ) && !empty( $todo->get__todo_description() )) echo trim( $todo->get__todo_description() );?></textarea>
				</div>
			</div>
			<span class = "form-subheading">Additional Information</span>
			<div class = "row todo__form-separator">
				<div class = "col-12 col-md-8">
					<div class = "row">
						<div class = "col-12 col-md-6">
							<label for = "todo_library">Library</label>
							<select id = "todo_library" name = "library" class="form-control custom-select custom-select-m todo__input-form">
								<?php
							//	if(!isset($collection)){$collection = "Unknow";}
							$collections = CollectionLogic::get__full_list_collections( $_SESSION["user_id"] );
								foreach($collections as $item){
									$item_collection = new CollectionLogic( $item["id"] );
									if( isset( $todo ) && $todo->get__todo_father_id() === $item_collection->get__collection_id() ){
										echo "<option value='" . $todo->get__todo_father_id() . "' selected>" . $item_collection->get__collection_name() . "</option>";
									} else{
										echo "<option value='" . $item_collection->get__collection_id() . "'>" . $item_collection->get__collection_name() . "</option>";
									}
								}
								?>
							</select>
						</div>
						<div class = "col-10 col-md-5 todo__form-main-category-message todo-message">
							<p>Add your TODOs into a Category that shares related topics.</p><span>Want to create a <b><a href = "./library.php">Library</a></b> instead.</span>
						</div>
					</div>
				</div>

					<div class = "col-12 col-md-4">
						<label id = "label-tag" for = todo__input-tags>Tags</label>
						<div id = "todo__tags-container" class = "todo__tags-container">
							<div class = "container-tag-buttons top-center-absolute">
								<button id = "todo__tag-remove" class = "btn todo__btn-sm todo__btn-outline-tomato disable">Remove</button>
								<button id = "todo__tag-remove-all" class = "btn todo__btn-sm todo__btn-tomato">Remove All</button>
							</div>
							<ul id = "todo__tag-list">
								<?php
								if( isset( $todo ) && $todo->get__todo_tags() ){
									$tags = $todo->get__todo_tags();

									foreach($tags as $tag_name){
										echo "<li class = \"todo__tag-item\">#". $tag_name ."</li>";
									}
								}
								?>
							</ul>
						</div>
						<div class = "form-group todo__tags-input">
							<input id = "todo__input-tag" class = "form-control todo__input-form" type = "text" placeholder="#newtag" data-toggle="popover" data-title = "Invalid tag"/>
							<button id = "todo__add-tag" class = "btn btn-sm todo__btn-tag todo__btn-tag--add">Add</button>
							<div class="invalid-feedback">
		            Invalid tag
		          </div>
						</div>
						<textarea style = "display:none;" type = "hidden" name = "tags" id = "todo_todo-tags-textarea"></textarea>
				</div>
			</div>
			<div class = "row todo__form-separator todo__form-container-buttons">
				<div class = "col-6 left">
					<a class = "btn todo__btn-form todo__btn-form--dark" href = "
						<?php
						if( isset( $todo ) && !empty( TodoLogic::get__state() ) && TodoLogic::get__state() == "editTodo" ){
							echo "todo.php?id=$id";
						 } else{
							 echo "mytodos.php?pg=1";
						 }
					 ?>
					 ">Cancel</a>
				</div>
				<div class = "col-6">
					<?php if( isset( $todo ) && !empty( TodoLogic::get__state() ) && TodoLogic::get__state() == "editTodo" ){
								echo "<input type = \"hidden\" name = \"edit_todo\" value = $id />";
						} else{
									echo "<input type = \"hidden\" name = \"create_todo\" value = \"create_todo\" />";
						}
					?>
					<input class = "btn todo__btn-form todo__btn-form--blue" id = "todo__todoform-submit" type = "submit" value = "DONE" />
				</div>
			</div>
		</form>
	</div>
</div>
</div>
