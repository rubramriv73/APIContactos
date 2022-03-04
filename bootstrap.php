<?php
/**
 * @author Ruben Ramirez Rivera
 */

 require 'vendor/autoload.php';
 use Dotenv\Dotenv;

 $dotenv = Dotenv::createMutable(__DIR__);
 $dotenv->load();

 define("DBHOST", $_ENV["DBHOST"]);
 define("DBUSER", $_ENV["DBUSER"]);
 define("DBPASS", $_ENV["DBPASS"]);
 define("DBNAME", $_ENV["DBNAME"]);
 define("DBPORT", $_ENV["DBPORT"]);
 define("KEY", $_ENV["KEY"])
?>
