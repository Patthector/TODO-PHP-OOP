"use strict";

/* when the button "EDIT MODE" is clicked
* 1- some elements on the DOM most be hidden (display:none)
* 2- the form with the releated inputs most be shown
* 3- the form should be fill with the values of the DOM available
*----------------------------------
* once the changes are made and the user is happy the TODO, the button
* SAVE should be clicked and the form will be submit with the new values.
*/
//TODO.js

$( document ).ready(function() {
	//LOGGING OUT THE USER
	  $( "#todo__logout-button" ).on( "click",function( e ){ loggingOutUser(); });

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
     //why dont i send the user to this page above via php?
   }
 });
 return;
}

function createTodoClicked(){
  window.location = "http://localhost/TODO-PHP-OOP/views/todo.php";

}
function createLibraryClicked(){
  window.location = "http://localhost/TODO-PHP-OOP/views/library.php";
}
