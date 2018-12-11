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
    //SEND THE FEEDBACK TELLING THE USER TO SELECTED WHAT THEY WANT TO DELELTE
    // 2-DISABLE THE OTHER TOW BUTTONS THAT AREN'T BEEN USED
    collectionButtonDisabled(id);
    // 3-SHOW THE "CANCEL" BUTTON
    showButton("#todo__btn-menu--cancel");
  }

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
  function rewind(){
    $("#todo__btn-menu--cancel").css("display","none");
    $("#todo__action-menu-btn-clear").css("display","none");
    //AND OTHER CHANGES
    //1-) send the action-menu to normality
    //2-) make and ajax request with an action=reReadCollection
    //ACTION-MENU
    var todo__action_menu_children = $("#todo__action-menu-list").children();
    for(var i = 0; i < todo__action_menu_children.length; i++){
      if( $(todo__action_menu_children[i]).hasClass("todo__btn-collection--disabled") ){//we are in edit
        $(todo__action_menu_children[i]).removeClass("todo__btn-collection--disabled");
      }
      else{//we get into the dropdown
        var li = $(todo__action_menu_children[i]).children()[0];
        var button = $(todo__action_menu_children[i]).children()[todo__action_menu_children.length-1];

        $(li).css("display","block");//show the li
        if( $(li).hasClass("todo__btn-collection--disabled") ){//we are in edit
          $(li).removeClass("todo__btn-collection--disabled");
        }
        if( $(button).attr("id") == "todo__collection-button-move"
         || $(button).attr("id") == "todo__collection-button-delete" ){
           $(button).css("display","none"); //hide the button
         }
      }
    }
    //AJAX REQUEST to REreadCollection
    var url = window.location.href;
    var action = "reReadCollection";
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
  }
  $( document ).on("click", "#todo__btn-menu--cancel", function(e){//bring things back to **NORMAL**
    rewind();
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
        var innerVal = $("#todo_collection-button-delete").html();
        $("#todo_collection-button-delete").css("display","none");
        var parent = $(e.target).parent().parent();
        $( ".dropdown-menu" ).removeClass("show");
        $( parent ).append("<button id = \"todo__collection-button-delete\" class = \"todo__btn-collection--selected\" data-toggle=\"modal\" data-target=\"#delete-todo-modal\">"+ innerVal +"</button>");
      }else{//MOVING
        var innerVal = $("#todo_collection-button-move").html();
        $("#todo_collection-button-move").css("display","none");
        var parent = $(e.target).parent().parent();
        $( ".dropdown-menu" ).removeClass("show");
        $( parent ).append("<button id = \"todo__collection-button-move\" class = \"todo__btn-collection--selected\" data-toggle=\"modal\" data-target=\"#move-todo-modal\">"+ innerVal +"</button>");
      }
    }
    // 1-Add the styles to all the elements to be clicked
		var url = window.location.href;
    var action = "selectElements";
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
  }
  // AJAX DELETING ELEMENTS
  function actionCollectionElements(a, id, fatherCollection = null){
    var id = $(".todo__collection-header-title").attr("id");
    var data = {};
    if(fatherCollection !== null){// => we are movingElements
      var action = "moveElements";
      data = {"action":action,"id": id, "fatherCollection":fatherCollection};
    }else{//=> we are deleteingElements
      var action = "deleteElements";
      data = {"action":action,"id": id};
    }
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
			},
      complete : function(jq,s){
        rewind();
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
