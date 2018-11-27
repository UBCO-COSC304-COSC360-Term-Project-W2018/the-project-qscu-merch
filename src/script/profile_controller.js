$(document).ready(function (e) {


    $('.numberOnly').on('change keyup paste', function () {
        if (/\D/g.test(this.value)) {
            // Filter non-digits from input value.
            this.value = this.value.replace(/\D/g, '');
        }
    })


    $("#infoEditSave").on('click', function (e) {
        let infoEditSave = $(this);
        let emailInput = $("#emailInput");
        let firstNameInput = $("#firstNameInput");
        let lastNameInput = $("#lastNameInput");


        if (infoEditSave.val() === "Edit") {
            emailInput.prop("readonly", false);
            firstNameInput.prop("readonly", false);
            lastNameInput.prop("readonly", false);

            infoEditSave.val("Save");
            setTimeout(function () {
                infoEditSave.prop("type", "submit")
            }, 1)

        } else if ($("#infoEditSave").val() === "Save") {
            //TODO sanitize input

        }
    });


    $("#passwordEditSave").on('click', function (e) {

        let passwordEditSave = $(this);
        let oldPassword = $("#oldPasswordInput");
        let passwordInput = $("#passwordInput");
        let confirmPasswordInput = $("#confirmPasswordInput");


        if (passwordEditSave.val() === "Edit") {
            oldPassword.prop("readonly", false);
            passwordInput.prop("readonly", false);
            confirmPasswordInput.prop("readonly", false);

            passwordEditSave.val("Save");
            setTimeout(function () {
                passwordEditSave.prop("type", "submit")
            }, 1)

        } else if ($("#passwordEditSave").val() === "Save") {
            //TODO validate input

        }
    });

    $("#billingEditSave").on('click', function (e) {

        let billingEditSave = $(this);
        let billingAddressInput = $("#billingAddressInput");
        let billingCityInput = $("#billingCityInput");
        let billingProvinceInput = $("#billingProvinceInput");
        let billingCountryInput = $("#billingCountryInput");
        let billingPostalCodeInput = $("#billingPostalCodeInput");
        let cardNumberInput = $("#cardNumberInput");
        let expiryInput = $("#expiryInput");
        let securityCodeInput = $("#securityCodeInput");




        if (billingEditSave.val() === "Edit") {
            billingAddressInput.prop("readonly", false);
            billingCityInput.prop("readonly", false);
            billingProvinceInput.prop("disabled", false);
            billingCountryInput.prop("readonly", false);
            billingPostalCodeInput.prop("readonly", false);
            cardNumberInput.prop("readonly", false);
            expiryInput.prop("readonly", false);
            securityCodeInput.prop("readonly", false);

            billingEditSave.val("Save");
            setTimeout(function () {
                billingEditSave.prop("type", "submit")
            }, 1)

        } else if ($("#billingEditSave").val() === "Save") {
            //TODO validate input

        }
    });


});