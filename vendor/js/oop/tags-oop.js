;(function(factory){

  if (typeof define === 'function' && define.amd) {
      define(['jquery'], factory);
  } else if (typeof exports !== 'undefined') {
      module.exports = factory(require('jquery'));
  } else {
      factory(jQuery);
  }

})( function($){

  var Tags = ( function( element ){

    function _Tags( element ){

      this.$el = element;

      this.buttons = {
        add_tag : "#todo__add-tag",
        remove_all : "#todo__tag-remove-all",
        remove : "#todo__tag-remove"
      };

      this.components = {
        input : "#todo__input-tag",
        form : "#todo__todoform-submit",
        items : ".todo__tag-item",
        list : "#todo__tag-list",
        textarea : "#todo_todo-tags-textarea"
      };

      this.object = $.extend( {}, this, this.buttons, this.components );
      this.invokeAction = $.proxy( this.invokeAction, this );
      this.init();

    }
    return _Tags;

  } )();

  Tags.prototype.init = function(){

    this.activate();

    this.events();

  };

  Tags.prototype.activate = function(){
    // Duty: show or hide the tag's box if:
        // SHOW => we have list elements
        // HIDE => we have an empty list
    this.showContainer();
    return;

  };

  Tags.prototype.events = function(){
    $("body")
          .on( "click", this.object.add_tag, { action: "add_tag" },
        this.invokeAction )
          .on( "keypress", this.object.input, { action: "input_enter"},
        this.invokeAction )
          .on( "click", this.object.remove_all, { action: "button_remove_all"},
        this.invokeAction )
          .on( "click", this.object.items , { action: "toggle_items" },
        this.invokeAction )
          .on( "click", this.object.remove, { action: "button_remove" },
        this.invokeAction )
          .on( "submit", this.object.form, { action: "submit_form"},
        this.invokeAction )
  };

  Tags.prototype.invokeAction = function(e){

    var action = (typeof e !== "undefined" ? e.data.action : undefined );

    switch( true ){

      case (action === "add_tag"):
        e.preventDefault();
        this.prepareTag( $( this.object.input ).val() );
        $( this.object.input ).val("");
      break;

      case (action === "input_enter"):
        if(e.keyCode == 13 || e.which == 13){
          e.preventDefault();
          this.prepareTag( e.currentTarget.value );
          e.currentTarget.value = "";
        }
      break;

      case (action === "button_remove_all"):
        e.preventDefault();
        this.deleteAllTags();
      break;

      case (action === "toggle_items"):
        $( e.currentTarget ).toggleClass( "selected" );
        this.toggleListItems();
      break;

      case (action === "button_remove"):
        e.preventDefault();
        this.deleteSelectedTags();
      break;

      case (action === "submit_form"):
        this.attachTagsToTextarea();
      break;
    }

    this._updateObject();
    return;
  };

  Tags.prototype.prepareTag = function( tag ){
    this._cleanFeedback( this.object.input );
    tag = this._whiteSpaces( tag );
    var aux = tag;

    if( tag ) {// NOT EMPTY
      var cleanTag = this._cleanHTML( aux );

      if( tag.localeCompare( cleanTag ) === 0 ){
        this.addTag( tag );

      } else{
        // invalid tag. Give a feedback to the user
        // .is-invalid
        $( this.object.input ).addClass( "is-invalid" );
      }
    } else{
      $( this.object.input ).addClass( "is-invalid" );
    }

    return;
  };

  Tags.prototype.addTag = function( tag ){
    //cleanFeedback
    //add .is-valid
    $( this.object.list ).append("<li class = \"todo__tag-item\">#"+ tag +"</li>");
    return;
  };

  Tags.prototype.deleteAllTags = function(){
    var $t = this;
    $( $t.object.items ).animate({
      opacity: .5
    }, 300, "linear", function(){

      $( $t.object.list ).empty();
      $t._updateObject();
    });

    return;
  };

  Tags.prototype.deleteSelectedTags = function(){

    $( ".selected" ).fadeOut().remove();
    $( this.object.remove ).addClass( "disable" );

    return;
  };

  Tags.prototype.toggleListItems = function(){
    if( $( this.object.items ).hasClass( "selected" ) ){
  		$( this.object.remove ).removeClass( "disable" );
  		return;
  	}
  	else{
  		if( !( $( this.object.remove ).hasClass( "disable" ) ) ){
  			$( this.object.remove ).addClass( "disable" );
  		}
  	}
  	return;
  };

  Tags.prototype.showContainer = function(){
    console.log( $( this.object.items ).length );
    if( $( this.object.items ).length > 0 ){
      console.log("We have list-elements");
      $(this.$el).css("display","block");

    } else{
      console.log("There are not list-elements");
      $(this.$el).css("display","none");

    }
    return;

  }

  Tags.prototype.attachTagsToTextarea = function(){

    var tags = $( this.object.list ).children();
  	var tagsArray = [];
  	for(var i = 0; i < tags.length; i++){
  		var val = tags[i].innerHTML;
  		val = val.substring(1,val.length);//deleting #
  		tagsArray[i] = val;
  	}
  	//append them to a the textarea
  	var textarea = $( this.object.textarea );
  	textarea.empty();
  	var tagsString = tagsArray.join();
  	textarea[0].innerHTML = tagsString;

  	return;
  };

  Tags.prototype._cleanHTML = function( string ){
    // convert any opening and closing braces to their HTML encoded equivalent.
  	var strClean = string.replace(/</gi, '&lt;').replace(/>/gi, '&gt;');
  	// Remove any double and single quotation marks.
  	strClean = strClean.replace(/"/gi, '').replace(/'/gi, '');
  	return strClean;
  };

  Tags.prototype._whiteSpaces = function( string ){
    return string.trim().replace( /\s+/g, '' );
  };

  Tags.prototype._updateObject = function(){
    this.showContainer();
    return;
  };

  Tags.prototype._cleanFeedback = function( id ){
    if( $( id ).hasClass( "is-valid" ) )$( id ).removeClass( "is-valid" );
    if( $( id ).hasClass( "is-invalid" ) )$( id ).removeClass( "is-invalid" );
    return;
  };

  $.fn.Tags = function(options){
    return this.each(function(index,el){
      el.Tags = new Tags(el,options);
    });
  };




$("#todo__tags-container").Tags();
console.log("TAGS ON");


});
