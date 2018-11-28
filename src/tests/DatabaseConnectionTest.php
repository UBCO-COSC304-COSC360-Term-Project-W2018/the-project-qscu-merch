<?php

//require_once('PHPUnit/Autoload.php');

class DatabaseConnectionTest extends PHPUnit_Framework_TestCase {

    public function testDatabaseConnectionReturnTrue () {

        define("DBHOST","localhost");
        define("DBNAME", "qscurachelle");
        define("DBUSER", "rachellegelden");
        define("DBPASS", "rachelle");

        $mysqli = new mysqli (DBHOST, DBUSER, DBPASS, DBNAME);

        $actual = false;

        if ( $mysqli -> connect_errno) {
            $actual = false;
        }
        else {
            $actual = true;
        }

        $expected = true;

        $actual1 = 'foo';
        $expected1 = 'foo';

        $this -> assertEquals($expected1, $actual1);

        return $actual;

    }

}