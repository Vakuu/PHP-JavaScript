<?
include("../inc/conf.php");
?>
<html>
<head>

<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<meta http-equiv="Content-Language" content="bg">

<style type="text/css">
	td.header
	{	font-size: 16px;
		font-weight:bold;
		color: blue;
		text-align:center;
	}
	div
	{	padding-top: 3px;
		padding-bottom: 3px;
	}
</style>
<title>Анулиран за проверка?</title>
</head>
<body background="Images/Stone.jpg">
<form name="form_demo" action="" method="post">
	<?	$sql = "SELECT PValue FROM `system_parameters` where PName = 'anul_che';";
		$res1 = mysql_fetch_array(sql_q($sql));
		$res1 = $res1[0];
		if (isset($_GET['che1']))
		{	$res1 = $_GET['che1'];
			sql_q("update `system_parameters` set `PValue`='".$res1."' where PName = 'anul_che';");
		}
		$sql = "SELECT PValue FROM `system_parameters` where PName = 'anul_che_how';";
		$res2 = mysql_fetch_array(sql_q($sql));
		$res2 = $res2[0];
		if (isset($_GET['che2']))
		{	$res2 = $_GET['che2'];
			sql_q("update `system_parameters` set `PValue`='".$res2."' where PName = 'anul_che_how';");
		}
	?>
		<div style="text-align: right; margin-bottom: 0px;">
			<p align= "left">
			<input type = "checkbox" name = "anul_che" onclick = "if(this.checked == true) {window.location.href='anul_che.php?che1=1'} else {window.location.href='anul_che.php?che1=0'}" value = "<?=$res1?>" <?if ($res1==1) echo('checked');?>>
			Да бъде ли включена опцията за проверка на анулирани фактури?
			</p>
			<p align="left">
			<input type = "checkbox" name = "anul_che_how" onclick = "if(this.checked == true) {window.location.href='anul_che.php?che2=1'} else {window.location.href='anul_che.php?che2=0'}" value = "<?=$res2?>" <?if ($res2==1) echo('checked');?>>
			Да се анулира ли фактурата при дневно приключване,
			ако никой от правоимащите не потвърди анулирането
			на фактурата до края на работния ден.
			</p>
			<input type="button" name="exit" value="Изход" onClick ="window.close()">
		</div>
</form>
</body>
</html>