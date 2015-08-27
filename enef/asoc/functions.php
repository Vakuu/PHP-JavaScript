<?php
	include "../inc/conf.php";
	
function convertDate($d){
	$change_date = explode('-', $d);
		// echo $change_date;
	$y = $change_date[0];
	$m = $change_date[1];
	$d = $change_date[2];
		$arr = array($d, $m, $y);
		$change_date = implode('-', $arr);
		return $change_date;
		// echo $y.$m.$d;
}
// ------------------------------------ //
function getKvAndRaion($kvr){
	$kr = explode('~', $kvr);
	$nom_code = $kr[0];
	$cod_cod = $kr[1];
	$sql1 = "SELECT cod_name 
			 FROM elements 
			 WHERE nom_code = '" . $nom_code . "' AND cod_cod = '" . $cod_cod. "'";
	$res1 = mysql_query($sql1) or die(mysql_error());
	$row1 = mysql_fetch_assoc($res1);
	$sql2 = "SELECT cod_name 
			 FROM elements 
			 WHERE nom_code = '02' AND (cod_cod = '" . $nom_code . "' - 6)";
	$res2 = mysql_query($sql2) or die(mysql_error());
	$row2 = mysql_fetch_assoc($res2);
		return $kvr = $row2['cod_name'] . ', ' . $row1['cod_name'];
}
// ----------------------------------- //
function getPredmet($num){
	$sql = "SELECT cod_name 
			FROM elements 
			WHERE nom_code = '06' AND cod_cod = '" . $num . "'";
	$res = mysql_query($sql) or die(mysql_error());
	$row = mysql_fetch_assoc($res);
		return $num = $row['cod_name'];
}
// -------------------------------- //
function getPredstavitelstvo($p){
	$sql = "SELECT cod_name 
			FROM elements 
			WHERE nom_code = '03' AND cod_cod = '$p'";
	$res = mysql_query($sql) or die(mysql_error());
	$row = mysql_fetch_assoc($res);
		return $p = $row['cod_name'];
}
// -------------------------------- //
function getConstrType($type){
	$sql = "SELECT cod_name 
			FROM elements 
			WHERE nom_code = '04' AND cod_cod = '$type'";
	$res = mysql_query($sql) or die(mysql_error());
	$row = mysql_fetch_assoc($res);
		return $type = $row['cod_name'];
}
// -------------------------------- //
function getCreator($name){
	$sql = "SELECT full_name 
			FROM users 
			WHERE id = '" . $_SESSION['user_id'] . "'";
	$res = mysql_query($sql) or die(mysql_error());
	$row = mysql_fetch_assoc($res);
	return $name = $row['full_name'];	
}