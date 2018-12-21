<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="The most popular HTML, CSS, and JS library in the world.">
	<meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
	<meta name="generator" content="Jekyll v3.8.0">

	<title><?php echo $title_page; ?></title>

	<!-- Bootstrap core CSS -->

	<link href =" <?php echo "/TODO-PHP-OOP/vendor/css/bootstrap.min.css"; ?>" rel="stylesheet" crossorigin="anonymous">
	<link href = "<?php echo "/TODO-PHP-OOP/inc/css/styles.css"; ?>" rel="stylesheet" crossorigin="anonymous">
  <link href = "<?php echo "/TODO-PHP-OOP/inc/css/styles.css.map"; ?>" rel="stylesheet" crossorigin="anonymous">
  </head>

  <body>
    <div id = "main" class = "container-fluid todo__main-background">
      <header id="header" class="header__blue-gradient
      <?php
      if( class_exists( "TodoLogic" ) && !empty( TodoLogic::get__state() ) ){
        switch ( TodoLogic::get__state()) {
          case "createTodo":
            echo "white-header";
            break;

          case "editTodo":
            echo "white-header";
            break;

          case "readTodo":
            echo "";
            break;

          default:
            echo "";
            break;
        }
      } else if( class_exists( "CollectionLogic" ) && !empty( CollectionLogic::get__state() ) ){
        switch ( CollectionLogic::get__state()) {
          case "createCollection":
            echo "white-header";
            break;

          case "editCollection":
            echo "white-header";
            break;

          case "readCollection":
            echo "";
            break;

          default:
            echo "";
            break;
        }
      } else{
        echo "";
      }
      ?>
      ">
        <ul class=" navbar-nav header__menu">
          <li class="header__menu-item">
            <a class="" href="/TODO-PHP-OOP/views/mytodos.php">myTODOs</a>
          </li>
          <li class="header__logo">
            <a id = "logo-svg" class="h1" href="/TODO-PHP-OOP/index.php">
              <?php
              if( class_exists( "TodoLogic" ) && !empty( TodoLogic::get__state() ) ){
                switch ( TodoLogic::get__state() ) {
                  case "createTodo":
                    include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/inc/blue-logo.html";
                    break;

                  case "editTodo":
                    include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/inc/blue-logo.html";
                    break;

                  case "readTodo":
                   include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/inc/white-logo.html";
                    break;

                  default:
                    include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/inc/white-logo.html";
                    break;
                }
              } else if( class_exists( "CollectionLogic" ) && !empty( CollectionLogic::get__state() ) ){
                switch ( CollectionLogic::get__state() ) {
                  case "createCollection":
                    include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/inc/blue-logo.html";
                    break;

                  case "editCollection":
                    include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/inc/blue-logo.html";
                    break;

                  case "readCollection":
                   include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/inc/white-logo.html";
                    break;

                  default:
                    include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/inc/white-logo.html";
                    break;
                }
              } else{
                include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/inc/white-logo.html";
              }
              ?></a>
          </li>
          <li class="header__menu-item">
            <?php
            if( isset( $_SESSION[ "user_id" ] ) ){
              echo "<a id = \"todo__logout-button\" href=\"#\">Log out</a>";
              //LOGOUT will trigger an AJAX request to call the registration GET method and log you out
            } else{
              echo "<a href=\"" ."views/registration.php". "\">Log in</a>";
            }
            ?>
          </li>
        </ul>
      </header>
