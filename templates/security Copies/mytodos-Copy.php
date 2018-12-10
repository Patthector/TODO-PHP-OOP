
<main>
	<!-- MESSAGE-STATUS -->
	<?php include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/message.php"; ?>
	<div class = "container">
		<?php
		foreach($libraries as $collection){

	echo "<div class \"row\">
					<div class = \"col-8 offset-2\">
						<div class = \"library\">
							<div class = \"library_header\">
								<h3><a href = \"./library.php?id=". $collection["id"] ."\">Category: " . $collection["name"] . "</a></h3>
								<span><i>full path:</i></span> " . Library::renderFullPath( Collection::getFullPath($collection["id"])) . "
							</div>
							<hr/>
							<div class = \"library_subheader\">";
								$subcollections = $collection["subcollections"];
								if(count($subcollections) > 0 ){
									echo "<ul>";
									foreach($subcollections as $subcollection){
										echo "<li><a href = \"./library.php?id=". $subcollection["id"] ."\">" . $subcollection["name"] . "</li>";
									}
									echo "</ul>";
								} else{
									echo "<p><i>no subcollections available.</i></p>";
								}
					  echo "</div>
							<hr/>
							<div class = \"library_todos\">";
								$todos = $collection["todos"];
								if(count($todos) > 0 ){
									echo "<ul>";
									foreach($todos as $todo){
										echo "<li>
												<h5><a href = \"./todo.php?id=". $todo["id"] ."\">" . $todo["name"] . "</a></h5>
												<p style = \"text-align:left;\">" . $todo["description"] . "
											</li>";
									}
									echo "</ul>";
								} else{
									echo "<p><i>no todos available.</i></p>";
								}
					  echo "</div>
							<hr/>
							<div class = \"library_metadate\">
								<h5>General Information:</h5>
								<p><i>Created by: </i>" . $collection["id_user"] . ", on " . $collection["created_date"] . ".</p>";
								if(!empty($collection["updated_date"])){
									echo "<p><i>Last Update: " . $collection["updated_date"] . "</i></p>";
								}
				  echo "</div>
						</div>
					</div>
				</div>";
		}
		?>
	</div>
