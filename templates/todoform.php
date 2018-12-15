<!-- TODO FORM TEMPLATE -->

<div class = "todo__form">
	<?php
	if(!empty($message)){
		echo "<p>" . $message . "</p>";
	}
	?>
	<div class = "jumbotron_container">
		<h1><?php if( !empty( TodoLogic::get__page_heading() )){ echo TodoLogic::get__page_heading();}?></h1>
		<div class = "guidelines_container">
			<ul>
				<li>Include levels of importance to prioritaze your tasks</li>
				<li>Give a meaningful description for a later view</li>
				<li>Attach into a category with releated topics</li>
				<li>Add some <b>#tags</b> for and easier search</li>
			</ul>
		</div>
	</div>

	<div class = "todo_container">
		<form id = "todo_todo-form" action = "todo.php" method = "post">
			<span class = "form-subheading">General Information</span>
			<div class = "row todo__form-separator">
				<div class = "col-9">
					<label for = "todo_name">Title</label>
					<input type = "text" name = "name" id = "todo_name" class = "form-control todo__input-form" placeholder="Default TODO"
					<?php
					if( isset( $todo ) && !empty( $todo->get__todo_name() )){
						echo "value='" . $todo->get__todo_name() ."'";
					}
					?>
					/>
				 </div>
				<div class = "col-3">
					<label for = "level_of_importance">Level of importance</label>
					<select name = "level" id = "level_of_importance" class = "form-control todo__input-form">
						<option value = "">Select level</option>
						<?php
						foreach(array(1,2,3,4,5) as $i){
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
				<div class = "col">
					<label for = "todo_description">Description</label>
					<textarea name = "description" id = "todo_description" class = "form-control todo__input-form" placeholder = "Type a short description [optional]"><?php if( isset( $todo ) && !empty( $todo->get__todo_description() )) echo trim( $todo->get__todo_description() );?></textarea>
				</div>
			</div>
					<span class = "form-subheading">Additional Information</span>
					<div class = "row todo__form-separator">
						<div class = "col-8">
							<div class = "row">
								<div class = "col">
									<label for = "todo_library">Library</label>
									<select id = "todo_library" name = "library" class="form-control todo__input-form">
										<?php
									//	if(!isset($collection)){$collection = "Unknow";}
									$collections = CollectionLogic::get__full_list_collections();
										foreach($collections as $item){
											$item_collection = new CollectionLogic( $item["id"] );
											if( isset( $todo ) && $todo->get__todo_father_id() === $item_collection->get__collection_id() ){
												echo "<option value='" . $todo->get__todo_father_id() . "' selected>" . $todo->get__todo_father_name() . "</option>";
											} else{
												echo "<option value='" . $item_collection->get__collection_id() . "'>" . $item_collection->get__collection_name() . "</option>";
											}
										}
										?>
									</select>
								</div>
									<div class = "col todo__form-main-category-message todo-message">
										<p>Add your TODOs into a Category that shares related topics.</p><span>Want to create a <b><a href = "./library.php">Library</a></b> instead.</span>
									</div>
								</div>
							</div>
							<div class = "col-4">
								<label id = "label-tag" for = todo_tags>Tags</label>
								<div id = "todo__tags-container" class = "todo__tags-container">
									<div class = "container-tag-buttons top-center-absolute">
										<button id = "todo__tag-remove" class = "btn todo__btn-sm todo__btn-outline-tomato disable">Remove</button>
										<button id = "todo__tag-remove-all" class = "btn todo__btn-sm todo__btn-tomato">Remove All</button>
									</div>
									<ul id = "todo__tag-list">
										<?php
										if(isset($tags)){
											foreach($tags as $t){
												echo "<li class = \"todo__tag-item\">#". $t ."</li>";
											}
										}
										?>
									</ul>
								</div>
								<div class = "todo__tags-input">
									<input id = "todo__input-tag" class = "form-control todo__input-form" type = "text" placeholder="#newtag" data-toggle="popover" data-title = "Invalid tag"/>
									<button id = "todo__add-tag" class = "btn btn-sm todo__btn-tag todo__btn-tag--add">Add</button>
								</div>
								<textarea style = "display:none;" type = "hidden" name = "tags" id = "todo_todo-tags-textarea"></textarea>
						</div>
					</div>
			<div class = "row todo__form-separator todo__form-container-buttons">
				<div class = "col left">
					<a class = "btn todo__btn-form todo__btn-form--dark" href = "
						<?php if( isset($state) && $state == "editTodo" ){
										echo "todo.php?id=$id";
									 } else{
										 echo "mytodos.php";
									 }
					 ?>
					 ">Cancel</a>
				</div>
				<div class = "col">
					<?php if(isset($state) && $state == "editTodo"){
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
