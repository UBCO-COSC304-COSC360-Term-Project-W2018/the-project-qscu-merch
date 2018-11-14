<?php
class userCart{
    var $cart = [];

    function addItem($pno, $size, $qty){
        $item = array('pno'=>$pno, 'size'=>$size, 'qty'=>$qty);
        array_push($this->cart, $item);
        $this->sort();

    }
    function sort(){
        $newArray = array();
        foreach ($this->cart as $key => $item)
        {
            $newArray[$key] = $item['pid'];
        }
        array_multisort($newArray, SORT_DESC, $this->cart);
    }
    function removeItem($pno, $size){
        $key = $this->getItemKey($pno,$size);
        $item = $this->cart[$key];
        unset($this->cart[$key]);
        $this->cart = array_values($this->cart);
        $this->sort();
        return$item;
    }

    function getItem($pno, $size){
        return $this->cart[$this->getItemKey($pno, $size)];
    }

    function getItemKey($pno, $size){
        $index = -1;
        foreach ($this->cart as $key => $item){
            if($item[$key] == $pno && $item[$key] == $size){
                $index = $key;
                break;
            }
        }
        return $index;
    }
}
?>