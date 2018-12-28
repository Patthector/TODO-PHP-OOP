"use strict";

$( document ).ready( function(){

//LOGGING OUT THE USER
  $( "#todo__logout-button" ).on( "click",function( e ){ loggingOutUser(); });
  $( document ).on( "click", "#todo__registration--switch-sign-in", function( e ){ console.log("holis"); registrationSwitchAction( e.target.id ) });
  $( document ).on( "click", "#todo__registration--switch-new-user", function( e ){ registrationSwitchAction( e.target.id ) });
  $( document ).on( "blur", "#new-user-name", function( e ){ userVerification( e.target.value, e.target.id ) } );
  $( document ).on( "blur", "#user-password", function( e ){ passwordValidation( e.target.value )} );

  $( document ).on( "keyup", "#password-confirmation", function( e ){ passwordMatch( e.target.value )} );
  $( document ).on( "blur", "#password-confirmation", function( e ){ passwordMatch( e.target.value, true )} );

  $( document ).on( "keyup", "#user-password", function( e ){ enableButtonSubmit()} );
  $( document ).on( "keyup", "#password-confirmation", function( e ){ enableButtonSubmit()} );
  $( document ).on( "keyup", "#user-name", function( e ){ enableButtonSubmit() } );

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

function userVerification( username, id ){
  var data = { action : 'user_verification', username : username };
  if( $( "#user-password" ).hasClass( "is-valid" ) ){
    data.password = $( "#user-password" ).val();
  }
  if( $( "#password-confirmation" ).hasClass( "is-valid" ) ){
    data.password_confirmation = $( "#password-confirmation" ).val();
  }

  if( $( "#new-user-name" ).val() != "" ){
      var request = $.ajax({
      url: window.location.href,
      method: "GET",
      data: data
    });

    request.done(function( data ) {
      $( "#todo__registration--box" ).remove();
      $( "#main" ).append( data );
      if( $( "#user-password" ).val() !== "" ){ passwordValidation( $( "#user-password" ).val() ) }
      if( $( "#password-confirmation" ).val() !== "" ){ passwordMatch( $( "#password-confirmation" ).val() ) }
    });

    request.fail(function( jqXHR, textStatus ) {
      alert( "Request failed: " + textStatus );
    });

    enableButtonSubmit();
  }
}

function passwordValidation( password ){
  var regex = /^[a-zA-Z0-9!@#\$%\^\&*\)\(+=._-]{6,}$/g;
  if( password.match( regex ) ){
    $( "#user-password" ).addClass( "is-valid", );
    $( "#user-password" ).removeClass( "is-invalid" );
    $( "#password-confirmation" ).removeAttr( "disabled" );
  }else{
    $( "#user-password" ).addClass( "is-invalid" );
    $( "#user-password" ).removeClass( "is-valid" );
    if( $( "#password-confirmation" ).attr( "disabled" ) != "disabled" ){
      //add the attr disabled back
      $( "#password-confirmation" ).attr( "disabled", "disabled" );
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
console.log("Inside button submit");
  if( ( $( "#new-user-name" ).hasClass( "is-valid" ) &&
        $( "#user-password" ).hasClass( "is-valid" ) &&
        $( "#password-confirmation" ).hasClass( "is-valid"))
      ||
      ( $( "#user-name" ).hasClass( "is-valid" ) &&
        $( "#user-password" ).hasClass( "is-valid" ) ) ) {

    $( "#todo__registration--submit" ).removeAttr( "disabled" );
  }
    return;
}
