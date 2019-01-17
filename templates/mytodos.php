
<main class = "">

	<div class = "full-container">
		<h2 class = "todo__main-heading">myTODOs</h2>
		<?php
		foreach($libraries as $item_id){
			$item_collection = new CollectionLogic( $item_id["id"], true );//REMEMBER TO CHANGE THIS TO $ITEM_ID
			?>
			<div class = "todo__general-container first-container col-12 col-md-10 col-lg-8">
				<div class = "todo__collection-header">
					<div class = "todo__collection-header-path top-right-absolute">
			      <ul class = "todo__collection-header-path-list carousel">
							<div class = "todo__inner--carousel">
			      <?php
								$pathCollection = $item_collection->get__collection_path();
								for( $i = 0; $i < count($pathCollection); $i++ ){

									if( $pathCollection[$i]["name"] == $item_collection->get__collection_name() ){

										echo "<li class=\"slide todo__collection-header-path-item todo__collection-header-path-item--selected\"><span>";
										include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/inc/grip-lines-vertical-solid.svg";
										echo "</span>";
										echo  $excerpt->excerpt( $item_collection->get__collection_name(), $excerpt->get__collection_path() );
										echo "</li>";
									}
									else{

											echo "<li class=\"slide todo__collection-header-path-item\"><span>";
											include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/inc/grip-lines-vertical-solid.svg";
											echo "</span><a href = ./library.php?id=" . $pathCollection[$i]["id"] . " >";
											echo $excerpt->excerpt( $pathCollection[$i]["name"], $excerpt->get__collection_path() ) . "</a></li>";
									}
								}
				      ?>
								</div>
				      </ul>
				    </div>
					<div>
						<h2 id = <?php echo $item_collection->get__collection_id(); ?> class = "todo__collection-header-title">
							<a class = "todo__collection-header-title--link" href = "<?php echo '/TODO-PHP-OOP/views/library.php?id=' . $item_collection->get__collection_id() ?> "> <?php echo $excerpt->excerpt( $item_collection->get__collection_name(), $excerpt->get__collection_name() ); ?>
							</a>
						</h2>
					</div>
					<div>
						<p class = "todo__collection-header-description"><?php if( !empty( $item_collection->get__collection_description() ) ){echo $excerpt->excerpt( $item_collection->get__collection_description(), $excerpt->get__collection_description() ); } ?></p>
					</div>
				</div>
					<div class = "todo__collection-body">
						<?php //SUBCATEGORIES ?>
						<div class = "todo__collection-body-category">
							<h3 class = "todo__collection-body--heading">
								Subcategory(s)
								<?php
								$subcollections = $item_collection->get__collection_subcollections();
								 if(count($subcollections) !== 0){
									echo "<a class = \"slide todo__subcollection--viewmore\" href = '" . "/TODO-PHP-OOP/views/library.php?id=" . $item_collection->get__collection_id() . "'>View More</a>";
								}
								?>
							</h3>
							<ul class = "todo__collection-body-subcategory-list todo__mytodos--subcollection-list carousel">
								<div class = "todo__inner--carousel">
								<?php
								//adding View More BUTTON
								//if there are not subcategories echo a message that explain that and
								//display a link to create new collections/categories/libraries
								if(count($subcollections) == 0){
									echo "<li style = \"margin:auto\">There are not subcategories available. Do you want to create a <a href = \"../views/library.php?coll=" . $item_collection->get__collection_id() . "\"><b>new subcategory?</b></a></li>";
								} else{
									foreach($subcollections as $item){
										$item_subcollection = new CollectionLogic( $item[ "id" ] );
										echo "<li class = \"slide\"><a class = \"todo__collection-body-subcategory-list-item\" href = \"./library.php?id=" . $item_subcollection->get__collection_id() . "\">
										". $excerpt->excerpt( $item_subcollection->get__collection_name(), $excerpt->get__collection_subcollection() )."</a></li>";
									}
									echo "</div>";
								}
								?>
							</ul>
						</div>
						<?php //TODOS ?>
						<div class = "todo__collection-body-todo">
							<h3 class = "todo__collection-body--heading">Todo(s)</h3>
							<?php
							$todosCollection = $item_collection->get__collection_todos();
							if(count($todosCollection) == 0){
								echo "<p style = \"text-align:center\">There are not todos available. Do you want to create a <a href = \"../views/todo.php\"><b>new todo?</b></a></p>";
							} else{
								foreach( $todosCollection as $item ){
									$item_todo = new TodoLogic( $item[ "id" ], $_SESSION[ "user_id" ] );
									echo "<div class = \"todo__collection-body-todo-container\">
													<div class = \"todo__todo-title\">
														<h4 class = \"todo__todo-title-collection\"><span>";
														include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/inc/levelsOfImportance/12x12/level-".$item_todo->get__todo_level().".svg";
														?></span><a href = "<?php echo "/TODO-PHP-OOP/views/todo.php?id=" . $item_todo->get__todo_id() ?>"><?php if( !empty( $item_todo->get__todo_name() ) )echo ucfirst( $excerpt->excerpt( $item_todo->get__todo_name(), $excerpt->get__collection_todo_name() ) );
									echo      "</a></h4>
													</div>
													<div class = \"todo__todo-description-container\">
														<p class = \"todo__todo-description\">";
														if( !empty( $item_todo->get__todo_description() ) ){
															echo $excerpt->excerpt( $item_todo->get__todo_description(), $excerpt->get__collection_todo_description() );
														}
									echo    "</p>
													</div>
												</div>";

								}
							}
							?>
						</div>
					<div class = "todo__library-footer">
						<p>Created be <span><?php echo $user->get__username(); ?></span> on <span><?php if( !empty( $item_collection->get__collection_created_date() ) ) echo $item_collection->get__collection_created_date(); ?></span>. Last update on <span><?php if( !empty( $item_collection->get__collection_updated_date() ) ) echo $item_collection->get__collection_updated_date(); ?></span></p>
					</div>
				</div>
			</div>
<?php
		}
?>
</div>
