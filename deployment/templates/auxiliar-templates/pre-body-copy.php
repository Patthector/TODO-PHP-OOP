<body>
  <div id = "main" class = "container-fluid col-12 todo__main-background">
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
    <nav class="navbar navbar-expand-lg">
      <?php if ( $detect->isMobile() ) {
          echo "<a id = \"logo-svg\" class=\"navbar-brand header__logo\" href=\"/TODO-PHP-OOP/index.php\">";
            include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/temp-include/header-logo.php";
          echo "</a>";
          ?>
          <button class="navbar-toggler todo__header-button--mobile" type="button" data-toggle="collapse" data-target="#todonavbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span><?php include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/inc/ellipsis-v-solid.svg"; ?></span>
          </button>
          <div class="collapse navbar-collapse todo__navbar-collapse" id="todonavbarNav">
            <ul class="navbar-nav header__menu">
              <li class="nav-item header__menu-item">
                <a class="nav-link" href="/TODO-PHP-OOP/views/mytodos.php">myTODOs</a>
              </li>
              <li class="nav-item header__menu-item">
                <?php
                if( isset( $_SESSION[ "user_id" ] ) ){

                  $session_username = $_SESSION[ "username" ];
                  echo "<a class=\"nav-link\" id = \"todo__logout-button\" href=\"#\">Log out <span>($session_username)</span></a>";
                  //LOGOUT will trigger an AJAX request to call the registration GET method and log you out
                } else{
                  echo "<a class=\"nav-link\" href=\"" ."views/registration.php". "\">Log in</a>";
                }
                ?>
              </li>
            </ul>
          </div>

      <?php
        }//end if
      ?>
      <?php
      if ( $detect->isMobile() ) {
        ?>
      <button class="navbar-toggler todo__header-button--mobile" type="button" data-toggle="collapse" data-target="#todonavbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span><?php include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/inc/ellipsis-v-solid.svg"; ?></span>
      </button>
      <div class="collapse navbar-collapse todo__navbar-collapse" id="todonavbarNav">
        <ul class="navbar-nav header__menu">
          <li class="nav-item header__menu-item">
            <a class="nav-link" href="/TODO-PHP-OOP/views/mytodos.php">myTODOs</a>
          </li>
          <?php
            if (!($detect->isMobile()) ) {
              echo "<li class = \"nav-item header__logo\"  >";
              echo "<a id = \"logo-svg\" class=\"h1\" href=\"/TODO-PHP-OOP/index.php\">";
              include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/temp-include/header-logo.php";
            }
            ?>
          <li class="nav-item header__menu-item">
            <?php
            if( isset( $_SESSION[ "user_id" ] ) ){

              $session_username = $_SESSION[ "username" ];
              echo "<a class=\"nav-link\" id = \"todo__logout-button\" href=\"#\">Log out <span>($session_username)</span></a>";
              //LOGOUT will trigger an AJAX request to call the registration GET method and log you out
            } else{
              echo "<a class=\"nav-link\" href=\"" ."views/registration.php". "\">Log in</a>";
            }
            ?>
          </li>
        </ul>
      </div>
      <?php

    }?>
    </nav>

    </header>
    <div id = "todo__main-menu-size"></div>
    <style>
      #todo__main-menu-size{
        margin-top: 100px;
      }
    </style>
