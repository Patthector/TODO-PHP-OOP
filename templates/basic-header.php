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

	<!-- Favicons
	<link rel="apple-touch-icon" href="/docs/4.1/assets/img/favicons/apple-touch-icon.png" sizes="180x180">
	<link rel="icon" href="/docs/4.1/assets/img/favicons/favicon-32x32.png" sizes="32x32" type="image/png">
	<link rel="icon" href="/docs/4.1/assets/img/favicons/favicon-16x16.png" sizes="16x16" type="image/png">
	<link rel="manifest" href="/docs/4.1/assets/img/favicons/manifest.json">
	<link rel="mask-icon" href="/docs/4.1/assets/img/favicons/safari-pinned-tab.svg" color="#563d7c">
	<link rel="icon" href="/favicon.ico">
	<meta name="msapplication-config" content="/docs/4.1/assets/img/favicons/browserconfig.xml">
	<meta name="theme-color" content="#563d7c">
	-->

	<!-- Twitter
	<meta name="twitter:card" content="summary_large_image">
	<meta name="twitter:site" content="@getbootstrap">
	<meta name="twitter:creator" content="@getbootstrap">
	<meta name="twitter:title" content="Bootstrap">
	<meta name="twitter:description" content="The most popular HTML, CSS, and JS library in the world.">
	<meta name="twitter:image" content="https://getbootstrap.com/assets/brand/bootstrap-social.png">
	 -->
	<!-- Facebook
	<meta property="og:url" content="https://getbootstrap.com/">
	<meta property="og:title" content="Bootstrap">
	<meta property="og:description" content="The most popular HTML, CSS, and JS library in the world.">
	<meta property="og:type" content="website">
	<meta property="og:image" content="http://getbootstrap.com/assets/brand/bootstrap-social.png">
	<meta property="og:image:secure_url" content="https://getbootstrap.com/assets/brand/bootstrap-social.png">
	<meta property="og:image:type" content="image/png">
	<meta property="og:image:width" content="1200">
	<meta property="og:image:height" content="630">
	 -->
  </head>

  <body>
      <header class="">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
          <a class="navbar-brand mb-0 h1" href="/TODO-PHP-OOP [with JS]"><?php include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP [with JS]/inc/logo.html"; ?></a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
              <li class="nav-item active">
                <a class="nav-link" href="/views/mytodos.php">myTODOs</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Log out</a>
              </li>
            </ul>
          </div>
        </nav>
      </header>
