;(function(factory){

  if (typeof define === 'function' && define.amd) {
      define(['jquery'], factory);
  } else if (typeof exports !== 'undefined') {
      module.exports = factory(require('jquery'));
  } else {
      factory(jQuery);
  }

})( function($){

  var ActionMenu = ( function(){

    function _ActionMenu(){

      //variable reference $actionMenu

      //variable reference body

      //object targets => 1- header, 2- main

      this.ajaxActionMenu = $.proxy( this.ajaxActionMenu, this );

    }
  }

  );



  ActionMenu.prototype.events = function(){
    //a lo mejor los parentesis de ajax estan de mas
    $("body")
        .on("click", "#collection-delete", {action:"selectionForDelete"},
    this.ajaxActionMenu())
        .on("click",  "#collection-move", {action:"selectionForMove"},
    this.ajaxActionMenu())
        .on("click", "#todo_collection-button-edit", {action:"editCollection"},
    this.ajaxActionMenu())
        .on("click", "#todo_todo-button-edit", {action:"editTodo"},
    this.ajaxActionMenu())
        .on("click", "#todo__action-menu-btn-clear", {action:"editTodo"},
    this.someFunction())
        .on("click", "#todo__btn-menu--cancel", {action:"editTodo"},
    this.someFunction())
        .on("click", "#todo__collection-button-delete", {action:"editTodo"},
    this.someFunction())
  }
/*
  1- Send the Ajax request to the DB
  2- Receive the response from the DB
*/
  ActionMenu.prototype.ajaxActionMenu = function(e){

    switch( true ){

      case ( e.currentTarget.data("action") === "selectionForDelete" ):
        //do something
        //send the selecting Template
      break;

      case ( e.currentTarget.data("action") === "selectionForMove" ):
        //do something
        //send the selecting Template
      break

      case ( e.currentTarget.data("action") === "editCollection" ):
        //do something
        //send the form template--collection
      break

      case ( e.currentTarget.data("action") === "editTodo" ):
        //do something
        //send the form template--todo
      break
    }
    return;
  };

  ActionMenu.prototype.detach = function( arrayElements ){
    //iterate for the elements/references to delete them

  };

  ActionMenu.prototype.attach = function( data, target ){
    //attach the data to its target

  };










});
