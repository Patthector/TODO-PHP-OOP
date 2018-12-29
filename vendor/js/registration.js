"use strict";

$( document ).ready( function(){

//LOGGING OUT THE USER
  $( "#todo__logout-button" ).on( "click",function( e ){ loggingOutUser(); });
//SWITVHING FROM SIGN IN TO CREATE ACCOUNT AND VICE VERSA
  $( document ).on( "click", "#todo__registration--switch-sign-in", function( e ){ registrationSwitchAction( e.target.id ) });
  $( document ).on( "click", "#todo__registration--switch-new-user", function( e ){ registrationSwitchAction( e.target.id ) });
//VALIDATING THE REGISTRATION FORM
  //--USERNAME VALIDATION
    //--USER REGISTRATION
    $( document ).on( "blur", "#new-user-name", function( e ){ userVerification( e.target.value, e.target.id ) } );
    $( document ).on( "keyup", "#new-user-name", function( e ){ cleanFeedback( e.target.id ) } );
    //--USER SIGN IN
    $( document ).on( "keyup", "#user-name", function( e ){ enableButtonSubmit() } );
  //--USER PASSWORD VALIDATION
  $( document ).on( "blur", "#user-password", function( e ){ passwordValidation( e.target.value, e.target.id, true )} );
  $( document ).on( "keyup", "#user-password", function( e ){ passwordValidation( e.target.value, e.target.id )} );
  $( document ).on( "keyup", "#user-password", function( e ){ enableButtonSubmit()} );
  //--USER PASSWORD CONFIRMATION VALIDATION
  $( document ).on( "keyup", "#password-confirmation", function( e ){ passwordMatch( e.target.value )} );
  $( document ).on( "blur", "#password-confirmation", function( e ){ passwordMatch( e.target.value, true )} );
  $( document ).on( "keyup", "#password-confirmation", function( e ){ enableButtonSubmit()} );


});

function loggingOutUser(){
  var url = window.location.origin + "/TODO-PHP-OOP/views/registration.php";

 //AJAX sending the user to registration.php
 $.ajax({
   url : url,
   data : { "log-out" : true },
   method : "GET",
   success : function( data ){
     window.location.href = window.location.origin + "/TODO-PHP-OOP/index.php?msg=LoggedOut";
   }
 });
 return;
}

function registrationSwitchAction( button_id ){

  var url = window.location.origin + "/TODO-PHP-OOP/views/registration.php";

  if( button_id == "todo__registration--switch-sign-in" ){
    //AJAX sending the user to registration.php
    $.ajax({
      url : url,
      data : { "switch-to-sign-in" : true },
      method : "GET",
      success : function( data ){
        $( "#todo__registration--box" ).remove();
        $( "#main" ).append( data );
        console.log("sign");
      }
    });
  }else if( button_id == "todo__registration--switch-new-user" ){
    //AJAX sending the user to registration.php
    $.ajax({
      url : url,
      data : { "switch-to-new-user" : true },
      method : "GET",
      success : function( data ){
        $( "#todo__registration--box" ).remove();
        $( "#main" ).append( data );
        console.log("create");
      }
    });
  }
  return;
}

function userValidation( username, id ){
  var regex = /^[a-zA-Z0-9!@#\$%\^\&*\)\(+=._-]{6,}$/g;
  if( username.match( regex ) ){// it is a valid username, we can proceed
    return true;
  }//
  //if username doesn't match with the rules
  if( !( $( "#"+id ).hasClass( "is-invalid" ) ) ){ $( "#"+id ).addClass( "is-invalid" ); }
  $("#"+id).siblings(".invalid-feedback").text( "Wrong formation in the username. Please check the rules of formation." );
  return false;
}

function userVerification( username, id){

  var data = { action : 'user_verification', username : username };
  //USER PASSWORD
  if( $( "#user-password" ).hasClass( "is-valid" ) ){
    data.password = $( "#user-password" ).val();
  }
  //USER PARSSWORD CONFIRMATION
  if( $( "#password-confirmation" ).hasClass( "is-valid" ) ){
    data.password_confirmation = $( "#password-confirmation" ).val();
  }
  //if new username is back to empty value, dont do the call
  if( userValidation( username, id ) ){
      var request = $.ajax({
      url: window.location.href,
      method: "GET",
      data: data
    });

    request.done(function( data ) {
      $( "#todo__registration--box" ).remove();
      $( "#main" ).append( data );
      //console.log($( "#user-password" ).val()); return;
      if( $( "#user-password" ).val() ){ passwordValidation( $( "#user-password" ).val() ) }
      if( $( "#password-confirmation" ).val() ){ passwordMatch( $( "#password-confirmation" ).val() ) }
    });

    request.fail(function( jqXHR, textStatus ) {
      alert( "Request failed: " + textStatus );
    });

    enableButtonSubmit();
  }
}

function passwordValidation( password, id, last_check=null ){
  cleanFeedback( id )
  var regex = /^[a-zA-Z0-9!@#\$%\^\&*\)\(+=._-]{6,}$/g;
  if( password !== "" ){//if user-password is not empty
    if( password.match( regex ) ){
      $( "#user-password" ).addClass( "is-valid", );
      $( "#user-password" ).removeClass( "is-invalid" );
      $( "#password-confirmation" ).removeAttr( "disabled" );
    }else{
      if( last_check ){
        $( "#user-password" ).addClass( "is-invalid" );
      }
      $( "#user-password" ).removeClass( "is-valid" );
      if( $( "#password-confirmation" ).attr( "disabled" ) != "disabled" ){
        //add the attr disabled back
        $( "#password-confirmation" ).attr( "disabled", "disabled" );
      }
    }
  }
  return;
}

function passwordMatch( password_confirmation, last_check=null ){

  var password = $( "#user-password" ).val();
  if( password_confirmation !== password && last_check ){
    //passwords dont match
    $( "#password-confirmation" ).addClass( "is-invalid" );
    $( "#password-confirmation" ).removeClass( "is-valid" );
  }else if( password_confirmation == password ){
    //passwords are equal
    $( "#password-confirmation" ).addClass( "is-valid" );
    $( "#password-confirmation" ).removeClass( "is-invalid" );
    if( $( "#new-user-name" ).hasClass( "is-valid" ) ){
      //enable submit button
      enableButtonSubmit();
    }
  }

}

function enableButtonSubmit(){
//if all the fields have been filled, enable the submit button

  if( ( $( "#new-user-name" ).hasClass( "is-valid" ) &&
        $( "#user-password" ).hasClass( "is-valid" ) &&
        $( "#password-confirmation" ).hasClass( "is-valid"))
      ||
      ( $( "#user-name" ).val() &&
        $( "#user-password" ).hasClass( "is-valid" ) ) ) {

    $( "#todo__registration--submit" ).removeAttr( "disabled" );
  }
    return;
}

function cleanFeedback( id ){

  if( $( "#" + id ).hasClass( "is-valid" ) ){  $( "#" + id ).removeClass( "is-valid" ) }
  else if( $( "#" + id ).hasClass( "is-invalid" ) ){  $( "#" + id ).removeClass( "is-invalid" ) }
  return;
}
