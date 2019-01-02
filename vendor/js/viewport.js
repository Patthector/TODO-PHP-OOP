"user strict";

$( document ).ready( function(){

  $(window).on("scroll", function(){ mainMenuSize() } );

});

function mediaQueryMatches(x) {
  var distance = $("#todo__main-menu-size").offset().top;
  if (x.matches) { // If media query matches--MOBILE--
    console.log("We are in MOBILE");
    // 1-Take action on header menu, logo
    if ( $(window).scrollTop() >= distance ) {
     $('#logo-svg svg').css("width", "150px" );
     $('#logo-svg svg').css("height", "50px" );
      }
    else
     {
      $('#logo-svg svg').css("width", "200px" );
      $('#logo-svg svg').css("height", "56.48px" );
      }
    // 2-Take action on search-bar
    if( $("#search-bar--input").hasClass( "form-control-lg" ) ){

        $("#search-bar--input").removeClass( "form-control-lg" );
        $("#search-bar--input").addClass( "form-control-sm" );
    }
  }
  else {//--PC--
    if ( $(window).scrollTop() >= distance ) {
     $('#logo-svg svg').css("width", "200px" );
     $('#logo-svg svg').css("height", "35px" );
      }
    else
     {
      $('#logo-svg svg').css("width", "300px" );
      $('#logo-svg svg').css("height", "56.48px" );
      }
  }
}

var x = window.matchMedia("(max-width: 576px)")
mediaQueryMatches(x) // Call listener function at run time
x.addListener(mediaQueryMatches) // Attach listener function on state changes

function mainMenuSize(){
  mediaQueryMatches(x);
}
