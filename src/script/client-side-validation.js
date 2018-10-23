window.onload = function () {

    console.log("another one");

    document.getElementById("loginForm").onsubmit = function (e) {

        //login form elements that must be validated
        var emailField = document.getElementById("loginEmailInput");
        var passwordField = document.getElementById("loginPasswordInput");

        // if ( !validateEmail(loginEmailField) ) {
        //     e.preventDefault();
        //     alert("please enter a valid email");
        // }
        //
        if ( passwordField.value == "" ) {
            e.preventDefault();
            alert("Please enter a password");
        }

    };

    /*
    regular expression from https://flaviocopes.com/how-to-validate-email-address-javascript/
     */
    // function validateEmail ( email ) {
    //     var expression = /(?!.*\.{2})^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
    //
    //     return expression.test(String(email).toLowerCase());
    // }

    document.getElementById("signUpForm").onsubmit = function (e) {

        //sign-up form elements to be validated
        var fnamefield = document.getElementById("fnameInput");
        var lnamefield = document.getElementById("lnameInput");
        var emailField = document.getElementById("signUpEmailInput");
        var passwordField = document.getElementById("signUpPasswordInput");
        var passwordConfirmField = document.getElementById("signUpPasswordConfirmationInput");

        if ( !(validateName ( fnamefield )) ) {
            e.preventDefault();
            alert("put in an actual first name");
        }

        if ( !(validateName ( lnamefield )) ) {
            e.preventDefault();
            alert("put in an actual last name");
        }

        if ( passwordField.value != passwordConfirmField.value ) {
            e.preventDefault();
            alert("passwords do not match");
        }



    }

    function validateName ( name ) {
        var valid = true;

        //check to see if fname is all white space or null
        if ( !(/\S/.test(name.value)) || name.value == null ) {
            valid = false;
        }
        return valid;
    }


}