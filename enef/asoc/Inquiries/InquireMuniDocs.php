<? 
	include ("../../inc/conf.php");
	// echo $_GET['sel_rai'] . "<br/>";
	// echo $_GET['kv'] . "<br/>";

	// echo $_SESSION['placement'] . " - b<br/>";
	// echo $_SESSION['username'] . " - c<br/>";
	if(!empty($_GET['sel_rai'])){
		$raion = $_GET['sel_rai'];
		$sql1 = "SELECT cod_name 
				 FROM elements 
				 WHERE nom_code = '02' AND cod_cod = '" . $raion . "'";
		$res1 = mysql_query($sql1) or die(mysql_error());
		$row1 = mysql_fetch_assoc($res1);
		$raion = $row1['cod_name'];
	}else{$raion = '������';}
	if(!empty($_GET['kv'])){
		$kvartal = explode('~', $_GET['kv']);
		$raion4e = $kvartal[0];
		$kvartal = $kvartal[1]; //$kvartal[0] = nomer na raion - 6 (30 - 6 = 24)
		$sql2 = "SELECT cod_name 
				 FROM elements 
				 WHERE nom_code = '" . $raion4e . "' AND cod_cod = '" . $kvartal . "'";
		$res2 = mysql_query($sql2) or die(mysql_error());
		$row2 = mysql_fetch_assoc($res2);
		$kvartal = $row2['cod_name'];
	}else{$kvartal = '������';}
	
	if($_SESSION['placement'] == $nasko){

	}else{
		// 
	}
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="../css/InquireAsoc.css" />
<style type="text/css">
	#table {width: 100%; border-color: black; border-style: dotted; border-width: 1 1 0 1 }
	td { border-width: 0 0 0 0; border-style: dotted; padding: 0px; font-size: 14px }
	td.bottom { border-width: 0 0 1px 0; }
	td.left_bottom { border-width: 0 0 1px 1px; }
</style>
<script src="../js/jQuery1.11.js"></script>
<script>
$(document).ready(function(){
	// var ias = $('#table td i').text();
		// $('#res').text(ias);
		
		$('#export').click(function(){
			// var tbl = $('#table').text();
			window.open('data:application/vnd.ms-excel,' + decodeURIComponent($('#table').text()));
		});
});
</script>
</head>

<body>
<div id="res" />
	<table id="tbl1" cellspacing="0" cellpadding="0">
		<tr>
			<td colspan="3" align="center">
				<b><i>������� �� ������������ ��������� �� �������������(��)</i></b>
			</td>
			<td align="right">
				<form id="" name="" action="../xls.php?query=1" method="post">
					<input type="submit" id="export" name="export" value="������������ � Excel" />
				</form>
			</td>
		</tr>
		<tr>
			<td>
				<i>�����:</i><?= $raion?><br/>
				<i>�������:</i><?= $kvartal?><br/>
				<i>����:</i> <?= date('d-m-Y');?>
			</td>
		</tr>
	</table>
	<table id="table" cellspacing="0" cellpadding="0" border="1">
		<tr>
			<td class="bottom header" width=""><i>�</i></td>
			<td class="left_bottom header" align="center"><i>�����</i></td>
			<td class="left_bottom header" align="center"><i>���� ������������ ��������� �� �������������(��)</i></td>
			<td class="left_bottom header" align="center"><i>���� �������� ��������� �� ������� � ��������� �����(����)</i></td>
			<td class="left_bottom header" align="center"><i>���� �������� ��������� �� ������� � ��������� �����(����)</i></td>
		</tr>
<?
	// $res = mysql_query($sql) or die(mysql_error());
	// $counter = 1;
	// while($row = mysql_fetch_assoc($res)){
	// $counter++;
?>
		<tr>
			<td class="left_bottom" align="center"><?//=$counter++?>1</td>
			<td class="left_bottom" align="center"><?//= $row['raion']?>�����</td>
			<td class="left_bottom" align="center"><?//=$row['broiSdr']?>12</td>
			<td class="left_bottom" align="center">143</td>
			<td class="left_bottom" align="center">17</td>
		</tr>
<?
	// }
?>
	</table>
<font size="-2">��������� � ���������� �� ������� ����� �����&������ �� ����� "����� �������� ��" ����.</font>
</body>
</html>