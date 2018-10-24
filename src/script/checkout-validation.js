window.onload = function () {

    document.getElementById("checkOutForm").onsubmit = function (e) {

        e.preventDefault();
        var date = document.getElementById("ccExpiration");
        if ( !validDate(date) ) {
            e.preventDefault();
            alert("please enter valid date in valid form: MMYY");
        }

        console.log();

        var radio1 = document.getElementById("addressOnFileRadio");
        var radio2 = document.getElementById("newAddressRadio");

        if ( !validRadioGroup( radio1, radio2 )) {
            e.preventDefault();
            alert("Please select a shipping address");
        }

        var ccNum = document.getElementById("ccNum");
        if ( ccNum < 0 ) {
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

        if ( !( rb1.checked || rb2.checked ) ) {
            radiogrouptest = false;
        }

        return radiogrouptest;
    }
}