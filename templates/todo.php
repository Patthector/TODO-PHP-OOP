
<main role="main" class="inner cover">
    <!-- EDITE MODE BUTTON --> <!-- remember to add this in its own template -->
    <button class = "btn btn-danger" id = "todo_edit_mode">EDIT MODE</button>
    <div>
        <form action = "" method="post" class = "editMode_on" id = "editModeForm" style = "display: none;">
            <input type = "hidden" name = "edit" <?php echo "value=" . $todo["id"];  ?> />
            <input type = "submit" value = "SAVE" class = "btn btn-sm btn-success" />
            <button id = "button_form_cancel" class = "btn btn-sm btn-default">CANCEL</button>
            <div class = "form-group">
                <div class = "form-control">
                    <input type = "text" class = "form-control" id = "edit_mode_todo_title" name = "name" 
                    <?php
                    echo "value = '" . $title_heading . "'";
                    ?>
                    />
                </div>
                <div class = "form-control">
                    <select name = "level">
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
                </div>

                <div class = "form-control">
                    <select name = "collection">
                        <?php 
                        foreach ( $collections as $collection ) {

                            if( $collection["id"] == $todo["id_collection"] ){
                                echo "<option value=" . $collection["id"] . " selected>" . $collection["name"] . "</option>";
                            } else{
                                echo "<option value=" . $collection["id"] . ">" . $collection["name"] . "</option>";
                            }                            
                        }
                        ?>
                    </select>
                </div>

                <div class = "form-control">
                    <textarea name = "description"><?php echo $todo["description"]; ?></textarea>
                </div>

                 <div class = "form-control">
                    <textarea name = "tags"><?php echo implode(" ",$todo["tags"]); ?></textarea>
                </div>

            </div>
        </form>
    </div>

	<!-- MESSAGE-STATUS -->
	<?php include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP [with JS]/templates/message.php"; ?>
    	<h1 class="cover-heading editMode_off" id = "todo_title"><?php if( !empty($title_heading) ) { echo $title_heading; } ?></h1>

    	<?php
    	if(!empty($todo)){ # we are trying to READ a TODO
    		$collection = Collection::getCollection($todo["id_collection"]); # get the COLLECTION of the TODO
    		echo "<p class=\"editMode_off\" id=\"todo_collection\">Collection: <a href='./library.php?id=" . $collection["id"] . "'>" .$collection["name"] . "</a></p>";

    		echo "<p class=\"editMode_off\" id=\"todo_description\">" . $todo["description"] . "</p>";

    		foreach($todo["tags"] as $t){
    			/*if( array_key_exists("tag_name", $t) ){
    				echo $t["tag_name"] . "   ";
    			}*/
                echo "<span class=\"editMode_off\">" . $t . "   " . "</span>";
    		}
    		echo "<form action = \"\" method = \"post\">
	    			<div class = \"form-group\">
		    			<input type = \"submit\" value = \" DELETE \" class = \"btn btn-sm btn-danger editMode_on_disabled\" id=\"todo_delete\"/>
		    			<input type=\"hidden\" value=" .$todo["id"]. " name = \"delete\"/>
		    			<a class = \"btn btn-sm btn-primary editMode_on_disabled\" href = \"./mytodos.php\" id=\"todo_mytodos\"> myTODOs </a>
		    		</div>
	    		</form>";

            //EDIT MODE ENEABLE ON FORM

    	} else{ # TODO NOT FOUND send the use two other options to follow
	    	echo "<div class = \"\">
	    			<a class = \"btn btn-sm btn-primary\" href = \"./mytodos.php\"> myTODOs </a>
	    			<a class = \"btn btn-sm btn-primary\" href = \"./createtodo.php\"> Create TODO </a>
	    		</div>";
    	}
    	