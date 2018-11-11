<?php 
include "init.php";
include "header.php";
?>

    <main>
        <div id="cartHeader">
            <p>Your Cart</p>
        </div>
        <div id="cartMain">
            <div class="product">
                <input type="text" class="cartProductAmount" name="product" placeholder="2" maxlength="2">
                <span class="productName"><a class="aCart" href="">Ping Pong Balls</a></span>
                <span class="priceLabel">Price: $</span>
                <span class="productPrice">598.00</span>
                <span><a class="aCart" href="">remove</a></span>
            </div>
            <div class="product">
                <input type="text" class="cartProductAmount" name="product" placeholder="1" maxlength="2">
                <span class="productName"><a class="aCart" href="">Ping Pong Balls</a></span>
                <span class="priceLabel">Price: $</span>
                <span class="productPrice">299.00</span>
                <span><a class="aCart" href="">remove</a></span>
            </div>
        </div>
        <div id="cartFooter">
            <span>Total Cost: $<span id="costTotal">897.00</span>
            <button>Update Cart</button>
            <button>Check-out</button>
            </span>
        </div>
    </main>

<?php
include "footer.php";
?>