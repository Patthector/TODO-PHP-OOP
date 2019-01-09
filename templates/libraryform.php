<!-- TODO FORM TEMPLATE -->

<div class = "todo__form">
	<div class = "jumbotron_container row">
		<h1 class = "col-12 col-md-6"><?php if( isset( $collection)){echo $collection->get__page_heading();}else{ echo $library_heading;} ?></h1>
		<div class = "col-12 col-md-6 guidelines_container">
			<ul>
				<li>Give a meaningful descripiton for a later view</li>
				<li>Attach into a library/category that shares topics to add deeper levels of organization (subcategory)</li>
				<li>Add some <b>#tags</b> for an easier search</li>
			</ul>
		</div>
	</div>
<div class = "row justify-content-center">
	<div class = "todo_container  col-11 col-md-8">
		<form action = "library.php" method = "POST">
			<span class = "form-subheading">General Information</span>
			<div class = "row todo__form-separator">
				<div class = "col-12">
					<label for = "collection_name">Title</label>
					<!--.todo__input-form-->
					<input type = "text" name = "name" id = "collection_name" class="form-control todo__input-form" placeholder="Default LIBRARY"
					<?php
					if( isset( $collection ) && !empty($collection->get__collection_name())){
						echo "value='" . $collection->get__collection_name() ."'";
					}
					?>
					 />
			 </div>
	 		</div>
			 <div class = "row todo__form-separator">
				<div class = "col-12">
					<label for = "collection_description">Description</label>
					<!--.todo__input-form-->
					<textarea name = "collection_description" id = "collection_description" class="form-control todo__input-form" placeholder = "Type a reminder"><?php if( isset( $collection ) && !empty($collection->get__collection_description())) echo $collection->get__collection_description();?></textarea>
				</div>
			</div>
			<span class = "form-subheading">Additional Information</span>
			<div class = "row todo__form-separator">
				<div class = "col-12">
					<div class = "row">
						<div class = "col-12 col-md-6">
							<label for = "collection_library">Library</label>
							<select id = "collection_library" name = "father_collection" class="form-control custom-select custom-select-m todo__input-form"><!--.todo__input-form-->
								<option value = "">Main Library</option>
								<?php
								$collections = CollectionLogic::get__full_list_collections( $_SESSION[ "user_id" ] );

								if( isset( $collection ) && !empty($collection->get__collection_father_id()) ){
									$fatherCollection = $collection->get__collection_father_id();

									foreach($collections as $item_id){
										$item_collection = new CollectionLogic( $item_id["id"] );
										if( $fatherCollection === $item_collection->get__collection_id() ){
												echo "<option value='" . $item_collection->get__collection_id() . "' selected>" . $item_collection->get__collection_name() . "</option>";
										} else{
											echo "<option value='" . $item_collection->get__collection_id() . "'>" . $item_collection->get__collection_name() . "</option>";
										}
									}
								} else{
									foreach( $collections as $item_id ){
										$item_collection = new CollectionLogic( $item_id["id"] );
										if( isset( $fatherCollection ) && ( $fatherCollection == $item_collection->get__collection_id() ) ){
											echo "<option value='" . $item_collection->get__collection_id() . "' selected>" . $item_collection->get__collection_name() . "</option>";
										} else{
											echo "<option value='" . $item_collection->get__collection_id() . "'>" . $item_collection->get__collection_name() . "</option>";
										}
									}
								}
								?>
							</select>
						</div>
						<div class = "col-12 col-md-5 todo__form-main-category-message todo-message">
							<p>If you want to convert this library in a subcollection; select the Main Library/Father Library.</p><span>Want to create a <b><a href = "./todo.php">TODO</a></b> instead.</span>
						</div>
					</div>
				</div>
			</div>

			<div class = "row todo__form-separator todo__form-container-buttons">
				<div class = "col-6 left">
					<a class = "btn todo__btn-form todo__btn-form--dark" href = "./mytodos.php">Cancel</a>
				</div>
				<div class = "col-6">
					<?php if( isset( $collection ) && !empty( CollectionLogic::get__state() ) && CollectionLogic::get__state() == "editCollection" ){
								echo "<input type = \"hidden\" name = \"editCollection\" value ='" . $collection->get__collection_id() . "'/>";
						} else{
									echo "<input type = \"hidden\" name = \"action\" value = \"createCollection\" />";
						}
					?>
					<input class = "btn todo__btn-form todo__btn-form--blue" type = "submit" value = "DONE" />
				</div>
			</div>
		</form>
	</div>
</div>
</div>
