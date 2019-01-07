<div id = "todo__registration--box" class = "container todo__registration--box">
  <div class = "row todo__registration--container">
    <div class = "todo__registration--form-container">
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
      <form id = "todo__registration--form" class = " todo__registration--form " action = "registration.php" method = "POST">

        <div class="form-group  row">
          <!-- Helper & Collapse BLOCK-->
          <label class="position-relative" for = "user-name">Username
            <span class = "todo__registration--tooltips-svg" type="button" data-toggle="collapse" data-target="#todo__username--collapse" aria-expanded="false" aria-controls="usernameCollapse" alt = "Click for help"><?php include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/inc/question-mark.svg"; ?></span>
          </label>
          <div class="collapse" id="todo__username--collapse">
            <div class="card card-body mb-3 todo__registration--collapse-msg">
              The right formating for username is a combination of letters and numbers. More than 6 characters.
            </div>
          </div>
          <!--end Helper & Collapse BLOCK-->

          <!--INPUT Username-->
          <input class="form-control <?php if( isset( $user_exists ) && $user_exists ){ echo "is-invalid"; } else if( isset( $user_exists ) && empty( $user_exists ) ){echo "is-valid"; } ?> "
            type = "text" name = "user-name" id = "<?php if( isset( $createAccount ) && $createAccount ){echo "new-user-name";}else{ echo "user-name";} ?>"
            value = "<?php if( isset( $username ) )echo $username; ?>" placeholder = "Username" />
          <!--INPUT Feedback Username-->
          <div class="valid-feedback">
            Valid username.
          </div>
          <div class="invalid-feedback">
            Unfortunately this username is taken! Please try a different one.
          </div>
          <!--end INPUT Feedback Username-->
        </div>
        <div class="form-group  row">
          <!-- Helper & Collapse BLOCK-->
          <label class="position-relative" for = "user-password">Password
            <span class = "todo__registration--tooltips-svg" type="button" data-toggle="collapse" data-target="#todo__password--collapse" aria-expanded="false" aria-controls="passwordCollapse" alt = "Click for help" ><?php include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/inc/question-mark.svg"; ?></span>
          </label>
          <div class="collapse" id="todo__password--collapse">
            <div class="card card-body mb-3 todo__registration--collapse-msg">
              The right formating for password is a combination of letters and numbers. More than 6 characters.
            </div>
          </div>
          <!--end Helper & Collapse BLOCK-->

          <!--INPUT Password-->
          <input class="form-control" type = "password" name = "user-password"
          <?php
          if( isset( $createAccount ) && $createAccount ){
            echo "id = \"new-user-password\"";
          }else{
            echo "id = \"user-password\"";
          }
          ?>
            placeholder = "Password" />
          <!--INPUT Feedback Password-->
          <div class="valid-feedback">
            All good!
          </div>
          <div class="invalid-feedback">
            Unfortunately this is an invalid password! See if your password follows all the rules.
          </div>
        </div>
        <!--end INPUT Feedback Password-->
        <?php
        if( isset( $createAccount ) && $createAccount ){
          echo "<div class=\"form-group row\">
            <label for = \"password-confirmation\">Confirm Password</label>
            <input class=\"form-control\" type = \"password\" name = \"password-confirmation\" ";
            if( isset( $password_confirmation ) && !empty( $password_confirmation ) ){
              echo "value=\"$password_confirmation\"";
            }
          echo "id = \"password-confirmation\" placeholder = \"Confirm password\" disabled />
            <div class=\"valid-feedback\">
              All good!
            </div>
            <div class=\"invalid-feedback\">
              The passwords don't match, please verify again.
            </div>
          </div>";
        }
        ?>
        <button id = "todo__registration--submit" class = "btn todo__btn-modal todo__modal-info btn-block ml-0" type = "submit" name =
        <?php
        if( isset( $createAccount ) && $createAccount ){
          echo "\"sign-up\" value = \"sign-up\"> Create Account";
        } else{
          echo "\"log-in\" value = \"log-in\"> Sign In";
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
          echo " id = \"todo__registration--sign-in-switcher\"> Sign in";
        } else{
          echo " id = \"todo__registration--new-user-switcher\"> Create Account";
        }
       ?>
      </button>
    </div>
  </div>
</div>
