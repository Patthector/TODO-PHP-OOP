<?php

if( !empty( $_GET["msg"] )){
	$msg = filter_input( INPUT_GET, "msg", FILTER_SANITIZE_STRING );
}
if( !empty( $collection ) && !empty(CollectionLogic::get__msg())){ $msg = CollectionLogic::get__msg(); }
if( !empty( $msg )){
	echo "<div id = \"todo__message\" class=\"container alert alert-dark alert-dismissible fade show todo__box-message\" role=\"alert\">" ." ".  $msg . "
				 	<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
				    <span aria-hidden=\"true\">&times;</span>
				  </button>
		</div>";

}

	?>
