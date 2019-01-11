    </main>
  </div>
  <footer class="mastfoot dotted-border
  <?php
  if( class_exists( "TodoLogic" ) && !empty( TodoLogic::get__state() ) ){
    switch ( TodoLogic::get__state()) {
      case "createTodo":
        echo "";
        break;

      case "editTodo":
        echo "";
        break;

      case "readTodo":
        echo "footer-absolute";
        break;

      default:
        echo "";
        break;
    }
  } else if( class_exists( "CollectionLogic" ) && !empty( CollectionLogic::get__state() ) ){
    switch ( CollectionLogic::get__state()) {
      case "createCollection":
        echo "";
        break;

      case "editCollection":
        echo "";
        break;

      case "readCollection":
        echo "";
        break;

      default:
        echo "";
        break;
    }
  }
  ?>
  ">
    <p class="col-10 col-md-8 coder-message">This application has been created by <a href = "#"  class = "high-sapphire">@patthector</a> as an example project. The objective of this project is to put in practice some konwlegde, as the following: Photoshop, Illustrator, PHP, OOP, mySQL. This app is free to use for everybody.</p>
    <div class="inner">
      <p>All Rights Reserved.  <a href="https://getbootstrap.com/">by Pattor</a>, <?php echo date("Y");?>.</p>
    </div>
  </footer>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="/TODO-PHP-OOP/vendor/jquery.js" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="vendor/jquery.js"><\/script>')</script>
    <script src="/TODO-PHP-OOP/vendor/popper.js"></script>
    <script src="/TODO-PHP-OOP/vendor/js/bootstrap.min.js"></script>
    <script src="/TODO-PHP-OOP/vendor/js/message.js"></script>
    <script src="/TODO-PHP-OOP/vendor/js/carousel.js"></script>
    <script src="/TODO-PHP-OOP/vendor/js/app.js"></script>
    <!--<script src = "/TODO-PHP-OOP/vendor/js/action-menu.js"></script>-->
    <!--TEST-->
    <script src = "/TODO-PHP-OOP/vendor/js/action_menu_oop.js"></script>
    <!-- -->
    <script src = "/TODO-PHP-OOP/vendor/js/tags.js"></script>
    <!--<script src = "/TODO-PHP-OOP/vendor/js/registration.js"></script>-->
    <!--TEST-->
    <script src = "/TODO-PHP-OOP/vendor/js/registration-oop.js"></script>
    <!-- -->
    <script src = "/TODO-PHP-OOP/vendor/js/search.js"></script>
    <script src = "/TODO-PHP-OOP/vendor/js/viewport.js"></script>

  </body>
</html>
