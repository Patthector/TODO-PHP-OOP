"user strict";

$( document ).ready( function(){

  console.log("Hello viewport");
} );

function mediaQueryMatches(x) {
  if (x.matches) { // If media query matches
    console.log("we are in mobile screen");
    if( $("#search-bar--input").hasClass( "form-control-lg" ) ){

      $("#search-bar--input").removeClass( "form-control-lg" );
      $("#search-bar--input").addClass( "form-control-sm" );

    }
  } else {
    console.log("we are in PC screen");
  }
}

var x = window.matchMedia("(max-width: 576px)")
mediaQueryMatches(x) // Call listener function at run time
x.addListener(mediaQueryMatches) // Attach listener function on state changes
