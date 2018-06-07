<!-- TODO FORM TEMPLATE -->

<div class = "container">
	<?php 
	if(!empty($message)){
		echo "<p>" . $message . "</p>";
	}
	?>
	<div class = "jumbotron_container">
		<h1>Create Todo</h1>
		<div class = "guidelines_container">
			<ul>
				<li>This is the guideline number-1</li>
				<li>This is the guideline number-2</li>
				<li>This is the guideline number-3</li>
				<li>This is the guideline number-4</li>
			</ul>
		</div>
	</div>

	<div class = "todo_contaienr">
		<form action = "createtodo.php" method = "post">
			<span>General Information</span>
			<label for = "todo_name">Title</label>
			<input type = "text" name = "name" id = "todo_name"
			<?php 
			if(!empty($name)){
				echo "value='" . $name ."'";
			}
			?>
			 required/>

			<label for = "level_of_importance">Level of importance</label>
			<select name = "level" id = "level_of_importance">
				<?php 
				foreach(array(1,2,3,4,5) as $i){
					if(!empty($level) && $i == $level){
						echo "<option value = $i selected>Level $i</option>";
					} else{
						echo "<option value = $i>Level $i</option>";
					}
				}
				?>
			</select>

			<label for = "todo_description">Description</label>
			<textarea name = "description" id = "todo_description"><?php echo $description;?></textarea>

			<span>Additional Information</span>
			<label for = "todo_library">Library</label>
			<select id = "todo_library" name = "library">
				<?php 
				foreach($libraries as $lib){
					echo "<option value='" . $lib["id"] . "'>" . $lib["name"] . "</option>";
				}
				?>
			</select>
			<div class = "">
				<p>This is the Category helper</p>
				<a href = "./views/createlibrary.php">+Create Library</a>
			</div>

			<label for = todo_tags>Tags</label>
			<textarea name = "tags" id = "todo_tags"><?php echo $tags; ?></textarea>

			<a href = "./mytodos.php">Cancel</a>
			<input type = "submit" value = "DONE" />

		</form>
	</div>

</div>