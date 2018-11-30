<?php

class userCart{
    var $cart = [];

    function addItem($pNo, $pname, $size, $qty = 1, $itemPrice = -1){
        $item = array('pNo' => $pNo, 'pname' => $pname,'size' => $size, 'qty' => $qty, 'price' => $itemPrice);
        array_push($this->cart, $item);
    }

    function getCart(){
        return $this->cart;
    }

    function setCart($cart){
        $this->cart = $cart;
    }

    function sort()
    {
        $newArray = array();
        foreach ($this->cart as $key => $item) {
            $newArray[$key] = $item['pNo'];
        }
        array_multisort($newArray, SORT_ASC, $this->cart);
    }


    function updateItem($pNo, $size, $qty = null, $price = null){
        $key = $this->getItemKey($pNo, $size);

        if($price != null && $price > 0){
            $this->cart[$key]['price'] = $price;
        }
        if ($qty != null) {
            if ($qty < 1) {
                $this->removeItemByKey($key);
            } else {
                $this->cart[$key]['qty'] = $qty;
            }
        }

    }

    function removeItemByKey($key){
        $item = $this->cart[$key];
        unset($this->cart[$key]);
        $this->cart = array_values($this->cart);
        return $item;
    }

    function removeItem($pNo, $size){
        $key = $this->getItemKey($pNo, $size);
        return $this->removeItemByKey($key);
    }

    function getItem($pNo, $size){
        return $this->cart[$this->getItemKey($pNo, $size)];
    }

    function getItemKey($pNo, $size){
        $index = -1;
        foreach ($this->cart as $key => $item) {

            if ($this->cart[$key]['pNo'] == $pNo && $this->cart[$key]['size'] == $size) {
                $index = $key;
                break;
            }
        }
        return $index;
    }
}

?>