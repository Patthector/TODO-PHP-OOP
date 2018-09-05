<!-- TODO FORM TEMPLATE -->

<div class = "todo__form">
	<?php
	if(!empty($message)){
		echo "<p>" . $message . "</p>";
	}
	?>
	<div class = "jumbotron_container">
		<h1>Create Library</h1>
		<div class = "guidelines_container">
			<ul>
				<li>Give a meaningful descripiton for a later view</li>
				<li>Attach into a library/category that shares topics to add deeper levels of organization (subcategory)</li>
				<li>Add some <b>#tags</b> for an easier search</li>
			</ul>
		</div>
	</div>

	<div class = "todo_container">
		<form action = "library.php" method = "POST">
			<span class = "form-subheading">General Information</span>
			<div class = "row todo__form-separator">
				<div class = "col">
					<label for = "collection_name">Title</label>
					<input type = "text" name = "name" id = "collection_name" class="form-control todo__input-form" placeholder="Default LIBRARY"
			<?php
			if(!empty($name)){
				echo "value='" . $name ."'";
			}
			?>
			 />
		 </div>
	 </div>
	 <div class = "row todo__form-separator">
		 <div class = "col">
			<label for = "collection_description">Description</label>
			<textarea name = "description" id = "collection_description" class="form-control todo__input-form"><?php if(isset($description)) echo $description;?></textarea>
		</div>
	</div>
			<span class = "form-subheading">Additional Information</span>
			<div class = "row todo__form-separator">
				<div class = "col-12 offset-1">
					<div class = "row">
						<div class = "col-4">
							<label for = "collection_library">Library</label>
							<select id = "collection_library" name = "collection" class="form-control todo__input-form">
								<option value = "">Main Library</option>
								<?php
								if(isset($fatherCollection)){
									foreach($collections as $c){
										if($fatherCollection === $c["id"]){
												echo "<option value='" . $c["id"] . "' selected>" . $c["name"] . "</option>";
										} else{
											echo "<option value='" . $c["id"] . "'>" . $c["name"] . "</option>";
										}
									}
								} else{
									foreach($collections as $c){
										echo "<option value='" . $c["id"] . "'>" . $c["name"] . "</option>";
									}
								}
								?>
							</select>
					</div>
					<div class = "col-7 todo__form-main-category-message todo-message">
						<p>If you want to convert this library in a subcollection; select the Main Library/Father Library.</p><span>Want to create a <b><a href = "./todo.php">TODO</a></b> instead.</span>
					</div>
				</div>
			</div>
			</div>
			<div class = "row todo__form-separator todo__form-container-buttons">
				<div class = "col left">
					<a class = "btn todo__btn-form todo__btn-form--dark" href = "./views/mytodos.php">Cancel</a>
				</div>
				<div class = "col">
					<input type = "hidden" value = "createCollection" name = "action" />
					<input class = "btn todo__btn-form todo__btn-form--blue" type = "submit" value = "DONE" />
				</div>
			</div>
		</form>
	</div>
</div>
