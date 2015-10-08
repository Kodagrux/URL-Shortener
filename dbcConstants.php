<?php
/**
 * This file should contain all login credentials to the database that dbc
 * is suppose to connect to.
 * 
 * @author Albin Hubsch
 * @version 1.1
 * @copyright 2012
 */

/**
 * Please change the credentials below
 */
define('DB_SERVER', 'arbr-links-109873.mysql.binero.se');           //comment
define('DB_USER', '109873_fk62153');                  //comment
define('DB_PASSWORD', '3310:)@AnkaN.23');        //comment
define('DB_NAME', '109873-arbr-links');               //comment

define('UNIQE_SALT', '2<=j,Bh[c+*XX6mB');   //comment


//DO NOT CHANGE BELOW UNLESS YOU KNOW WHAT YOU'RE DOING!
define('DB_CONN', 'mysql:host='.DB_SERVER.';dbname='.DB_NAME);

?>