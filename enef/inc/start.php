<?
/*
 * File: start.php 
 * Last modified: 2005.12.06 by Martin Lazarov 
 * Created: 2005.08.10 by Martin Lazarov 
 */
###################################################################################
error_reporting(E_ERROR | E_PARSE); // �������� ������� �������

### ������������� �� MySql ��������

$connect=mysql_pconnect(SQL_HOST,SQL_USER,SQL_PASS) or die("���� ������ � MySQL-�������! �������� ������ � ��� �������� �� �� ���������, ��������� ��������� �������������!");
mysql_query("SET CHARACTER SET ".DB_CHARSET, $connect);
mysql_query("SET SESSION collation_connection = '".DB_COLLATION."'");
mysql_select_db(SQL_DB,$connect) or die(d("MYSQL ERROR in ".__FILE__." on line ".__LINE__));
### ������� �������� ���������� ###################################################
define('REMOTE_IP',$_SERVER['REMOTE_ADDR']);
if(!empty($_SESSION['SCREEN_W']) and !empty($_SESSION['SCREEN_H'])){
  define('SCREEN_W',$_SESSION['SCREEN_W']);
  define('SCREEN_H',$_SESSION['SCREEN_H']);
}elseif(!defined('IN_INDEX') and !defined('SCREEN_W') and !defined('SCREEN_H')){  
  define('SCREEN_W',800);
  define('SCREEN_H',600);
}
if(!empty($_SESSION['home_dir'])) define('HOME_DIR',$_SESSION['home_dir']);
$result=mysql_fetch_array(mysql_query("SELECT reg_code FROM reg_numbers WHERE reg_description='��������'"));
define('TOWNSFOLK',$result['reg_code']);
$result=mysql_fetch_array(mysql_query("SELECT reg_code FROM reg_numbers WHERE reg_description='�. ����'"));
define('COMPANIES',$result['reg_code']);
###################################################################################


/* CHANGELOG
 * 2005.12.06 - �������� �� HOME_DIR,SCREEN_H,SCREEN_W /Martin Lazarov/
 * 2005.12.15 - �������� ������������ �������� ��� SCREEN_H � SCREEN_W
 */
?>