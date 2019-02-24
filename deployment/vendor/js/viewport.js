"user strict";

$( document ).ready( function(){

  $(window).on("scroll", function(){ mainMenuSize() } );

});

function mediaQueryMatches(x) {
  var distance = $("#todo__main-menu-size").offset().top;
  if (x.matches) { // If media query matches--MOBILE-- => [ screen < 992px ]
    console.log("We are in MOBILE");
    // 1-Take action on header menu, logo
    if ( $(window).scrollTop() >= distance ) {
     $('#logo-svg--mobile svg').css("width", "150px" );
     $('#logo-svg--mobile svg').css("height", "50px" );
      }
    else
     {
      $('#logo-svg--mobile svg').css("width", "200px" );
      $('#logo-svg--mobile svg').css("height", "56.48px" );
      }
    // 2-Take action on search-bar
    if( $("#search-bar--input").hasClass( "form-control-lg" ) ){

        $("#search-bar--input").removeClass( "form-control-lg" );
        $("#search-bar--input").addClass( "form-control-sm" );
    }
  }
  else {//--PC-- => [ screen > 992px ]
    console.log("We are in PC");
    if ( $(window).scrollTop() >= distance ) {
     $('#logo-svg--pc svg').css("width", "200px" );
     $('#logo-svg--pc svg').css("height", "40px" );
      }
    else
     {
      $('#logo-svg--pc svg').css("width", "300px" );
      $('#logo-svg--pc svg').css("height", "56.48px" );
      }
  }
}

var x = window.matchMedia("(max-width: 992px)")
mediaQueryMatches(x) // Call listener function at run time
x.addListener(mediaQueryMatches) // Attach listener function on state changes

function mainMenuSize(){
  mediaQueryMatches(x);
}
