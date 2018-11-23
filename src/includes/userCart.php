<?php

class userCart{
    var $cart = [];

    function addItem($pno, $size, $qty = 1, $itemPrice = -1){
        $item = array('pno' => $pno, 'size' => $size, 'qty' => $qty, 'price' => $itemPrice);
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
            $newArray[$key] = $item['pno'];
        }
        array_multisort($newArray, SORT_ASC, $this->cart);
    }


    function updateItem($pno, $size, $qty = null, $price = null){
        $key = $this->getItemKey($pno, $size);

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

    function removeItem($pno, $size){
        $key = $this->getItemKey($pno, $size);
        return $this->removeItemByKey($key);
    }

    function getItem($pno, $size){
        return $this->cart[$this->getItemKey($pno, $size)];
    }

    function getItemKey($pno, $size){
        $index = -1;
        foreach ($this->cart as $key => $item) {
            if ($item[$key] == $pno && $item[$key] == $size) {
                $index = $key;
                break;
            }
        }
        return $index;
    }
}

?>