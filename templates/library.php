
<main role="main" class="inner cover">
	<!-- MESSAGE-STATUS -->
	<?php include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP [with JS]/templates/message.php"; ?>
    	<h1 class="cover-heading"><?php if( !empty($title_heading) ) { echo $title_heading; } ?></h1>

    	<?php
    	if(!empty($collection)){ # we are trying to READ a Library
    		$collection_path = Collection::getFullPath($collection["id"]);
    		$collection_path = array_reverse($collection_path);
    		echo "<p>Collection: ";
    		foreach( $collection_path as $key=>$path){
    			if( $key == (count($collection_path) - 1) ){
    				echo "<a href='./library.php?id=" . $path["id"] . "'>" .$path["name"] . "</a>";	
    			} else{
    				echo "<a href='./library.php?id=" . $path["id"] . "'>" .$path["name"] . "/ " . "</a>";	
    			}    			
    		} 
    		echo "</p>";    		
    		echo "<p>" . $collection["description"] . "</p>";
            echo "<div class = \"library_todos\">";
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
            echo "</div>";            
    		echo "<form action = \"\" method = \"post\">
	    			<div class = \"form-group\">
		    			<input type = \"submit\" value = \" DELETE \" class = \"btn btn-sm btn-danger\" />
		    			<input type=\"hidden\" value=" .$collection["id"]. " name = \"delete\"/>
		    			<a class = \"btn btn-sm btn-primary\" href = \"./mytodos.php\"> myTODOs </a>
		    		</div>
	    		</form>";
    	} else{ # Collection NOT FOUND send the use two other options to follow
	    	echo "<div class = \"\">
	    			<a class = \"btn btn-sm btn-primary\" href = \"./mytodos.php\"> myTODOs </a>
	    			<a class = \"btn btn-sm btn-primary\" href = \"./createlibrary.php\"> Create TODO </a>
	    		</div>";
    	}
    	