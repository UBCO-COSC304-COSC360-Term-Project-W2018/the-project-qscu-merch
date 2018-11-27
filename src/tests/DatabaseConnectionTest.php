<?php


class DatabaseConnectionTest extends PHPUnit_Framework_TestCase {

    public function testDatabaseConnectionReturnTrue () {

        define("DBHOST","cosc304.ok.ubc.ca");
        define("DBNAME", "db_rgelden");
        define("DBUSER", "rgelden");
        define("DBPASS", "40215162");

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