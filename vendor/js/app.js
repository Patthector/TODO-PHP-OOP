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
	//AUXILIAR FUNCTIONS
	//-------------------
	// 4-EDITING THE FORM THROUGH AJAX || EITHER TODO OR COLLECTION
	function editForm(e){
		// 1- Know the URL and the ID of the item
		var url = window.location.href;
		// 2-which action we want to make
			// 2.1- editTodo
			// 2.2-editCollection
		var action = "editItem";
	  // 3-which functions will be call
		var container = "first-container";

		$.ajax({
			url : url,
			data : {"action" : action},
			method : "GET",
			success : function(data){
				$("#logo-svg").empty();
				getBlueLogo();
				$("main").append(data);
			},
			complete : function(){
				$("#logo-svg").empty();
				$("header").addClass("white-header");
				$("footer").removeClass("footer-absolute");
				$("#action-menu").css("display","none");
				$(".first-container").css("display","none");
				$("#todo__tags-container").css("display","block");
			}
		});
	}
	// 5-GETTING THE BLUE LOGO
	function getBlueLogo(){
		$.ajax({
			url: "../inc/blue-logo.html",
			method: "GET"
		}).done(function(data){
			$("#logo-svg").append(data);
		}).fail(function(){
			console.log("FAILING");
		});
	}
	//------------
	//---- AJAX --
	//------------
	// 7-EDIT TODO FORM
	$(document).on("click", "#todo_todo-button-edit",function(e){
		editForm(e);
	});
	// 8-EDIT COLLECTION FORM
	$( document ).on("click", "#todo_collection-button-edit", function(e){
		editForm(e);
	});


	$("#todo__createtodo").on("click",function(e){
		createTodoClicked();
	});
	$("#todo__createlibrary").on("click",function(e){
		createLibraryClicked();
	});

	function createTodoClicked(){
		window.location = "http://localhost/TODO-PHP-OOP%20%5bwith%20JS%5d/views/todo.php";

	}
	function createLibraryClicked(){
		window.location = "http://localhost/TODO-PHP-OOP%20%5bwith%20JS%5d/views/library.php";
	}

});
