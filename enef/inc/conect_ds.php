<?php

//nastroiki dansys
define('DS_HOST','localhost');
define('DS_USER','');
define('DS_PASS','');
define('DS_BAZA_NAME','');

$connection_dansys = mysql_connect(DS_HOST, DS_USER, DS_PASS);
$db = mysql_select_db(DS_BAZA_NAME, $connection_dansys);
//echo DB_COLLATION;
mysql_query("SET CHARACTER SET ".DB_CHARSET, $connection_dansys);
mysql_query("SET SESSION collation_connection = '".DB_COLLATION."'", $connection_dansys);					
    
?>