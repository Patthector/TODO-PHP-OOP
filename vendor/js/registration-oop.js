;(function(factory){

  if (typeof define === 'function' && define.amd) {
      define(['jquery'], factory);
  } else if (typeof exports !== 'undefined') {
      module.exports = factory(require('jquery'));
  } else {
      factory(jQuery);
  }

})( function($){

  var RegistrationForm = (function( element, settings ){

    function _RegistrationForm( element, settings ){

      this.$el = $(element);
      this.form_id = "#todo__registration--form";

      this.formValidation = {
        _isValidUsername: false,
        _isValidPassword: false,
        _isValidSubmition: false
      };

      this.buttons = {
        id_submitButton: "#todo__registration--submit",
        id_createAccountButtonSwitch: "#todo__registration--new-user-switcher",
        id_signInButtonSwitch: "#todo__registration--sign-in-switcher"

      };

      this.inputsForm = {
        id_inputNewUser: "#new-user-name",
        id_inputUser: "#user-name",
        id_inputPassword: "#user-password",
        $inputPassword: $("#user-password"),
        id_inputConfirmPassword: "#password-confirmation"

      };

      this.$obj = $.extend({}, this, this.formValidation, this.buttons, this.inputsForm, settings);

      this.$target = $(this.$obj.target);

      this.invokeAction = $.proxy( this.invokeAction, this);

      this.init();
    }

    return _RegistrationForm;

  })();

  RegistrationForm.prototype.init = function(){
    this.events();
  }

  RegistrationForm.prototype.events = function(){
    $("body")
        .on( "click", this.$obj.id_signInButtonSwitch, {action: "switch-to-sign-in"},
      this.invokeAction)
        .on( "click", this.$obj.id_createAccountButtonSwitch, {action: "switch-to-new-user"},
      this.invokeAction)
        .on( "blur", this.$obj.id_inputNewUser, {action: "user-verification"},
      this.invokeAction)
        .on( "keyup", this.$obj.id_inputNewUser, {action: "user-clean-input"},
      this.invokeAction)
        .on( "keyup", this.$obj.id_inputUser, {action: "user-validation"},
      this.invokeAction)
        .on( "blur", this.$obj.id_inputUser, {action: "user-validation--last"},
      this.invokeAction)
        .on( "keyup", "#new-user-password", {action: "new-password-validation"},
      this.invokeAction)
        .on( "blur", "#new-user-password", {action: "new-password-validation--last"},
      this.invokeAction)
        .on( "keyup", this.$obj.id_inputPassword, {action: "password-validation"},
      this.invokeAction)
        .on( "blur", this.$obj.id_inputPassword, {action: "password-validation--last"},
      this.invokeAction)
        .on( "blur", this.$obj.id_inputConfirmPassword, {action: "password-confirmation--last"},
      this.invokeAction)
        .on( "keyup", this.$obj.id_inputConfirmPassword, {action: "password-confirmation"},
      this.invokeAction)
        .on( "submit", this.form_id, {action: "form-validation"},
      this.invokeAction)

  }

  RegistrationForm.prototype.invokeAction = function(e){
   var action = (typeof e !== "undefined" ? e.data["action"]  : undefined );

    switch( true ){

      case ( action === "switch-to-sign-in" || action === "switch-to-new-user" ):
        var data = {};
        data[action] = true;

        var ajaxObj = {
            url: "./registration.php",
            method: "GET",
            data: data
          };
        this._invoking( ajaxObj );
      break;

//---NEW-USER---
      case ( action === "user-verification" ):
        var username = e.currentTarget.value;
        this.userVerification( username, this.$obj.id_inputNewUser );
      break;

      case ( action === "user-clean-input" ):
        this._cleanFeedback( this.$obj.id_inputNewUser );
      break;

//---USER---
      case ( action === "user-validation" ):
        var username = e.currentTarget.value;
        if( this._userValidation( username, this.$obj.id_inputUser ))this.$obj._isValidUsername = true;
        else this.$obj._isValidUsername = false;

        this.formSubmitionValidation();
      break;

      case ( action === "user-validation--last" ):
        var username = e.currentTarget.value;
        if( this._userValidation( username, this.$obj.id_inputUser, true ))this.$obj._isValidUsername = true;
        else this.$obj._isValidUsername = false;

        this.formSubmitionValidation();
      break;

//---PASWORD---
      case ( action === "password-validation--last" ):
        var password = e.currentTarget.value;
        this.passwordValidation( password, this.$obj.id_inputPassword, true );
      break;

      case ( action === "password-validation" ):
        var password = e.currentTarget.value;
        if(this.passwordValidation( password, this.$obj.id_inputPassword ))this.$obj._isValidPassword = true;
        else this.$obj._isValidPassword = false;
      break;

      case ( action === "new-password-validation" ):
        var password = e.currentTarget.value;
        this.passwordValidation( password, "#new-user-password" );
        this.passwordMatch( password, $(this.$obj.id_inputConfirmPassword).val() );
      break;

      case ( action === "new-password-validation--last" ):
        var password = e.currentTarget.value;
        if( this.passwordValidation( password, "#new-user-password", true ))this.passwordMatch( password, $(this.$obj.id_inputConfirmPassword).val() );

        this.formSubmitionValidation();
      break;

//---PASWORD-CONFIRMATION---
      case ( action === "password-confirmation--last" ):
        var password_confirmation = e.currentTarget.value;
        this.passwordMatch( $("#new-user-password").val(), password_confirmation, true );

        this.formSubmitionValidation();
      break;

      case ( action === "password-confirmation" ):
        var password_confirmation = e.currentTarget.value;
        this.passwordMatch( $("#new-user-password").val(), password_confirmation );

        this.formSubmitionValidation();
      break;

//---FORM VALIDATION
      case ( action === "form-validation" ):
        this.formSubmitionValidation();
          //console.log(this.$obj._isValidSubmition);
        if( !(this.$obj._isValidSubmition) ){
          e.preventDefault();
          //console.log("FORM VALIDATION-->WRITE THE FUNCTION ;).");
        }
      break;

    }
    this.formSubmitionValidation();
    return;
  };

  RegistrationForm.prototype._invoking = function( ajaxObj ){
    $r = this;
    //-1 DETACH
    this.detach( this.$target );
    //2-AJAX CALL
    $.when( $r.AJAXloader( ajaxObj ) )
      .done( function( response ){
        //3-ATTACH
        $r.attach( response, $r.$target );
        $r._updatingObj();
      } );
      return;
  };
  RegistrationForm.prototype.AJAXloader = function( ajaxObj ){
    return $.ajax({
        url: ajaxObj.url,
        method: ajaxObj.method,
        data: ajaxObj.data
      });
  }

  RegistrationForm.prototype.userVerification = function( username, id ){
    $r = this;
    if( username !== "" ){
      if( this._userValidation( username, id )){
        var ajaxObj = {
          url: "./registration.php",
          method: "GET",
          data:
            {
              action: "user_verification",
              username: username
            }
        };
        this._cleanFeedback( id );
        $.when(this.AJAXloader( ajaxObj ))
          .done(function(data){
            if( !(data === "true") ) {
              $r.$obj._isValidUsername = true;
              $($r.$obj.id_inputNewUser).addClass("is-valid");
              $r.formSubmitionValidation();
            }
            else {
              $r.$obj._isValidUsername = false;
              $($r.$obj.id_inputNewUser).addClass("is-invalid");
              $r.formSubmitionValidation();
            }
          });
      } else {
        $r.$obj._isValidUsername = false;
        this._cleanFeedback( id );
        $($r.$obj.id_inputNewUser).addClass("is-invalid");
      }
    }
    return;
  };
  RegistrationForm.prototype._userValidation = function( username, id, last_check = false ){
    this._cleanFeedback( id );
    if( (username !== "") ){
      var regex = /^[a-zA-Z0-9!@#\$%\^\&*\)\(+=._-]{6,}$/g;
      if( username.match( regex ) ){// it is a valid username, we can proceed
        $( id ).siblings(".invalid-feedback").text( "Unfortunately this username is taken! Please try a different one." );
        return true;
      }//
      //if username doesn't match with the rules
      if( last_check && (username !== "") ){
        if( !( $( id ).hasClass( "is-invalid" ) ) ){ $( id ).addClass( "is-invalid" ); }
      }

      $( id ).siblings(".invalid-feedback").text( "Wrong formation in the username. For more info check the question mark above." );
    }
    return false;
  };
  RegistrationForm.prototype._cleanFeedback = function( id ){
    if( $( id ).hasClass( "is-valid" ) )$( id ).removeClass( "is-valid" );
    if( $( id ).hasClass( "is-invalid" ) )$( id ).removeClass( "is-invalid" );
    return;
  };

  RegistrationForm.prototype.passwordValidation = function( password, id, last_check = false ){
    this._cleanFeedback( id );
    var regex = /^[a-zA-Z0-9!@#\$%\^\&*\)\(+=._-]{6,}$/g;
    if( password !== "" ){//if user-password is not empty
      if( password.match( regex ) ){
        $( id ).addClass( "is-valid", );
        $( id ).removeClass( "is-invalid" );
        $( this.$obj.id_inputConfirmPassword ).removeAttr( "disabled" );
        return true;
      }
      else{
        if( last_check ){
          $( id ).addClass( "is-invalid" );
        }
        $( id ).removeClass( "is-valid" );
        if( $( this.$obj.id_inputConfirmPassword ).attr( "disabled" ) != "disabled" ){
          //add the attr disabled back
          $( this.$obj.id_inputConfirmPassword ).attr( "disabled", "disabled" );
        }
      }
    }
    else{
      this._cleanFeedback(this.$obj.id_inputConfirmPassword);
      $( this.$obj.id_inputConfirmPassword ).attr( "disabled", "disabled" );
      $( this.$obj.id_inputConfirmPassword ).val( "" );
    }
    return false;
  };
  RegistrationForm.prototype.passwordMatch = function( password, password_confirmation, last_check = false ){
    this._cleanFeedback( this.$obj.id_inputConfirmPassword );
    if( (password_confirmation !== password) && last_check && password_confirmation !== "" ){
      //passwords dont match
      $( this.$obj.id_inputConfirmPassword ).removeClass( "is-valid" );
      $( this.$obj.id_inputConfirmPassword ).addClass( "is-invalid" );
      this.$obj._isValidPassword = false;
    }else if( password_confirmation === password && password !== "" ){
      //passwords are equal
      $( this.$obj.id_inputConfirmPassword ).addClass( "is-valid" );
      $( this.$obj.id_inputConfirmPassword ).removeClass( "is-invalid" );
      this.$obj._isValidPassword = true;
    }
    return;
  };

  RegistrationForm.prototype.formSubmitionValidation = function(){
    if( this.$obj._isValidUsername && this.$obj._isValidPassword )
    {
      this.$obj._isValidSubmition = true;
      $("#todo__registration--submit").prop("disabled", false);
    }
    else
    {
      this.$obj._isValidSubmition = false;
      $("#todo__registration--submit").prop("disabled", true);
    }
    return this.$obj._isValidSubmition;
  };

  RegistrationForm.prototype.attach = function( body, target ){
    $(target).append(body);
  };
  RegistrationForm.prototype.detach = function( target ){
    $(target).empty();
  };
  RegistrationForm.prototype._updatingObj = function(){
    this.$obj._isValidUsername = false;
    this.$obj._isValidPassword = false;
    this.$obj._isValidSubmition = false;
    console.log(this);
    return;
  };

  $.fn.RegistrationForm = function(options){
    return this.each(function(index,el){
      el.RegistrationForm = new RegistrationForm(el,options);
    });
  };

  var settings = {
    target: $( "#main" )
  };

  $( "#todo__registration--box" ).RegistrationForm( settings );
  console.log("REGISTRATION ON");

  });
