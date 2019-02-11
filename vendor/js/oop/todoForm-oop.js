;(function(factory){

  if (typeof define === 'function' && define.amd) {
      define(['jquery'], factory);
  } else if (typeof exports !== 'undefined') {
      module.exports = factory(require('jquery'));
  } else {
      factory(jQuery);
  }

})( function($){

  var TodoForm = ( function( element, settings ){

    function _TodoForm( element, settings ){

        this.$el = $( element );

        this.defaults = {
          chars_for_name: 50,
          chars_for_description: 500,
          name_value:"",
          description_value:""
        };

        this.formValidation = {
          _isValidName: false,
          _isValidDescription: false,
          _isValidSubmition: false
        };

        this.$obj = $.extend( {}, this, this.defaults, this.formValidation, settings );

        this.invokeAction = $.proxy( this.invokeAction, this );

        this.init();

      }
    return _TodoForm;

    })();

   TodoForm.prototype.init = function(){

     this.activate();

     this.events();
   };

   TodoForm.prototype.activate = function(){
     this._countChars( $( this.$obj.input_name ).val().length, this.$obj.span_name, this.$obj.chars_for_name, this.$obj.input_name );
     this._countChars( $( this.$obj.input_description ).val().length, this.$obj.span_description, this.$obj.chars_for_description, this.$obj.input_description );

     if( $(this.$obj.input_name).val().length > 0){
       console.log("we have a name");
       this.$obj._isValidName = true;
     }

     return;
   };

   TodoForm.prototype.events = function(){
     $("body")
            .on( "keyup", this.$obj.input_name, {action: "input_name"},
          this.invokeAction)
            .on( "keyup", this.$obj.input_description, {action: "input_description"},
          this.invokeAction)
            .on( "blur", this.$obj.input_name, {action: "leave_input_name"},
          this.invokeAction)
            .on( "blur", this.$obj.input_description, {action: "leave_input_description"},
          this.invokeAction)
            .on("submit", this.element_id, {action: "form_submition"}, this.invokeAction)
   };

    TodoForm.prototype.invokeAction = function(e){

      var action = (typeof e !== "undefined" ? e.data.action : undefined);

      switch(true){

        case (action === "input_name"):
          this._countChars( $(e.currentTarget).val().length, this.$obj.span_name, this.$obj.chars_for_name, this.$obj.input_name );
        break;

        case (action === "input_description"):
          this._countChars( $(e.currentTarget).val().length, this.$obj.span_description, this.$obj.chars_for_description, this.$obj.input_description );
        break;

        case (action === "leave_input_name"):
          $( this.$obj.input_name ).val( this._cleanHTML( $(this.$obj.input_name).val() ) );
          this._countChars( $( this.$obj.input_name ).val().length, this.$obj.span_name, this.$obj.chars_for_name, this.$obj.input_name  );
          this.$obj._isValidName = true;
        break;

        case (action === "leave_input_description"):
          $( this.$obj.input_description ).val( this._cleanHTML( $(this.$obj.input_description).val() ) );
          this._countChars( $( this.$obj.input_description ).val().length, this.$obj.span_description, this.$obj.chars_for_description, this.$obj.input_description  );
          this.$obj._isValidDescription = true;
        break;

        case (action === "form_submition"):
          this.formSubmitionValidation(e);
        break;
      }
      return;
    };

    TodoForm.prototype._countChars = function( totalChars, target, limit, input ){

      var rest = limit - totalChars;

      if( (rest >= 0) && (rest <= limit) ){
        $( target ).text(rest);
        this.$obj.name_value = $(input).val();
      }
      else{
        $( target ).text(0);
        this.$obj.name_value = $(input).val().substr(0,limit);
        $( input ).val(this.$obj.name_value);
      }
      return;
    };

    TodoForm.prototype._cleanHTML = function( string ){
      // convert any opening and closing braces to their HTML encoded equivalent.
    	var strClean = string.replace(/</gi, '&lt;').replace(/>/gi, '&gt;');
    	// Remove any double and single quotation marks.
    	strClean = strClean.replace(/"/gi, '').replace(/'/gi, '');
    	return strClean;
    };

    TodoForm.prototype.formSubmitionValidation = function(e){
      if( this.$obj._isValidName )
      {
        this.$obj._isValidSubmition = true;
      }
      else
      {
        e.preventDefault();
        console.log("Prevent default");
        this.$obj._isValidSubmition = false;
      }
      return this.$obj._isValidSubmition;
    };


    $.fn.TodoForm = function(options){
      return this.each(function(index,el){
        el.TodoForm = new TodoForm(el,options);
      });
    };

    $("#todo__library-form").TodoForm({
      element_id : "#todo__library-form",
      input_name: "#collection_name",
      input_description: "#collection_description",
      span_name: "#todo__library-form--chars-name span",
      span_description: "#todo__library-form--chars-description span"
    });
    $("#todo_todo-form").TodoForm({
      element_id : "#todo_todo-form",
      input_name: "#todo_name",
      input_description: "#todo_description",
      span_name: "#todo__todo-form--chars-name span",
      span_description: "#todo__todo-form--chars-description span"
    });
    console.log("FORM ON");

});
