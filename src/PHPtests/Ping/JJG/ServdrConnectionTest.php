<?php
/**
 * Created by PhpStorm.
 * User: Rachelle
 * Date: 2018-11-30
 * Time: 9:09 AM
 */

require_once 'Ping.php';
use JJG\Ping as Ping;


class ServdrConnectionTest extends PHPUnit_Framework_TestCase  {

//include Ping\JJG\Ping.php;
    public function testPagesLoadingReturnsTrue() {

//    assert(true,true);
        $host = "cosc304.ok.ubc.ca";
        $ping = new Ping($host);

        $latency = $ping -> ping();

        $itWorked = false;
        if ( $latency ) {
            $itWorked = true;
        }

        $this -> assertEquals(true, $itWorked);

    }

}
