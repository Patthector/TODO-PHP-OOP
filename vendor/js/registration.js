"use strict";

$( document ).ready( function(){

//LOGGING OUT THE USER
  $( "#todo__logout-button" ).on( "click",function( e ){ loggingOutUser(); });
  $( document ).on( "click", "#todo__registration--switch-sign-in", function( e ){ console.log("holis"); registrationSwitchAction( e.target.id ) });
  $( document ).on( "click", "#todo__registration--switch-new-user", function( e ){ registrationSwitchAction( e.target.id ) });

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
  exit;
}
