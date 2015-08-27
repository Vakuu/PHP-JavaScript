<?
	session_start();
	include("../inc/conf.php");
	if (isset($_GET['asoc_id'])) $asoc_id=$_GET['asoc_id'];
	$sql="SELECT count(attach_id) as nums FROM attached_files WHERE asoc_id=".$_GET['asoc_id']." AND dell_flag=0";
	$num_rows=mysql_fetch_array(sql_q($sql));
	echo $num_rows['nums'];
 ?>