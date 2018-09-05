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

	<link href =" <?php echo "/TODO-PHP-OOP [with JS]/vendor/css/bootstrap.min.css"; ?>" rel="stylesheet" crossorigin="anonymous">
	<link href = "<?php echo "/TODO-PHP-OOP [with JS]/inc/css/styles.css"; ?>" rel="stylesheet" crossorigin="anonymous">
  <link href = "<?php echo "/TODO-PHP-OOP [with JS]/inc/css/styles.css.map"; ?>" rel="stylesheet" crossorigin="anonymous">
  </head>

  <body>
    <div id = "main" class = "container-fluid todo__main-background">
      <header id="header" class="header__blue-gradient
      <?php
        if($state == "createTodo" || $state == "createCollection" || $state == "editTodo" || $state == "editCollection"){
          echo " white-header";
        } else if($state == "readTodo" || $state == "readCollection"){
          echo "";//niente
        } else{
          echo "";
        }
      ?>
      ">
        <ul class=" navbar-nav header__menu">
          <li class="header__menu-item">
            <a class="" href="/views/mytodos.php">myTODOs</a>
          </li>
          <li class="header__logo">
            <a id = "logo-svg" class="h1" href="/TODO-PHP-OOP [with JS]">
              <?php
              if(isset($state)){
                if($state == "createTodo" || $state == "createCollection" || $state == "editTodo" || $state == "editCollection"){
                   include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP [with JS]/inc/blue-logo.html";
                } else if($state == "readTodo" || $state == "readCollection"){
                   include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP [with JS]/inc/white-logo.html";
                }
              }
              else{
                include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP [with JS]/inc/white-logo.html";
              }
               ?></a>
          </li>
          <li class="header__menu-item">
            <a class="" href="#">Log out</a>
          </li>
        </ul>
      </header>
