<?php


# variables
# ---------

$title_page = "Stick it | Home";

if($_SERVER["REQUEST_METHOD"] == "GET"){
	if(!empty($_GET["msg"])){
		$m = trim(filter_input(INPUT_GET, "msg", FILTER_SANITIZE_STRING));
		if(!empty($m)){
			$message = $m;
		} else{
			header("Location: index.php");exit;
		}
	}
}


include "templates/header.php";
?>

  <main role="main" class="inner cover">
  	<?php
	if(!empty($message)){
		echo "<div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\">
			  	<strong>Alright!</strong>" ." ".  $message . "
			 	<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
			    <span aria-hidden=\"true\">&times;</span>
			  	</button>
			</div>";
	}
	?>
    <h1 class="cover-heading">Don't let your ideas take off!</h1>
    <p class="lead">Keep all your ideas organize in a matter that fits your thinking process. Use categories and subcategories to have a better understand of your thoughts. Work in groups by making orders part of your boxes of ideas.</p>
    <p class="lead">
      <a href="views/createlibrary.php" class="btn btn-lg btn-secondary"> New Library</a>
      <a href="views/createtodo.php" class="btn btn-lg btn-secondary"> New TODO</a>
    </p>

<?php 

include "templates/footer.php";