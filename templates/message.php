<?php

if(!empty($msg)){
		echo "<div class=\"container alert alert-dark alert-dismissible fade show todo__message\" role=\"alert\">" ." ".  $msg . "
			 	<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
			    <span aria-hidden=\"true\">&times;</span>
			  	</button>
			</div>";
	}
