window.onload = function () {


    $("#shippingAddressRadioGroup input").change(function() {
        console.log(this.value);
        if (this.value == '1') {
            console.log("if")
            validateNewShippingAddress(false);
            $('#shippingAddressContainer').hide()
        }
        else if (this.value == '2') {
            console.log('else')
            validateNewShippingAddress(true);
            $('#shippingAddressContainer').show()
        }
    });


    document.getElementById("checkOutForm").onsubmit = function (e) {

        /*
        validates date
         */
        var date = document.getElementById("ccExpiration");
        if ( !validDate(date) ) {
            e.preventDefault();
            alert("please enter valid date in valid form: MMYY");
        }

        /*
        ensure that credit card number is valid (is a non negative value with 19 digits or less
         */
        var ccNum = document.getElementById("ccNum");
        if ( ccNum.value < 0 || ccNum.value > 9999999999999999999 ) {
            e.preventDefault();
            alert("please enter a valid credit card number");
        }

        /*
        ensure that user enters valid CCV
         */
        var ccCCV = document.getElementById("#ccCCV").value;
        if ( ccCCV < 100 || ccCCV > 999 ) {
            e.preventDefault();
        }
    }

    function validDate ( givenDate ) {

        givenDate = givenDate.value.toString();

        var month = givenDate.substring(0,2);
        var year = givenDate.substring(2);

        console.log(month);
        console.log(year);

        var valid = true;

        if ( month < 1 || month > 12 ) {
            valid = false;
            console.log("month invalid");
        }
        if ( year.length !=2 ) {
            valid = false;
            console.log("year invalid");
            console.log(year);
            console.log(year.length);
        }

        return valid;
    }

    function validRadioGroup ( rb1, rb2 ) {

        var radiogrouptest = true;
        console.log("entered method")

        if ( !( rb1.checked || rb2.checked ) ) {
            radiogrouptest = false;
            console.log("no radio selected");
        }

        return radiogrouptest;
    }

    /*
    validate new shipping address fields
     */
    function validateNewShippingAddress (required) {

        document.getElementById("shippingAddressInput").required = required;
        document.getElementById("shippingCityInput").required= required;
        document.getElementById("shippingProvinceInput").required= required;
        document.getElementById("shippingCountryInput").required = required;

    }

    function validString ( string ) {
        if ( string == "" || /^$|\s+/.test(string) ) {
            return false;
        }
        else return true;
    }
}