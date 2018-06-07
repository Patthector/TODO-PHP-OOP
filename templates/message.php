<?php

if(!empty($message)){
		echo "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">
			  	<strong>Psssss!</strong>" ." ".  $message . "
			 	<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
			    <span aria-hidden=\"true\">&times;</span>
			  	</button>
			</div>";
	}