<?php
include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/classes/user.php";

if( $_SERVER[ "REQUEST_METHOD" ] == "GET" ){
  if( isset( $_GET[ "valid-username" ] ) ){
    $username = trim( filter_input( INPUT_GET, "valid-username", FILTER_SANITIZE_STRING ) );
    $valid_user = User::userExist( $username );
    include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/signUp.php";
    exit;
  } else if( isset( $_GET[ "log-out" ] ) ){
    session_start();
    session_unset();
    session_destroy();
    header("Location:../index.php");exit;
  }
  else{
    include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/header.php";
    include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/login.php";
    include $_SERVER["DOCUMENT_ROOT"] . "/TODO-PHP-OOP/templates/footer.php";
    exit;
  }

}
else if( $_SERVER[ "REQUEST_METHOD" ] == "POST" ){

  if( !empty( $_POST["sign-up"] ) ){

    $username = trim(filter_input( INPUT_POST, "user-name" , FILTER_SANITIZE_STRING ));
    $password = trim(filter_input( INPUT_POST, "user-password" , FILTER_SANITIZE_EMAIL ));
    $hashedPassword = password_hash( $password, PASSWORD_DEFAULT );

    if( User::addUser( $username, $hashedPassword ) ){header( "Location:./mytodos.php" );exit;}
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
    $hashedPassword = password_hash( $password, PASSWORD_DEFAULT );
    $user_exist = User::userExist( $username );
    $todo__user = new User( $user_exist["id"], $user_exist["username"], $user_exist["password"] );

    if( $user_exist && password_verify( $hashedPassword, $user_exist[ "password" ] ) ){
      session_start();
      $_SESSION[ "user_id" ] = $todo__user->get__user_id();
      $_SESSION[ "username" ] = $todo__user->get__username();

      header( "Location:./mytodos.php" );exit;
    } else{
      //the passwords didnt match or the user does not exist
      header( "Location:./registration.php?msg=wrongPassword" );exit;
    }
  }

} else{
  header( "Location:../index.php" );exit;
}
