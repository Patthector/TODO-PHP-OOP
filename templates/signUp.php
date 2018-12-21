<div id = "todo__registration--box" class = "container">
  <div class = "row todo__registration--container">
    <div class = "offset-4 col-sm-4 todo__registration--form-container">
      <div class = "todo__registration--logo-container">
        <div>
          <?php
          include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/inc/white-logo.html";
           ?>
        </div>
      </div>
      <h3 class = "todo__registration--heading">
        <?php
        if( isset( $createAccount ) && $createAccount ){
          echo "Create New Account";
        } else{
          echo "Sign In";
        }
        ?></h3>
      <form class = " todo__registration--form " action = "registration.php" method = "POST">

        <div class="form-group row">
          <label for = "user-name">Username</label>
          <input class="form-control" type = "text" name = "user-name" id = "user-name" placeholder = "Username" />

        </div>
        <div class="form-group row">
          <label for = "user-password">Password</label>
          <input class="form-control" type = "password" name = "user-password" id = "user-password" placeholder = "Password" />

        </div>
        <?php
        if( isset( $createAccount ) && $createAccount ){
          echo "<div class=\"form-group row\">
            <label for = \"password-confirmation\">Confirm Password</label>
            <input class=\"form-control\" type = \"password\" name = \"password-confirmation\" id = \"password-confirmation\" placeholder = \"Confirm password\" />
          </div>";
        }
        ?>
        <button class = "btn todo__btn-modal todo__btn-modal--info btn-block ml-0" type = "submit" name =
        <?php
        if( isset( $createAccount ) && $createAccount ){
          echo "\"sign-up\" value = \"sign-up\" > Create Account";
        } else{
          echo "\"log-in\" value = \"log-in\" > Sign In";
        }
         ?> </button>
      </form>
      <hr/>
      <?php
        if( isset( $createAccount ) && $createAccount ){
          echo "<p>Do you have an account?</p>";
        } else{
          echo "<p>Are you a new User?</p>";
        }
      ?>
      <button class = "btn todo__btn-modal todo__btn-modal--default btn-block ml-0"
      <?php
        if( isset( $createAccount ) && $createAccount ){
          echo " id = \"todo__registration--switch-sign-in\"> Sign in";
        } else{
          echo " id = \"todo__registration--switch-new-user\"> Create Account";
        }
       ?>
      </button>
    </div>
  </div>
</div>
