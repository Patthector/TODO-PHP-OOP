<!-- TODO FORM TEMPLATE -->

<div class = "container">
	<?php 
	if(!empty($message)){
		echo "<p>" . $message . "</p>";
	}
	?>
	<div class = "jumbotron_container">
		<h1>Create Library</h1>
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
		<form action = "createlibrary.php" method = "post">
			<span>General Information</span>
			<label for = "collection_name">Title</label>
			<input type = "text" name = "name" id = "collection_name"
			<?php 
			if(!empty($name)){
				echo "value='" . $name ."'";
			}
			?>
			 required/>

			<label for = "collection_description">Description</label>
			<textarea name = "description" id = "collection_description"><?php echo $description;?></textarea>

			<span>Additional Information</span>
			<label for = "collection_library">Library</label>
			<select id = "collection_library" name = "collection">
				<?php 
				foreach($collections as $c){
					echo "<option value='" . $c["id"] . "'>" . $c["name"] . "</option>";
				}
				?>
			</select>
			<div class = "">
				<p>This is the Category helper</p>
				<a href = "./views/createlibrary.php">+Create Library</a>
			</div>

			<a href = "./views/mytodos.php">Cancel</a>
			<input type = "submit" value = "DONE" />

		</form>
	</div>

</div>