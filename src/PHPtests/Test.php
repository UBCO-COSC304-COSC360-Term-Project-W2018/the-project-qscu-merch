<?php
/**
 * Created by PhpStorm.
 * User: Rachelle
 * Date: 2018-11-28
 * Time: 1:40 AM
 */


class Test extends PHPUnit_Framework_TestCase {

    public function testPagesLoadingReturnsTrue() {
        $host = "localhost";
        $ping = new Ping($host);

       $latency = $ping -> ping();

       $itWorked = false;
       if ( $latency ) {
           $itWorked = true;
       }

       $this -> assertEquals(true, $itWorked);

       return $itWorked;
    }

}
