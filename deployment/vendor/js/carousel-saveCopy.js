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
        currSlideMaxWidth : 0,
        leftCoordenate : 0,
        rightCoordenate : 0,
        innerMaxWidth : 0,
        carouselMaxWidth : 0,
        prevSlideMaxWidth : 0
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
      this.$inner = $(".todo__inner--carousel");

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

    this.activate();

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
    //var $indicators = this.$el.append("<ul class = \"indicators\">").find(".indicators");
    this.totalSlides = this.$el.find(".slide").length;
    this.innerSettings.currSlideMaxWidth = this.$el.find(".slide").eq(this.currSlide).width();
    this.innerSettings.carouselMaxWidth = this.$el.width();
    this.innerSettings.innerMaxWidth = this.$inner.width();
    //for( var i = 0; i < this.totalSlides; i++ ) $indicators.append("<li data-index="+i+">");
  };

  Zippy.prototype.activate = function(){
    this.$currSlide = this.$el.find(".slide").eq(0);
    //this.$el.find(".indicators li").eq(0).addClass("active");
  };

  Zippy.prototype.events = function(){
    $("body")
      .on("click",this.settings.arrowRight,
    {direction:"right"},this.changeSlide)
      .on("click",this.settings.arrowLeft,
    {direction:"left"},this.changeSlide)
      .on("click",".indicators li",this.changeSlide);
  };

  Zippy.prototype.showArrows = function(){
    // 1- get the ul width
    // 2- get the inner div width
    // 3- compare the two of them
        // 3.1- if ||==>> inner is bigger, that mean we need to use the carousel
        // 3.2- else ||==>> innner is smalles and we need to hide the arrows
    var list_width = this.$el.width();
    var inner__class = "#" + this.el.id + " .todo__inner--carousel";
    var innner_width = $(inner__class).width();
    ////
    var arrowLeft = "#" + this.el.id;
    arrowLeft = $(arrowLeft).siblings(".arrow-left");
    var arrowRight = "#" + this.el.id;
    arrowRight = $(arrowRight).siblings(".arrow-right");

    if( list_width >= innner_width ){
      $( arrowLeft ).css("display","none");
      $( arrowRight ).css("display","none");
    } else{
      $( arrowLeft ).css("display","block");
      $( arrowRight ).css("display","block");
    }

    return;
  }

  Zippy.prototype.clearTimer = function(){
    if(this.timer) clearInterval(this.timer);
  };

  Zippy.prototype.initTimer = function(){
    this.timer = setInterval(this.changeSlide, this.settings.slideDuration);
  };

  Zippy.prototype.startTimer = function(){
    //this.initTimer();
    this.throttle = false;
  };

  Zippy.prototype.changeSlide = function(e){

    if(this.throttle) return;
    this.throttle = true;

    this.clearTimer();

    var direction = this._direction(e);

    this.innerSettings.currSlideMaxWidth = this.$el.find(".slide").eq(this.currSlide).width();
    if(this.currSlide > 0){
      var aux = this.currSlide-1;
      this.innerSettings.prevSlideMaxWidth = this.$el.find(".slide").eq(aux).width();
    }

    var animate = this._next(e,direction);
    if(!animate) return;

    //var $nextSlide = this.$el.find(".slide").eq(this.currSlide).addClass(direction+" active");
    var $nextSlide = this.$el.find(".slide").eq(this.currSlide).addClass(direction);
    //this.innerSettings.currSlideMaxWidth = this.$el.find(".active").width();


    if(!this.csstransitions){
      this._jsAnimation($nextSlide,direction);
    } else {
      this._cssAnimation($nextSlide,direction);
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

    if( direction == "left"){

      if( (this.currSlide) !== 0 )return true;

    } else if( direction == 'right'){

      if( (this.innerSettings.leftCoordenate+this.innerSettings.innerMaxWidth) > this.innerSettings.carouselMaxWidth )
      { //TEST

      console.log("leftCoordenate",this.innerSettings.leftCoordenate);
      console.log("currSlideW",this.innerSettings.currSlideMaxWidth);
      console.log("innerW",this.innerSettings.innerMaxWidth);
      console.log("theSuM",(this.innerSettings.leftCoordenate + this.innerSettings.innerMaxWidth));
      console.log("carouselW",this.innerSettings.carouselMaxWidth);

        return true;
      }
    }
    return false;
  }
  Zippy.prototype._next = function(e,direction){

    //var index = (typeof e !== "undefined" ? $(e.currentTarget).data("index") : undefined );
    console.log(this._canMove(direction));
    switch( true ){

      /*case( typeof index !== "undefined" ):
        if( this.currSlide == index ){
          this.startTimer();
          return false;
        }
        this.currSlide = index;
        break;*/

      //case( direction == "right" && ( this.currSlide < (this.totalSlides - 1)) ):
      case( (this._canMove(direction)) && direction == "right" ):
        this.currSlide++;
          console.log("MOVING");
        break;

      /*case( direction == "right" ):
        this.currSlide = 0;
          console.log("MOVING");
        break;*/

      case(direction == "left" && this.currSlide === 0 ):
        //this.currSlide = (this.totalSlides - 1);
        this.currSlide = 0;
          console.log("MOVING");
        break;

      case( (this._canMove(direction)) && direction == "left"):
        this.currSlide--;
          console.log("MOVING");
        break;

    }
    return true;

  };

  Zippy.prototype._moveCarousel = function( direction ){

    if( direction == "right" ){// >
      //we can MOVE to the left

      //TEST
      /*
      console.log("leftCoordenate",this.innerSettings.leftCoordenate);
      console.log("currSlideW",this.innerSettings.currSlideMaxWidth);
      console.log("innerW",this.innerSettings.innerMaxWidth);
      console.log("theSuM",(this.innerSettings.leftCoordenate + this.innerSettings.innerMaxWidth));
      console.log("carouselW",this.innerSettings.carouselMaxWidth);*/
      //


      if( (this.innerSettings.leftCoordenate + this.innerSettings.innerMaxWidth) > this.innerSettings.carouselMaxWidth  ){
        console.log("to the LEFT");
        this.innerSettings.leftCoordenate -= this.innerSettings.currSlideMaxWidth;
        $(this.$inner).css("left", this.innerSettings.leftCoordenate);

      }
    }
    else if( direction == "left" ){// <
      //we can MOVE to the right
      //TEST
      /*
      console.log("leftCoordenate",this.innerSettings.leftCoordenate);
      console.log("currSlideW",this.innerSettings.currSlideMaxWidth);
      console.log("innerW",this.innerSettings.innerMaxWidth);
      console.log("theSuM",(this.innerSettings.leftCoordenate + this.innerSettings.innerMaxWidth));
      console.log("carouselW",this.innerSettings.carouselMaxWidth);
      */
      //

      if( this.innerSettings.leftCoordenate < 0 ){

      this.innerSettings.leftCoordenate += this.innerSettings.prevSlideMaxWidth;
      $(this.$inner).css("left", this.innerSettings.leftCoordenate);

     }
    }

  };

  Zippy.prototype._cssAnimation = function($nextSlide, direction){

    setTimeout(function(){
      this.$el.addClass("transition");
      this.addCSSDuration();
      //this.$currSlide.addClass("shift-"+direction);
      this._moveCarousel( direction );
    }.bind(this),100);

    setTimeout(function(){
      this.$el.removeClass("transition");
      this.removeCSSDuration();
      //this.$currSlide.removeClass("active shift-left shift-right");
      this.$currSlide = $nextSlide.removeClass(direction);
      //this._updateIndicators();
      this.startTimer();
    }.bind(this),100 + this.settings.speed);

  };

  Zippy.prototype._jsAnimation = function($nextSlide,direction){
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

    //Animation: Next slide
    $nextSlide.animate(animation,this.settings.speed,'swing',function(){
        //Get rid of any JS animation residue
        _.$currSlide.removeClass('active js-reset-left').attr('style','');
        //Cache the next slide after classes and inline styles have been removed
        _.$currSlide = $nextSlide.removeClass(direction).attr('style','');
        _._updateIndicators();
        _.startTimer();
      });
    };

  Zippy.prototype._updateIndicators = function(){
      //this.$el.find(".indicators li").removeClass("active").eq(this.currSlide).addClass("active");
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
