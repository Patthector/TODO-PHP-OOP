'use strict';

$( document ).ready(function() {

  //EVENTS
  //========
  // 1-DELETE BUTTON ACTION MENU SELECTED
  $( document ).on( "click", "#collection-delete", function(e){
    console.log("DELETE");
    collectionButtonClicked("#todo_collection-button-delete");

  });
  // 2-MOVE BUTTON ACTION MENU SELECTED
  $( document ).on( "click", "#collection-move", function(e){
    collectionButtonClicked("#todo_collection-button-move");
    console.log("MOVE");
  });
  //FUNCTION
  // 1-
  function collectionButtonClicked(id){
    $( id ).toggleClass("todo__btn-collection--selected");

    //SEND THE FEEDBACK TELLING THE USER TO SELECTED WHAT THEY WANT TO DELELTE
    // 2-DISABLE THE OTHER TOW BUTTONS THAT AREN'T BEEN USED
    collectionButtonDisabled(id);
    // 3-SHOW THE "CANCEL" BUTTON
    showButton("#todo__btn-menu--cancel");
  }
  // 2-
  function collectionButtonDisabled(id){
    //DISABLED EDIT
    if( !($("#todo_collection-button-edit").hasClass("todo__btn-collection--disabled")) ){
      $("#todo_collection-button-edit").addClass("todo__btn-collection--disabled");
    }

    if( id == "#todo_collection-button-move" ){
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
  // 3-SHOWBUTTON is a function that will get a display:none button
  // and will show it changing the display:block
  function showButton(b){
    $( b ).css("display","block");
  }
  $( document ).on("click", "#todo__btn-menu--cancel", function(e){
    $(this).css("display","none");
    //AND OTHER CHANGES
  });

  //LABEL SECTION
  $( document ).on("click",".checkbox-container", function(e){
    $(this).toggleClass("label--selected");
  });
  //DELETE ELEMENTS HAS BEEN SELECTED
  $( "#collection-delete" ).on("click", function(e){selectingCollectionElements(e)});
  // MOVE ELEMENTS HAS BEEN SELECTED
  $( "#collection-move" ).on("click", function(e){selectingCollectionElements(e)});

  // 4-selectingElementsBehavior() => set all the elements to be selected by the user
  function selectingCollectionElements(e){
    $(".todo__btn-clear").css("display","block").attr("href", window.location.href);
    //console.log(e.target.id);
    if(e.target.tagName === "BUTTON"){
      if(e.target.id === "collection-delete"){//DELETING
        $("#todo_collection-button-delete").addClass("collection-delete-elements--selected");
        var innerVal = $("#todo_collection-button-delete").html();
        $("#todo_collection-button-delete").remove();
        var parent = $(e.target).parent().parent();
        $( ".dropdown-menu" ).removeClass("show");
        $( parent ).append("<button id = \"todo__collection-button-delete\" class = \"todo__btn-collection--selected\" data-toggle=\"modal\" data-target=\"#delete-todo-modal\">"+ innerVal +"</button>");
      }else{//MOVING
        $("#todo_collection-button-move").addClass("collection-move-elements--selected");
        var innerVal = $("#todo_collection-button-move").html();
        $("#todo_collection-button-move").remove();
        var parent = $(e.target).parent().parent();
        $( ".dropdown-menu" ).removeClass("show");
        $( parent ).append("<button id = \"todo__collection-button-move\" class = \"todo__btn-collection--selected\" data-toggle=\"modal\" data-target=\"#move-todo-modal\">"+ innerVal +"</button>");
      }
    }
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
        $("#move-todo-modal").remove();
        $("#delete-todo-modal").remove();
        $("main").append(data);
			}
		});

    //2-FEEDBACK to the user encourage them to make the action
  }
  // AJAX DELETING ELEMENTS
  function actionCollectionElements(a, id, fatherCollection = null){
    var id = $(".todo__collection-header-title").attr("id");
    if(fatherCollection !== null){// => we are movingElements
      var action = "moveElements";
      var data = {"action":action,"id": id, "fatherCollection":fatherCollection};
    }else{//=> we are deleteingElements
      var action = "deleteElements";
      var data = {"action":action,"id": id};
    }
    /*if(id === "#todo_collection-button-move"){
      var action = "moveElements";
    }else{//#todo_collection-button-delete
      var action = "deleteElements";
    }
    var data = {"action":action,"id": id};*/
    for(var i = 0; i<a.length; i++){
      data[a[i]["name"]] = a[i]["value"];
    }
    // I need to know if I am working with the action = MOVE or the action = DELELTE
    // 2-which action we want to make

    // 1-Add the styles to all the elements to be clicked
		var url = window.location.href;
    $.ajax({
			url : url,
			data : data,
			method : "POST",
			success : function(data){
        $(".first-container").remove();
				$("main").append(data);
			}
		});
  }

  //this class is added once the "selected items" is trigger. If it's clicked that means that
  //the user has selected some elements and wants to deleted.
  $(document).on("click", "#todo__modal-btn-submit", function(e){

    if(e.target.tagName === "BUTTON"){
      var formVal = $("#delete-form").serializeArray();
      if( $(e.target).text() == "Move" ){// => moving selectedElements
        var fatherCollection = $("#todo__modal-move-select").val();//this is the ID of the selected collection
        actionCollectionElements(formVal, e.target.id, fatherCollection);
      }else{
        actionCollectionElements(formVal, e.target.id);
      }
    }
  });
















});//end of ready function
