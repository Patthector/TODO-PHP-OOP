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

  //LOGIC EVENTS
	//============
	// 1-BUTTON-ADD-TAG
	$(document).on("click", "#todo__add-tag", function(e){
			e.preventDefault();
			var s = $(this).siblings("input");
			addTag(s.val());
			s.val("");
	});
	// 2-ENTER KEY TAG
	$(document).on("keypress", "#todo__input-tag", function(e){
		if(e.keyCode == 13 || e.which == 13){
			e.preventDefault();
			addTag(e.target.value);
			e.target.value = "";
		}
	});
	// 3-BUTTON REMOVE ALL TAGS
	$(document).on("click", "#todo__tag-remove-all",function(e){
		e.preventDefault();
		$( this ).animate({
			opacity:0.25
		},300,"linear", deleteAllTags());
	});
	// 4-TOGGLE TAG
	$(document).on("click", "#todo__tag-list .todo__tag-item",function(e){
		$( this ).toggleClass("selected");
		//checks if at least one li has the class .selected
		exitTagSelected();
	});
	// 5-BUTTON REMOVE
	$(document).on("click", "#todo__tag-remove", function(e){
		e.preventDefault();
		$( ".selected" ).remove();
		$( this ).addClass("disable");
	});
	// 6-SUBMIT BUTTON
	$(document).on("click", "#todo__todoform-submit",function(e){
		addingTagsToForm();
		//e.preventDefault();
	});

});//end of ready function
//AUXILIAR FUNCTIONS
//-------------------
// 1-WHITESPACE
function whiteSpaces(e){
	return e.trim().replace(/\s+/g, '');
}
// 2-CLEANER
function cleanhtml(e) {
	// convert any opening and closing braces to their HTML encoded equivalent.
	var strClean = e.replace(/</gi, '&lt;').replace(/>/gi, '&gt;');
	// Remove any double and single quotation marks.
	strClean = strClean.replace(/"/gi, '').replace(/'/gi, '');
	return strClean;
}
// 3-ADD-TAG-AUXILIAR
function addTagAux(s){
	$("#todo__tag-alert").remove();
	$(".todo__tags-container").css("display","block");
	$(".todo__tags-container ul").append("<li class = \"todo__tag-item\">#"+ s +"</li>");
	return;
}
// 4-INVALID-TAG-MESSAGE
function invalidTagMsg(){
	$(".todo__tags-input").append("<div id = \"todo__tag-alert\" class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">"+
																"<strong>Invalid tag</strong>"+
																"<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">"+
																"<span aria-hidden=\"true\">&times;</span></button></div>");
	return;
}
// 5-DELETING ALL TAGS
function deleteAllTags(){
	$("#todo__tag-list li").remove();
	$(".todo__tags-container").css("display","none");
	$("#todo__tag-remove-all").css("opacity",1);
	return;
}

//LOGIC FUNCTIONS
//==============
// 1-ADDING-TAG
function addTag(s){
	s = whiteSpaces(s);
	var aux = s;
	if(s){//not empty
		var clean_s = cleanhtml(aux);
		if(s.localeCompare(clean_s) == 0 ){
			addTagAux(s);
		} else{
			invalidTagMsg();
		}
	}
}
// 2-SELECTING TAGS
function exitTagSelected(){
	if( $("#todo__tag-list li").hasClass("selected") ){
		$("#todo__tag-remove").removeClass("disable");
		return;
	}
	else{
		if( !($("#todo__tag-remove").hasClass("disable")) ){
			$("#todo__tag-remove").addClass("disable");
		}
	}
	return;
};
// 3-ADDING TAGS TO THE FORM
function addingTagsToForm(){
	var tags = $("#todo__tag-list").children();
	var tagsArray = [];
	for(var i = 0; i < tags.length; i++){
		var val = tags[i].innerHTML;
		val = val.substring(1,val.length);//deleting #
		tagsArray[i] = val;
	}
	//append them to a the textarea
	var textarea = $("#todo_todo-tags-textarea");
	textarea.empty();
	var tagsString = tagsArray.join();
	textarea[0].innerHTML = tagsString;
	return;
};
