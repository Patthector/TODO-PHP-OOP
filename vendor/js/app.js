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


	$("#todo_edit_mode").on("click",function(e){
		// 1-hide all the static elements
		// 2-show all the input elements
		hideElements();
		showElements();
		disableElements();
	});
	$("#button_form_cancel").on("click",function(e){
		// 1-hide all the static elements
		// 2-show all the input elements
		hideElements();
		showElements();
		disableElements();
	});






    
    //hide all the static elements
    function hideElements(){

    	$(".editMode_off").toggle();
    	return;
    }

    //show all the input elements
    function showElements(){

    	$(".editMode_on").toggle();
    	return;
    }

    //disable elements
    function disableElements(){

    	$( ".editMode_on_disabled" ).toggleClass( "disabled" );    	
    	return;
    }

});

