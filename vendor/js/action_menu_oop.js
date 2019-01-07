;(function(factory){

  if (typeof define === 'function' && define.amd) {
      define(['jquery'], factory);
  } else if (typeof exports !== 'undefined') {
      module.exports = factory(require('jquery'));
  } else {
      factory(jQuery);
  }

})( function($){

  var ActionMenu = ( function( element, settings ){

    function _ActionMenu( element, settings ){
      //variable $actionMenu // id
      this.el_id = element;
      //variable reference $actionMenu
      this.$el = $(element);
      //variable reference body == main
      this.$main = $("main");

      //object targets => 1- header, 2- main
      this.targets = {
        header : $("header"),
        main : this.$main,
        body : $("#main")
      };
      this.$obj = $.extend( {}, this, this.targets, settings );

      /*
        ___Form Ghost Obj___
          *form ghost is a display:none form that will hold all the information
          *related with the selected elements for move/delete actions
      */
      this.$formGhost = $(this.$obj.formGhostId);
      console.log(this.$formGhost);
      this.ajaxActionMenu = $.proxy( this.ajaxActionMenu, this );
      this.init();
    }
    return _ActionMenu;
  })();

  ActionMenu.prototype.init = function(){

    this.events();
  }

  ActionMenu.prototype.events = function(){
    //a lo mejor los parentesis de ajax estan de mas
    $("body")
        .on("click", "#collection-delete", {action:"selectionForDelete"},
    this.ajaxActionMenu)
        .on("click",  "#collection-move", {action:"selectionForMove"},
    this.ajaxActionMenu)
        .on("click",  "#todo_collection-button-edit", {action:"editCollection"},
    this.ajaxActionMenu)
        .on("click",  ".checkbox-container",
        function(e){ $(e.currentTarget).toggleClass("label--selected"); })
        .on("click", "#todo__action-menu-btn-clear", {action:"clearSelection"},
    this.ajaxActionMenu)
        .on("click", "#todo__btn-menu--cancel", {action:"cancelSelection"},
    this.ajaxActionMenu)
        .on("click", "#todo__delete-modal-btn-submit",{action:"modal-delete"},
    this.ajaxActionMenu)
        .on("click", "#todo__move-modal-btn-submit", {action:"modal-move"},
        this.ajaxActionMenu)
/*
    $("#todo__move-modal-btn-submit").bind("click",{action:"modal-move"},
    this.ajaxActionMenu);*/

  }
/*
  1- Send the Ajax request to the DB
  2- Receive the response from the DB
*/
  ActionMenu.prototype.ajaxActionMenu = function(e){

    var menu_action = ( typeof e !== "undefined" ? e.data["action"]: "undefined" );
    var $am = this;

    switch( true ){
      case ( (menu_action === "selectionForDelete" || menu_action === "selectionForMove" ) ):
        var ajaxObjMenu = {
            url: "./actionMenu.php",
            method: "GET",
            data: { action: menu_action }
          };
        var ajaxObjMain = {
          url: "",
          method: "GET",
          data: { action: "selectElements" }
        };
        this.invokeAction( ajaxObjMenu, ajaxObjMain );
      break;

      case ( menu_action === "editCollection" ):
        var ajaxEditObj = {
          url: "",
          method: "GET",
          data: { action: "editCollection" }
        };
        this._specialActionEdit(ajaxEditObj);
      break;

      case ( menu_action === "clearSelection" ):
        $( "."+this.$obj.clearSelectionClass ).removeClass( this.$obj.clearSelectionClass );
      break

      case ( menu_action === "cancelSelection" ):
        var ajaxObjMenu = {
            url: "./actionMenu.php",
            method: "GET",
            data: { action: menu_action }
          };
        var ajaxObjMain = {
          url: "",
          method: "GET",
          data: { action: "reReadCollection" }
        };
        this.invokeAction( ajaxObjMenu, ajaxObjMain );
      break

      case ( menu_action === "modal-move" ):
        var ajaxObjMenu = {
            url: "./actionMenu.php",
            method: "GET",
            data: { action: menu_action }
          };
        var ajaxObjMain = {
          url: "",
          method: "POST",
          data: $am._formingData({
            action: "moveElements",
            fatherCollection: $("#todo__modal-move-select").val()
          })
        };
        this.invokeAction( ajaxObjMenu, ajaxObjMain );
      break

      case ( menu_action === "modal-delete" ):
        var ajaxObjMenu = {
            url: "./actionMenu.php",
            method: "GET",
            data: { action: menu_action }
          };
        var ajaxObjMain = {
          url: "",
          method: "POST",
          data: $am._formingData({
            action: "deleteElements"
          })
        };
        this.invokeAction( ajaxObjMenu, ajaxObjMain );
      break
    }
    return;
  };

  ActionMenu.prototype.invokeAction = function( ajaxObjMenu, ajaxObjMain ){
    var $am = this;
    //1-DETACH the action menu && the main content
    this.detach({
      detachViaEmpty: this.$main,
      detachViaDelete: this.$el
    });
    //2-AJAX call
    $.when( $am._AJAXsetter( ajaxObjMenu ),$am._AJAXsetter( ajaxObjMain ) )
     .done(
   //3-ATTACH the response
        function( _AJAXresponseActionMenu, _AJAXresponseActionMain ){
          $am.attach({ attachViaAppend: _AJAXresponseActionMain[0] });
          $am.attach({ attachViaAfter: _AJAXresponseActionMenu[0] });
    //4-UPDATE MAIN OBJ [ACTIONMENU]
    //after you attach anything you should update your object
          $am.updateActionMenu();
      }
    );
    return;
  }
  ActionMenu.prototype._AJAXsetter = function( ajaxObj ){
    //1-url, 2-method, 3-data {}
    return $.ajax({
      url : ajaxObj.url,
      method: ajaxObj.method,
      data: ajaxObj.data
                        });
  }

  ActionMenu.prototype._specialActionEdit = function( ajaxObjEdit ){
    var $am = this;
    //1-DETACH the action menu && the main content
    this.detach({
      detachViaEmpty: $("#main")
    });
    //2-AJAX call
    $.when( $am._AJAXsetter( ajaxObjEdit ) )
     .done(
   //3-ATTACH the response
        function( _AJAXresponseEdited ){
          console.log(_AJAXresponseEdited);
          $am.attach({ attachViaAppendBody: _AJAXresponseEdited });
    //4-UPDATE MAIN OBJ [ACTIONMENU]
    //after you attach anything you should update your object
          $am.updateActionMenu();
      }
    );
    return;
  };

  ActionMenu.prototype.AJAXloader = function( ajaxObj ){
    $.ajax(ajaxObj);
    return;
  };

  ActionMenu.prototype._formingData = function( data ){

    var arrayForm = this.$formGhost.serializeArray();

    for(var i = 0; i < arrayForm.length; i++){
      data[arrayForm[i]["name"]] = arrayForm[i]["value"];
    }

    return data;
  };

  ActionMenu.prototype.detach = function( obj ){
    //iterate for the elements/references to delete them
    // Two ways for detaching
    // 1-leave the target element, but .empty() the inside
    // 2-delete the entire target element
    for( var i in obj ){
      switch(true){
        case( i === "detachViaDelete" ):
          this._detachViaDelete( obj[i] );
        break;

        case( i === "detachViaEmpty" ):
          this._detachViaEmpty( obj[i] );
        break;
      }
    }
    return;
  };

  ActionMenu.prototype._detachViaDelete = function( element ){
    $(element).remove();
    return;
  }
  ActionMenu.prototype._detachViaEmpty = function( element ){
    $(element).empty();
    return;
  }

  ActionMenu.prototype.attach = function( obj ){
    //attach the data to its target
    for( var i in obj ){
      switch(true){
        case( i === "attachViaAppend" ):
          this._attachViaAppend( obj[i] );
        break;

        case( i === "attachViaAfter" ):
          this._attachViaAfter( obj[i] );
        break;

        case( i === "attachViaAppendBody" ):
          this._attachViaAppend( obj[i], this.$obj.targets.body );
        break;
      }
    }
    return;
  };
  ActionMenu.prototype._attachViaAppend = function( data, target = this.$obj.targets.main ){
    $(target).append( data );
    return;
  }
  ActionMenu.prototype._attachViaAfter = function( data ){
    $(this.$obj.targets.header).after( data );
    return;
  }

  ActionMenu.prototype.updateActionMenu = function(){
    //variable reference $actionMenu
    this.$el = $(this.$obj.actionMenuId);
    //variable reference body == main
    this.$main = $(this.$obj.consequenceResponse);
    //variable reference form ghost
    this.$formGhost = $(this.$obj.formGhostId);
    return;
  };

  $.fn.ActionMenu = function(options){
    return this.each(function(index,el){
      el.ActionMenu = new ActionMenu(el,options);
    });
  };

  $("#action-menu").ActionMenu({
    clearSelectionClass: "label--selected",
    actionMenuId: "#action-menu",
    consequenceResponse: "main",
    formGhostId: "#delete-form",

  });

  console.log("Ciao a tutti");

});
