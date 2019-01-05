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
        main : this.$main
      };
      this.$obj = $.extend( {}, this, this.targets, settings );


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
        .on("click",  ".checkbox-container",
        function(e){ $(e.currentTarget).toggleClass("label--selected"); })
        .on("click", "#todo__action-menu-btn-clear", {action:"clearSelection"},
    this.ajaxActionMenu)
        .on("click", "#todo__btn-menu--cancel", {action:"cancelSelection"},
    this.ajaxActionMenu)
        .on("click", "#todo__move-modal-btn-submit",{action:"modal-move"},
    this.ajaxActionMenu)
        .on("click", "#todo__delete-modal-btn-submit",{action:"modal-delete"},
    this.ajaxActionMenu)

  }
/*
  1- Send the Ajax request to the DB
  2- Receive the response from the DB
*/
  ActionMenu.prototype.ajaxActionMenu = function(e){
    var menu_action = ( typeof e !== "undefined" ? e.data["action"]: "undefined" );
    var $am = this;
    switch( true ){

      case ( menu_action === "selectionForDelete" ):
        this._AJAXsetter(menu_action, "selectElements");
      break;

      case ( menu_action === "selectionForMove" ):
        this._AJAXsetter(menu_action, "selectElements");
      break

      case ( menu_action === "clearSelection" ):
        $( "."+this.$obj.clearSelectionClass ).removeClass( this.$obj.clearSelectionClass );
      break

      case ( menu_action === "cancelSelection" ):
        this._AJAXsetter(menu_action, "reReadCollection");
      break

      case ( menu_action === "modal-move" ):
        //set var modal-move = true;
        //_formingData();
      break

      case ( menu_action === "modal-delete" ):

      break
    }
    return;
  };

  ActionMenu.prototype._AJAXsetter = function( menu_action, main_action, method="GET"){
    var $am = this;
    //1-detach the action menu && the main content
    this.detach({
      detachViaEmpty: $am.$main,
      detachViaDelete: $am.$el
    });
    //2-make the AJAX call--for main
    this.AJAXloader({
      method: method,
      data: { action: main_action },
      success: function(data){
        $am.attach({
          attachViaAppend: data
        });
      }
    });
    //3-make the AJAX call--for action-menu
    this.AJAXloader({
      url: "./actionMenu.php",
      data: { action: menu_action },
      success: function(data){
          $am.attach({
          attachViaAfter: data
        });
        //$am.updateActionMenu();
      }
    });

    return;
  }

  ActionMenu.prototype.AJAXloader = function( ajaxObj ){
    $.ajax(ajaxObj);
    return;
  };

  ActionMenu.prototype._formingData = function( menu_action, modal_move = false){
    /*
    // NEED SOME WORK HERE!!
    */
    var arrayForm = $("#delete-form").serializeArray();
    var id = $(".todo__collection-header-title").attr("id");
    var data = {};
    if(modal_move){
      var fatherCollection = $("#todo__modal-move-select").val();
      var action = "moveElements";
      data = {"action":action,"id": id, "fatherCollection":fatherCollection};
    }
    else{
      var action = "deleteElements";
      data = {"action":action,"id": id};
    }
    for(var i = 0; i<a.length; i++){
      data[a[i]["name"]] = a[i]["value"];
    }

    //this._AJAXsetter( menu_action, );

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
      }
    }
    //after you attach anything you should update your object
    this.updateActionMenu();
    return;
  };
  ActionMenu.prototype._attachViaAppend = function( data ){
    $(this.$obj.targets.main).append( data );
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
  consequenceResponse: "main"
});

console.log("Ciao a tutti");

});
