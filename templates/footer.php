    </main>
  </div>
  <footer class="mastfoot mt-auto dotted-border
  <?php
    if($state == "createTodo" || $state == "createCollection" || $state == "editTodo" || $state == "editCollection" || $state == "readCollection"){
      echo "";
    } else if($state == "readTodo"){
      echo "footer-absolute";//niente
    }
  ?>
  ">
    <p class="coder-message">This application has been created by <a href = "#"  class = "high-sapphire">@patthector</a> as an example project. The objective of this project is to put in practice some konwlegde, as the following: Photoshop, Illustrator, PHP, OOP, mySQL. This app is free to use for everybody.</p>
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
    <script src = "/TODO-PHP-OOP/vendor/js/action-menu.js"></script>
    <script src = "/TODO-PHP-OOP/vendor/js/tags.js"></script>
    <script src="/TODO-PHP-OOP/vendor/js/app.js"></script>
  </body>
</html>
