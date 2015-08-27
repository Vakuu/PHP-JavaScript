<?php
/*
 * File: conf.php
 * Last modified: 2005.12.06 by Martin Lazarov
 * Created: 2005.07.07 by Martin Lazarov
 */

###################################################################################
### Дефиниране на основните константи
define('DEBUG',false); 
define('SHOW_DEBUG',true); 
define('LOG_SQL',true);
define('MAX_RESULTS',500);
//define('WEB_DIR','/');
###################################################################################
### Информация за връзката с  mysql сървъра ########################################
define('SQL_HOST','localhost');
define('SQL_USER','');
define('SQL_PASS','');
define('SQL_DB','enef_db');
define('DB_CHARSET', 'cp1251');
define('DB_COLLATION', 'cp1251_general_ci');
define('CONVERT_TO_CHARSET', 'WINDOWS-1251');
###################################################################################
//header("Content-Type: text/html; charset=".CONVERT_TO_CHARSET);
###################################################################################
### Вмъкване на основните файлове #################################################
include_once("session.php");
include_once("start.php");
include_once("func.php");
###################################################################################
$db_server = "localhost";
$db_user = "";
$db_password = "";
$db_name = "floorownership";
###################################################################################
$path = "D:/wwwroot/attached_files/";
$url = "http://127.0.0.1/attached_files/";
$nasko = "25";
$kmet = "Йорданка Фандъкова";
?>