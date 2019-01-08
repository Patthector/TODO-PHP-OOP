;(function(factory){

  if (typeof define === 'function' && define.amd) {
      define(['jquery'], factory);
  } else if (typeof exports !== 'undefined') {
      module.exports = factory(require('jquery'));
  } else {
      factory(jQuery);
  }

})( function($){

  //ZIPPY obj
  var Zippy = ( function( element, settings ){

    var instanceUid = 0;

    function _Zippy( element, settings ){

      this.defaults = {
        slideDuration : "3000",
        speed : 500,
        arrowRight : "arrow-right",
        arrowLeft : "arrow-left"
      };

      this.innerSettings = {
        width_currSlide : 0,
        leftCoordenate : 0,
        width_inner : 0,
        width_carousel : 0,
        width_prevSlide : 0,
        move_carousel: false
      };

      this.settings = $.extend( {}, this, this.defaults, this.innerSettings, settings );

      this.initials = {
        currSlide : 0,
        $currSlide : null,
        totalSlides : false,
        csstransitions : false
      };

      $.extend( this, this.initials );

      this.$el = $(element);
      this.el = element;
      var formation = "#" + this.el.id + " .todo__inner--carousel";
      this.$inner = $(formation);

      this.changeSlide = $.proxy( this.changeSlide, this );

      this.init();

      this.inistanceUid = instanceUid++;

    }

    return _Zippy;

  })();

  Zippy.prototype.init = function(){

    this.csstransitionsTest();

    this.$el.addClass( "zippy-carousel" );

    this.build();

    this.events();

    this.activate();// <<-- we may not need this func

    this.showArrows();

    //this.initTimer();
  };

  Zippy.prototype.csstransitionsTest = function(){

    var elem = document.createElement("modernizr");
     var props =
     [ "transition", "WebkitTransition","MozTransition","OTransition","msTransition" ];

     for( var i in props ){
       var prop = props[i];
       var result = elem.style[prop] != undefined ? prop : false;
       if( result ){
         this.csstransitions = result;
         break;
       }
     }
  };

  Zippy.prototype.addCSSDuration = function(){
    var _ = this;
    this.$el.find(".slide").each(function(){
      this.style[_.csstransitions+"Duration"] = _.settings.speed+"ms";
    });
  };

  Zippy.prototype.removeCSSDuration = function(){
    var _ = this;
    this.$el.find(".slide").each(function(){
      this.style[_.csstransitions+"Duration"] = "";
    });
  };

  Zippy.prototype.build = function(){

    this.settings.width_currSlide = this.$el.find(".slide").eq(this.currSlide).width();
    this.settings.width_carousel = this.$el.width();
    this.settings.width_inner = this.$inner.width();

  };

  Zippy.prototype.activate = function(){
    //this.$currSlide = this.$el.find(".slide").eq(0);
    //this.$el.find(".indicators li").eq(0).addClass("active");
  };

  Zippy.prototype.events = function(){
    $("body")
      .on( "click", this.settings.arrowRight,
    { direction:"right" }, this.changeSlide)
      .on( "click", this.settings.arrowLeft,
    { direction:"left" }, this.changeSlide)
      .on( "click", ".indicators li", this.changeSlide);
  };

  Zippy.prototype.showArrows = function(){
    // 1- get the ul width
    // 2- get the inner div width
    // 3- compare the two of them
        // 3.1- if ||==>> inner is bigger, that mean we need to use the carousel
        // 3.2- else ||==>> innner is smalles and we need to hide the arrows
    ////
    var inner__class = "#" + this.el.id + " .todo__inner--carousel";
    var arrowLeft = "#" + this.el.id;
    arrowLeft = $(arrowLeft).siblings( this.settings.arrowLeft );
    var arrowRight = "#" + this.el.id;
    arrowRight = $(arrowRight).siblings( this.settings.arrowRight );

    if( this.settings.width_carousel >= this.settings.width_inner ){
      $( arrowLeft ).css("display","none");
      $( arrowRight ).css("display","none");
    } else{
      $( arrowLeft ).css("display","block");
      $( arrowRight ).css("display","block");
    }

    return;
  }

  Zippy.prototype.startTimer = function(){
    //this.initTimer();
    this.throttle = false;//<<------ OCHIO
  };

  Zippy.prototype.changeSlide = function(e){

    if(this.throttle) return;
    this.throttle = true;

    var direction = this._direction(e);

    this.settings.width_currSlide = this.$el.find(".slide").eq(this.currSlide).width();
    if( this.currSlide > 0 ){
      var aux = this.currSlide-1;
      this.settings.width_prevSlide = this.$el.find(".slide").eq(aux).width();
    }

    var animate = this._next( e,direction );
    if(!animate) return;

    if(!this.csstransitions){
      this._jsAnimation(direction);
    } else {
      this._cssAnimation(direction);
    }
  };

  Zippy.prototype._direction = function(e){
    var direction;

    if(typeof e !== "undefined"){
      direction = (typeof e.data === "undefined" ? "right" : e.data.direction );
    } else {
      direction = "right";
    }
    return direction;
  };

  Zippy.prototype._canMove = function(direction){
    if( direction === "left"){
      return this.currSlide > 0;
    } else if( direction === 'right'){
        return (this.settings.leftCoordenate + this.settings.width_inner) > this.settings.width_carousel;
    }
    return false;
  }
  Zippy.prototype._next = function(e,direction){

    switch( true ){

      case( (this._canMove(direction)) && direction == "right" ):
        this.settings.move_carousel = true;
        this.currSlide++;console.log("current Slide",this.currSlide);
        break;

      case( (this._canMove(direction)) && direction == "left"):
        this.currSlide--;
        this.settings.move_carousel = true;console.log("true",this.currSlide);
        break;

      default:
        this.settings.move_carousel = false;console.log("false",this.currSlide);
      break;

    }
    return true;
  };

  Zippy.prototype._moveCarousel = function( direction ){

    if( this.settings.move_carousel && direction == "right" ){// >
      //we can MOVE to the left
      this.settings.leftCoordenate -= this.settings.width_currSlide;
      $( this.$inner ).css( "left", this.settings.leftCoordenate );
    }
    else if( direction == "left" && this.settings.move_carousel ){// <
      //we can MOVE to the right
      this.settings.leftCoordenate += this.settings.width_prevSlide;
      $(this.$inner).css("left", this.settings.leftCoordenate);

    }
  };

  Zippy.prototype._cssAnimation = function( direction ){

    setTimeout(function(){
      this.$el.addClass("transition");
      this.addCSSDuration();
      this._moveCarousel( direction );
    }.bind(this),50);

    setTimeout(function(){
      this.$el.removeClass("transition");
      this.removeCSSDuration();
      this.startTimer();
    }.bind(this),50 + this.settings.speed);

  };

  Zippy.prototype._jsAnimation = function(direction){
    //Cache this reference for use inside animate functions
    var _ = this;

     // See CSS for explanation of .js-reset-left
    if(direction == 'right') _.$currSlide.addClass('js-reset-left');

     var animation = {};
    animation[direction] = '0%';

    var animationPrev = {};
    animationPrev[direction] = '100%';

    //Animation: Current slide
    this.$currSlide.animate(animationPrev,this.settings.speed);
    };


  $.fn.Zippy = function(options){
    return this.each(function(index,el){
      el.Zippy = new Zippy(el,options);
    });
  };

  var args = {
    arrowRight : ".arrow-right",
    arrowLeft : ".arrow-left",
    speed : 100,
    slideDuration : 1000,
    arrowRight_class: ".arrow-right",
    arrowLeft_class: ".arrow-left"
  };
  $("#path-carousel").Zippy(args);
  $("#subcollection-carousel").Zippy(args);
  console.log("CAROUSEL ON");
});
