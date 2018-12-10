
<main>
	<!-- MESSAGE-STATUS -->
	<?php include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/message.php"; ?>
	<div class = "full-container">
		<h2 class = "todo__main-heading">myTODOs</h2>
		<?php
		foreach($libraries as $collection){
			?>
			<div class = "todo__general-container first-container">
				<div class = "todo__collection-header">
					<div class = "todo__collection-header-path top-right-absolute">
			      <ul class = "todo__collection-header-path-list">
			      <?php
			        $pathCollection = $collection["path"];
			        for( $i = ( count($pathCollection) - 1); $i >=0; $i-- ){
			          if( $pathCollection[$i]["name"] == $collection["name"]){
			            echo "<li class=\"todo__collection-header-path-item todo__collection-header-path-item--selected\">" . $pathCollection[$i]["name"] . "</li>";
			          } else{
			              echo "<li class=\"todo__collection-header-path-item\"><a href = ./library.php?id=" . $pathCollection[$i]["id"] . " >" . $pathCollection[$i]["name"] . "</a></li>";
			          }
			          if($i != 0){
			            echo "<li class=\"todo__collection-header-path-item \">//<span>";
			          }
			        }
				      ?>
				      </ul>
				    </div>
					<div>
						<h2 id = <?php echo $collection["id"]; ?> class = "todo__collection-header-title">
							<a class = "todo__collection-header-title--link" href = "<?php echo '/TODO-PHP-OOP/views/library.php?id=' . $collection["id"] ?> "> <?php echo $collection["name"]; ?>
							</a>
						</h2>
					</div>
					<div>
						<p class = "todo__collection-header-description"><?php if(isset($collection["description"])){echo $collection["description"];} ?></p>
					</div>
				</div>
					<div class = "todo__collection-body">
						<?php //SUBCATEGORIES ?>
						<div class = "todo__collection-body-category">
							<h3 class = "todo__collection-body--heading">
								Subcategory(s)
							</h3>
							<ul class = "todo__collection-body-subcategory-list">
								<?php
								//if there are not subcategories echo a message that explain that and
								//display a link to create new collections/categories/libraries
								$subcollections = $collection["subcollections"];
								if(count($subcollections) == 0){
									echo "<li style = \"margin:auto\">There are not subcategories available. Do you want to create a <a href = \"../views/library.php?coll=$collection[id]\"><b>new subcategory?</b></a></li>";
								} else{
									foreach($subcollections as $subcollection){
										if(isset($delete_elements_on) && $delete_elements_on){
											//"$delete_elements_on" is a variable that will be set to true via AJAx request to indicate the ACTION
											//delete elements has been selected
											//=>
											//we will show the checkbox element next to the name of the subcategories
											echo "<li>
															<label class=\"checkbox-container\" for = 'delete-subcollection-" . $subcollection["id"] ."'>
																<span class=\"checkmark\"></span>
																	". $subcollection["name"] ."
															</label>
														</li>";
										} else{
											echo "<li><a class = \"todo__collection-body-subcategory-list-item\" href = \"./library.php?id=" . $subcollection["id"] . "\">
											". $subcollection["name"] ."</a></li>";
										}
									}
								}
								?>
						</div>
						<?php //TODOS ?>
						<div class = "todo__collection-body-todo">
							<h3 class = "todo__collection-body--heading">Todo(s)</h3>
							<?php
							$todosCollection = $collection["todos"];
							if(count($todosCollection) == 0){
								echo "<p style = \"text-align:center\">There are not todos available. Do you want to create a <a href = \"../views/todo.php\"><b>new todo?</b></a></p>";
							} else{
								foreach( $todosCollection as $todo){
									if(isset($delete_elements_on) && $delete_elements_on){
										echo "<label class = \"todo__collection-body-todo-container checkbox-container\" for = 'delete-todo-" . $todo["id"] ."'>
														<span class=\"checkmark\"></span>
														<div class = \"todo__todo-title\">
															<h4 class = \"todo__todo-title-collection\"><span>";
															include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/inc/levelsOfImportance/12x12/level-".$todo["level"].".svg";
															?></span><?php if(isset($todo["name"]))echo ucfirst($todo["name"]);
										echo      "</h4>
														</div>
														<div class = \"todo__todo-description-container\">
															<p class = \"todo__todo-description\">";
															if(isset($todo["description"])){
																echo $todo["description"];
															}
										echo    "</p>
														</div>
													</label>";
									} else{
											echo "<div class = \"todo__collection-body-todo-container\">
															<div class = \"todo__todo-title\">
																<h4 class = \"todo__todo-title-collection\"><span>";
																include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/inc/levelsOfImportance/12x12/level-".$todo["level"].".svg";
																?></span><a href = "<?php echo "/TODO-PHP-OOP/views/todo.php?id=" . $todo["id"] ?>"><?php if(isset($todo["name"]))echo ucfirst($todo["name"]);
											echo      "</a></h4>
															</div>
															<div class = \"todo__todo-description-container\">
																<p class = \"todo__todo-description\">";
																if(isset($todo["description"])){
																	echo $todo["description"];
																}
											echo    "</p>
															</div>
														</div>";
									}
								}
							}
							?>
						</div>
					<div class = "todo__library-footer">
						<p>Created be <span>@username</span> on <span><?php if(isset($collection["created_date"])) echo $collection["created_date"];?></span>. Last update on <span><?php if(isset($collection["created_date"])) echo $collection["updated_date"];?></span></p>
					</div>
				</div>
			</div>
<?php
		}
?>
</div>
