<?php
// тези променливи да се заложат в базата във sistem_parameters
require_once("../../inc/conf.php");
$GonxAdmin["dbhost"] = SQL_HOST;
$GonxAdmin["dbname"] = SQL_DB;
$GonxAdmin["dbuser"] = SQL_USER;
$GonxAdmin["dbpass"] = SQL_PASS;
$GonxAdmin["dbtype"] = "mysql";
$GonxAdmin["compression"] = array("bz2","zlib");
$GonxAdmin["compression_default"] = "zlib";
$GonxAdmin["locale"] = "bg"; // developt locale for bg - oued :) 
$GonxAdmin["pagedisplay"] = 10;
$GonxAdmin["mysqldump"] = "C:\xampp\mysql\bin\mysqldump.exe";


require_once("libs/db.class.php");
require_once("libs/gonxtabs.class.php");
require_once("libs/backup.class.php");
require_once("libs/locale.class.php");	// Localisation class


?>