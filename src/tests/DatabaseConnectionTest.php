<?php

//require_once('PHPUnit/Autoload.php');

class DatabaseConnectionTest extends PHPUnit_Framework_TestCase {

    public function testDatabaseConnectionReturnTrue() {

        define("DBHOST", "cosc304.ok.ubc.ca");
        define("DBNAME", "db_rgelden");
        define("DBUSER", "rgelden");
        define("DBPASS", "40215162");


        $mysqli = new mysqli (DBHOST, DBUSER, DBPASS, DBNAME);

        $actual = false;

        if ($mysqli->connect_errno) {
            $actual = false;
        } else {
            $actual = true;
        }

        $expected = true;


        $this->assertEquals($expected, $actual);

    }

}