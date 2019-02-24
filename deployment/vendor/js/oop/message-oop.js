;(function(factory){

  if (typeof define === 'function' && define.amd) {
      define(['jquery'], factory);
  } else if (typeof exports !== 'undefined') {
      module.exports = factory(require('jquery'));
  } else {
      factory(jQuery);
  }

})( function($){

  var Message = (function(element){

    function _Message(element){

      this.$el = element;

      this.init();
    }

    return _Message;

  })();

  Message.prototype.init = function(){

    setTimeout( function(){
      this.displayMessage();
    }.bind( this ), 100 );

    setTimeout( function(){
      this.cleanMessage();

    }.bind( this ), 10000 );

    return;
  };

  Message.prototype.cleanMessage = function(){
    $r = this;
    $( this.$el ).fadeOut( 1000, function(){
      $( $r.$el ).remove();
    } );
    return;
  }

  Message.prototype.displayMessage = function(){
    $( this.$el ).fadeIn( 500 ).addClass( "todo__message--transition" );
    return;
  }

  $.fn.Message = function(options){
    return this.each(function(index,el){
      el.Message = new Message(el,options);
    });
  };

  $( "#todo__message" ).Message();
  console.log("MESSAGE ON");
});
