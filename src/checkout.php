<?php 
include "init.php";
include "header.php";
?>
    <main>
        <form method="post" action="http://www.randyconnolly.com/tests/process.php" id="checkOutForm">

            <fieldset>
                <legend id="checkOutFormTitle">Check Out</legend>

                <div id="checkoutFormElements">
                    <div id="checkoutFormInputElements">
                        <div id="ccNameContainer" class="checkoutContainer">
                            <label id="ccNameLabel" for="ccName" class="elementLabel">Name on Card: </label>
                            <input type="text" name="ccName" id="ccName" required>
                        </div>

                        <div id="ccNumContainer" class="checkoutContainer">
                            <label id="ccNumLabel" for="ccNum" class="elementLabel">Credit Card Number: </label>
                            <input type="number" name="ccNum" id="ccNum" required>
                        </div>

                        <div id="ccExpirationContainer" class="checkoutContainer">
                            <label id="ccExpDateLabel" for="ccExpiration" class="elementLabel">Expiry Date (MMYY): </label>
                            <input type="text" name="ccExpiration" required id="ccExpiration">
                        </div>

                        <div id="ccCCVContainer" class="checkoutContainer">
                            <label id="ccCCVLabel" for="ccCCV" class="elementLabel">CCV: </label>
                            <input type="number" name="ccv" required id="ccCCV">
                        </div>

                        <div id="addressContainer" class="checkoutContainer">
                            <div id="billingAddressContainer" class="checkoutContainer">
                                <label id="billingAddressLabel" class="elementLabel">Billing Address: </label>
                                <div id="billingAddress">
                                    <label class="elementLabel" for="billingAddressInput">Address Line: </label>
                                    <input type="text" name="billingAddress" id="billingAddressInput" required>
                                </div>

                                <div id="billingCity">
                                    <label class="elementLabel" for="billingCityInput">City: </label>
                                    <input type="text" name="billingCity" id="billingCityInput" required>
                                </div>

                                <div id="billingProvince">
                                    <label class="elementLabel" for="billingProvinceInput">Province/State: </label>
                                    <input type="text" name="billingProvince" id="billingProvinceInput" required>
                                </div>

                                <div id="billingCountry">
                                    <label class="elementLabel" for="billingCountryInput">Country: </label>
                                    <input type="text" name="billingCountry" id="billingCountryInput" required>
                                </div>

                                <div id="billingPostalCode">
                                    <label class="elementLabel" for="billingPostalCodeInput">Postal Code: </label>
                                    <input type="text" name="billingPostalCode" id="billingPostalCodeInput" required>
                                </div>
                            </div>
                        </div>
                        <div id="shippingAddressRadioGroup">
                            <label class="elementLabel" for="shippingAddressRadioGroup">Select a shipping address: </label>
                            <input type="radio" name="shippingAddress" id="billingAddressRadio" checked="checked" value="1">Billing address<br>
                            <input type="radio" name="shippingAddress" id="shippingAddressRadio" value="2">New shipping address <br>
                        </div>
                        <!-- note these inputs do not have required class -->
                        <div id="shippingAddressContainer" class="checkoutContainer">
                            <div id="shippingAddress">
                                <label class="elementLabel">New Shipping Address:</label>
                                <label class="elementLabel" for="shippingAddressInput">Address Line: </label>
                                <input type="text" name="shippingAddress" id="shippingAddressInput">
                            </div>

                            <div id="shippingCity">
                                <label class="elementLabel" for="shippingCityInput">City: </label>
                                <input type="text" name="shippingCity" id="shippingCityInput">
                            </div>

                            <div id="shippingProvince">
                                <label class="elementLabel" for="shippingProvinceInput">Province/State: </label>
                                <input type="text" name="shippingProvince" id="shippingProvinceInput">
                            </div>

                            <div id="shippingCountry">
                                <label class="elementLabel" for="shippingCountryInput">Country: </label>
                                <input type="text" name="shippingCountry" id="shippingCountryInput">
                            </div>

                            <div id="shippingPostalCode">
                                <label class="elementLabel" for="shippingPostalCodeInput">Postal Code: </label>
                                <input type="text" name="shippingPostalCode" id="shippingPostalCodeInput">
                            </div>
                        </div>
                    </div>

                    <div id="checkoutButtonContainer" class="checkoutContainer">
                        <!--<button type="submit" id="checkOutButton">Confirm</button>-->
                        <input type="submit" id="checkOutButton">
                    </div>
                </div>
            </fieldset>
        </form>

        <div id="paypalButtonContainer">
            <a href="https://www.paypal.com"><img src="images/paypal-checkout-button.png" alt="checkout using paypal"
                                          id="paypalButton"></a>
        </div>
    </main>

<?php
include "footer.php";
?>