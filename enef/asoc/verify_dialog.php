<?php
	include("inc/conf.php");
?>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
  <meta http-equiv="Content-Language" content="bg">
<title>
<?
	switch($_GET['id']){
		case 9: 
			echo "��������� ���� �� ������������ ���������";
				break;
		case 10: 
			echo "���� - ��������� ������������ �� ������ �� ���";
	}
?>
</title>
<link rel="stylesheet" type="text/css" href="css/verifyNPEE.css" />
<script type="text/javascript" src="js/functions.js"></script>
<script type="text/javascript">
	getRegion();
</script>
</head>
<body background="Images/Stone.jpg"onload="<?php
if ($_SESSION['placement']!=$nasko)
{	echo('getRegion();onchangeraion();');
}else
{	echo('getRegion();');
}
?>">
	<form id="reg_asocs" action="PrintInquire.php?id=<?=$_GET['id']?>" method="post" onsubmit="if(document.getElementById('req_id').value == 0){alert('���� �������� �������'); return false;}" name="reg_asocs">
		<table id="tbl1" border="1">
			<tr>
				<td colspan="2" align="center">
					<font size="4" color="blue">
						����� �� �������� �� �������
					</font>
				</td>
			</tr>
<?
	switch($_GET['id']){
	case 9:
?>
			<tr>
			<td colspan="2">
					�������: ��������� ���� �� ������������ ���������
				</td>
			</tr>
			<tr>
				<td title="���������������� ����� �� ������">
					�����. ����� �� ������:
				</td>
				<td title="���������������� ����� �� ������">
					<input type="text" name="ident_num" id="ident_num" />
				</td>
			</tr>
			<tr>
				<td title="�������������� ����� �� ���������">
					���. ����� �� ���������:
				</td>
				<td title="�������������� ����� �� ���������">
					<input type="text" name="ident_num_a" id="ident_num_a" />
				<input type="hidden" name="str_search" id="str_search"/>
                </td>
			</tr>
			<tr>
				<td>
					�����:
				</td>
				<td id="raion_td"> 
					<select id="raion_sel" name="raion_sel" onchange="document.getElementById('str_search').value=''"></select>
				</td>
			</tr>
			
            <tr>
			<td>�������� �����:</td>
			<td id="nasel_td"> 
				<select name="nasel_sel" id="nasel_sel">
					<option value=""></option>
				</select>
			</td>
		</tr>
            <tr>
				<td>
					�������:
				</td>
				<td id="hood_td"> 
					<select id="hood_sel" name="hood_sel"></select>
				</td>
			</tr>
      <tr>
			<td>��:</td>
			<td id="jk_td"> 
				<select name="jk_sel" id="jk_sel">
					<option value=""></option>
				</select>
			</td>
		</tr>
<?
	break;
}
?>
		</table>
		<table border="1" align="right" width="100%">
			<tr>
				<td colspan="2" align="right">
					<input type="submit" id="sub_btn" name="sub_btn" value="�������" />
                    &nbsp;
					<input type="button" id="close" name="close" value="�������" onclick="window.close();"/>				
				</td>
			</tr>
		</table>
	</form>
</body>
</html>