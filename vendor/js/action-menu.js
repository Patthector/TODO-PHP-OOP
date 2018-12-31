'use strict';

$( document ).ready(function() {
  //EVENTS
  //========
  // 1-DELETE BUTTON ACTION MENU SELECTED
  $( document ).on( "click", "#collection-delete", function(e){
    $( "#todo_collection-button-delete" ).addClass( "todo__action_menu_btn--selected" );
    collectionButtonClicked("#todo_collection-button-delete");
  });
  // 2-MOVE BUTTON ACTION MENU SELECTED
  $( document ).on( "click", "#collection-move", function(e){
    $( "#todo_collection-button-move" ).addClass( "todo__action_menu_btn--selected" );
    collectionButtonClicked("#todo_collection-button-move");
  });
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
    if( !($("#todo_collection-button-create").hasClass("todo__btn-collection--disabled")) ){
      $("#todo_collection-button-create").addClass("todo__btn-collection--disabled");
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
  // 3-SHOWBUTTON is a function that will get a display:none button
  // and will show it changing the display:block
  function showButton(b){
    $( b ).css("display","block");
  }
  function rewind(){
    $("#todo__btn-menu--cancel").css("display","none");
    $("#todo__action-menu-btn-clear").css("display","none");
    $("#todo__collection-button-delete").remove();
    $("#todo__collection-button-move").remove();
    //AND OTHER CHANGES
    //1-) send the action-menu to normality
    //2-) make and ajax request with an action=reReadCollection
    //ACTION-MENU
    $( ".todo__btn-collection--disabled" ).removeClass("todo__btn-collection--disabled");
    $( ".todo__action_menu_btn--selected" ).css( "display","block ");
    $( ".todo__action_menu_btn--selected" ).removeClass( "todo__action_menu_btn--selected" );

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
        deletingMessageBox( "#todo__message" );
      }
    });
  }

// 4-selectingElementsBehavior() => set all the elements to be selected by the user
function selectingCollectionElements(e){
  $(".todo__btn-clear").css("display","block");
  $( ".todo__btn-clear" ).on( "click", function(e){
    //diselect all the checkboxes selected
    $( ".label--selected" ).removeClass( "label--selected" );
  } );
  if(e.target.tagName === "BUTTON"){
    if(e.target.id === "collection-delete"){//DELETING
      var innerVal = $("#todo_collection-button-delete").html();
      $("#todo_collection-button-delete").css("display","none");
      var parent = $(e.target).parent().parent();
      $( ".dropdown-menu" ).removeClass("show");
      $( parent ).append("<button id = \"todo__collection-button-delete\" class = \"todo__btn-collection todo__btn-collection--selected\" data-toggle=\"modal\" data-target=\"#delete-todo-modal\">"+ innerVal +"</button>");
    }
    else{//MOVING
      var innerVal = $("#todo_collection-button-move").html();
      $("#todo_collection-button-move").css("display","none");
      var parent = $(e.target).parent().parent();
      $( ".dropdown-menu" ).removeClass("show");
      $( parent ).append("<button id = \"todo__collection-button-move\" class = \"todo__btn-collection todo__btn-collection--selected\" data-toggle=\"modal\" data-target=\"#move-todo-modal\">"+ innerVal +"</button>");
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
      deletingMessageBox( "#todo__message" );
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
