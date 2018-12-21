<?php
include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/classes/user.php";

$title_page = "Stick it | Home";

if( $_SERVER[ "REQUEST_METHOD" ] == "GET" ){

  if( isset( $_GET[ "valid-username" ] ) ){
    $username = trim( filter_input( INPUT_GET, "valid-username", FILTER_SANITIZE_STRING ) );
    $valid_user = User::userExist( $username );
    include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/signUp.php";
    exit;
  }
  else if( isset( $_GET[ "switch-to-sign-in" ] ) ){//the user switch to sign in as an old user

    include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/signUp.php";
    exit;
  }
  else if( isset( $_GET[ "switch-to-new-user" ] ) ){//the user switch to create an account
    $createAccount = true;
    include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/signUp.php";
    exit;
  }
   else if( isset( $_GET[ "log-out" ] ) ){
    session_start();
    session_unset();
    session_destroy();
    exit;
  }
  else{
    include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/registration-header.php";
    include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/signUp.php";
    include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/registration-footer.php";
    exit;
  }

}
else if( $_SERVER[ "REQUEST_METHOD" ] == "POST" ){

  if( !empty( $_POST["sign-up"] ) ){

    $username = trim(filter_input( INPUT_POST, "user-name" , FILTER_SANITIZE_STRING ));
    $password = trim(filter_input( INPUT_POST, "user-password" , FILTER_SANITIZE_EMAIL ));
    $hashedPassword = password_hash( $password, PASSWORD_DEFAULT );

    if( User::addUser( $username, $hashedPassword ) ){
      $todo__user = User::userExist( $username );
      if( !empty( $todo__user ) ){
        session_start();
        $_SESSION[ "user_id" ] = $todo__user["id"];
        $_SESSION[ "username" ] = $todo__user["username"];

      }
      header( "Location:./mytodos.php" );exit;
    }
    else{header( "Location:./registration.php?msg=error" );exit;}

    //---------------------------------------------------------------
    //TODO- LIST
    // 1-) check if the user-name is taken via AJAX [.js]
    // 2-) check if the password and password-confirmation match via .js
    //--------------------------------------------------------------
  }
  else if( isset( $_POST[ "log-in" ] ) ){
    $username = trim(filter_input( INPUT_POST, "user-name" , FILTER_SANITIZE_STRING ));
    $password = trim(filter_input( INPUT_POST, "user-password" , FILTER_SANITIZE_EMAIL ));
    //$hashedPassword = password_hash( $password, PASSWORD_DEFAULT );
    $user_exist = User::userExist( $username );

    if( !empty( $user_exist ) ){
      $todo__user = new User( $user_exist["id"], $user_exist["user_name"], $user_exist["password"] );

      if( password_verify( $password, $todo__user->get__password() ) ){
        session_start();
        $_SESSION[ "user_id" ] = $todo__user->get__userId();
        $_SESSION[ "username" ] = $todo__user->get__username();

        header("Location: /TODO-PHP-OOP/views/mytodos.php");exit;
      }else {
        header( "Location: ./registration.php?msg=wrongPassword" );exit;
      }
    }
     else{
      //the passwords didnt match or the user does not exist
      header( "Location:./registration.php?msg=wrongInitials" );exit;
    }
  }

} else{
  //header( "Location:../index.php" );exit;
}