"user strict";

$( document ).ready( function( ){

  $('#todo__search-bar--form').submit(function(e) { return searchQueryValidation(e) });
  $("#todo__btn--searchBy").on("click",function(e){ searchByAction() });

} );

function searchQueryValidation(e ){
  var query = $( "#search-bar--input" ).val();
  //var regex = /^[a-zA-Z0-9!@#\$%\^\&*\)\(+=._-]{2,}$/g;
  var regex = /^[\w\-\s!@#\$%\^\&*\)\(+=._-]{2,}$/g;
  if( query !== ""){
    if( query.match( regex ) ){// it is a valid query, we can proceed
      return true;
    }else{
      if( !( $( "#search-bar--input" ).hasClass( "is-invalid" ) ) ){ $( "#search-bar--input" ).addClass( "is-invalid" ); }
      $("#search-bar--input").siblings(".invalid-feedback").text( "The formation is invalid. Please try again." );
      return false;
    }
  }
  if( !( $( "#search-bar--input" ).hasClass( "is-invalid" ) ) ){ $( "#search-bar--input" ).addClass( "is-invalid" ); }
  $("#search-bar--input").siblings(".invalid-feedback").text( "The field cannot be empty. Please try with some value." );
  return false;
}
function searchByAction(){
  $("#searchByMenuContainer").toggle('slow');
  return;
}
function goToMyTodos(){
  window.location.href = "/TODO-PHP-OOP/views/mytodos.php"
}
