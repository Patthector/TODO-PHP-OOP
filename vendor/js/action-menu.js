'use strict';

$( document ).ready(function() {

  //EVENTS
  //========
  // 1-DELETE BUTTON ACTION MENU SELECTED
  $( document ).on( "click", "#collection-delete", function(e){
    collectionButtonClicked("#todo_collection-button-delete");
  });
  // 2-MOVE BUTTON ACTION MENU SELECTED

  //FUNCTION
  // 1-
  function collectionButtonClicked(id){
    $( id ).toggleClass("todo__btn-collection--selected");

    //SEND THE FEEDBACK TELLING THE USER TO SELECTED WHAT THEY WANT TO DELELTE
    // 2-DISABLE THE OTHER TOW BUTTONS THAT AREN'T BEEN USED
    collectionButtonDisabled(id);
    // 3-SHOW THE "CANCEL" BUTTON
    showButton();
  }
  // 2-
  function collectionButtonDisabled(id){
    //DISABLED EDIT
    if( !($("#todo_collection-button-edit").hasClass("todo__btn-collection--disabled")) ){
      $("#todo_collection-button-edit").addClass("todo__btn-collection--disabled");
    }

    if( id === "#todo_collection-button-move" ){
      if( !($("#todo_collection-button-delete").hasClass("todo__btn-collection--disabled")) ){
        $("#todo_collection-button-delete").addClass("todo__btn-collection--disabled");
      }
    } else{//THE BUTTON SELECTED WAS "#todo_collection-button-delete"
      if( !($("#todo_collection-button-move").hasClass("todo__btn-collection--disabled")) ){
        $("#todo_collection-button-move").addClass("todo__btn-collection--disabled");
      }
    }
  }
  // 3-deleteElementsAjax => send the information related with the elements we want to delete
  function deleteElementsAjax(){

  }
  // 4-selectingElementsBehavior() => set all the elements to be selected by the user
  function selectingCollectionElements(e){
    $(".todo__btn-clear").css("display","block").attr("href", window.location.href);
    //
    //$("#todo_collection-button-delete").addClass("collection-delete-elements--selected");
    var innerVal = $("#todo_collection-button-delete").html();
    $("#todo_collection-button-delete").remove();
    var parent = $(e.target).parent().parent();
    $( ".dropdown-menu" ).removeClass("show");
    $( parent ).append("<button class = \"todo__btn-collection--selected\">"+ innerVal +"</button>");

    // 1-Add the styles to all the elements to be clicked
		var url = window.location.href;
		// 2-which action we want to make
		var action = "selectElements";
	  // 3-which functions will be call
		var container = "first-container";

		$.ajax({
			url : url,
			data : {"action" : action},
			method : "GET",
			success : function(data){
        $(".first-container").remove();
				$("main").append(data);
			}
		});

    //2-FEEDBACK to the user encourage them to make the action
  }
  // AJAX DELETING ELEMENTS
  function actionCollectionElements(a){
    var id = $(".todo__collection-header-title").attr("id");
    var data = {"action":"deleteElements","id": id};
    for(var i = 0; i<a.length; i++){
      data[a[i]["name"]] = a[i]["value"];
    }
      console.log(data);
    // I need to know if I am working with the action = MOVE or the action = DELELTE
    // 2-which action we want to make
		var action = "deleteElements";
    // 1-Add the styles to all the elements to be clicked
		var url = window.location.href;
    $.ajax({
			url : url,
			data : data,
			method : "POST",
			success : function(data){
        console.log(data);
        $(".first-container").remove();
				$("main").append(data);
			}
		});

  }
  // 3-SHOWBUTTON is a function that will get a display:none button
  // and will show it changing the display:block
  function showButton(b){
    $( b ).css("display","block");
  }

  //LABEL SECTION
  $( document ).on("click",".checkbox-container", function(e){
    $(this).toggleClass("label--selected");
  });
  //DELETE ELEMENTS HAS BEEN SELECTED
  $( "#collection-delete" ).on("click", function(e){selectingCollectionElements(e)});
  // MOVE ELEMENTS HAS BEEN SELECTED
  $( "#collection-move" ).on("click", function(e){selectingCollectionElements(e)});

  //this class is added once the "selected items" is trigger. If it's clicked that means that
  //the user has selected some elements and wants to deleted.
  $(document).on("click", ".todo__btn-collection--selected", function(){

    var formVal = $("#delete-form").serializeArray();
    actionCollectionElements(formVal);

  });
















});//end of ready function
