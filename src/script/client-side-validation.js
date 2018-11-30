window.onload = function () {

    console.log("another one");

    document.getElementById("loginForm").onsubmit = function (e) {

        var emailField = document.getElementById("loginEmailInput");
        var passwordField = document.getElementById("loginPasswordInput");

        if ( passwordField.value == "" ) {
            e.preventDefault();
            alert("Please enter a password");
        }

    };

/*
       document.getElementById("signUpForm").onsubmit = function (e) {

        //sign-up form elements to be validated
        var fnamefield = document.getElementById("fnameInput");
        var lnamefield = document.getElementById("lnameInput");
        var emailField = document.getElementById("signUpEmailInput");
        var passwordField = document.getElementById("signUpPasswordInput");
        var passwordConfirmField = document.getElementById("signUpPasswordConfirmationInput");

        if ( !(validateName ( fnamefield )) ) {
            e.preventDefault();
            alert("Put in an actual first name");
        }

        else if ( !(validateName ( lnamefield )) ) {
            e.preventDefault();
            alert("Put in an actual last name");
        }

        else if ( passwordField.value != passwordConfirmField.value ) {
            e.preventDefault();
            alert("Passwords do not match");
        }



    }
*/

    function validateName ( name ) {
        var valid = true;

        //check to see if fname is all white space or null
        if ( !(/\S/.test(name.value)) || name.value == null ) {
            valid = false;
        }
        return valid;
    }


}