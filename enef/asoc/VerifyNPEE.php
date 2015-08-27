<?php
include("../inc/conf.php");
?>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
  <meta http-equiv="Content-Language" content="bg">
  <title>Избор на критерии</title>
  <script type="text/javascript" src="js/functions.js"></script>
</head>
<body background="Images/Stone.jpg" onload="<?php
if ($_SESSION['placement']!=$nasko)
{	echo('getRegion();onchangeraion();');
}else
{	echo('getRegion();');
}
?>">
  <!--<form name="fjournal" method="post">-->
  <form name = "fsearch_NPEE" method = "post" action = "PrintInquire.php?id=<?echo $_GET['id']?>">
    <center><font size="4" color="blue">Избор на критерии за търсене</font></center>
    <table width="100%" height="94%">
      <tr valign="top">
        <td height="90%">
          <table align="center" width="100%" border="1"> 
          <tr>
           <td>Идент.№ на сграда:</td>
			<td>
				<input type="text" name="build_identifyh" id="build_identifyh"/>
			</td>
		</tr>
		<tr>
			<td>Район:</td>
			<td id="raion_td"> 
				<select name="raion_sel" id="raion_sel" onchange="document.getElementById('str_search').value=''">
					<option value=""></option>
				</select>
			</td>
		</tr>
		
        <tr>
			<td>Населено място:</td>
			<td id="nasel_td"> 
				<select name="nasel_sel" id="nasel_sel">
					<option value=""></option>
				</select>
			</td>
		</tr>
        
          <tr>
			<td>Квартал:</td>
			<td id="hood_td">
				<select id="hood_sel" name="hood_sel">
					<option value=""></option>
				</select>
			</td>
		</tr>
        <tr>
			<td>ЖК:</td>
			<td id="jk_td"> 
				<select name="jk_sel" id="jk_sel">
					<option value=""></option>
				</select>
			</td>
		</tr>
      
		<tr>
			<td>Блок:</td>
			<td>
				<input type="text" name="build_numb" maxlength="4" id="build_numb"/>
			</td>
		</tr> 
          <tr><td colspan="2">Данни за сдружението</td></tr>
          <tr>
          <td>Регистрационен номер:</td>
				<td>
					<input type="hidden" name="hid_asoc_id" id="hid_asoc_id"/>
					<input type="text" name="asoc_numbh" id="asoc_numbh" maxlength="30"/>
				</td>
                <td rowspan="12"> <div><iframe class="popup" style="display:none; z-index:3; " id="popup3" name="popup3"></iframe></div></td>
			</tr>
			<tr>
				<td>
					Булстат:
				</td>
				<td>
					<input type="text" name="bulstath" id="bulstath"/>
                    <input type="hidden" name="str_search" id="str_search"/>
				</td>
			</tr>
			<tr>
				<td>Наименование:</td>
				<td width="55%">
					<input type="text" name="asoc_name"  id= "asoc_name" maxlength="40" value=""/>
          </td>
          </tr>
          <tr>
			<td>Статус на заявлението:</td>
			<td id="status"> 
				<select name="status" id="status">
					<option value=""></option>
				<?
	$sql = "SELECT * 
			FROM elements 
			WHERE nom_code = '05'";
	$res = sql_q($sql) or die(mysql_error());
	while($row = mysql_fetch_assoc($res))
	{	$sel .= "<option value='" . $row['cod_cod'] . "'>". $row['cod_name'] . "</option>";
	}
	echo $sel;
?>
                
                </select>
			</td>
		</tr>
          </table>
        </td>
      </tr>
      <tr valign="bottom">
        <td height="10%" align="right">
         <!-- <input type="button" name="search" value="Търсене" onclick="OpenWindow('PrintInquire.php?id=<?=$_GET['id']?>&from_date=' + from_date.value + '&to_date=' + to_date.value +'&mode3=' + mode3.value + '&mode4= ' + mode4.value + '&mode5=' + mode5.value + '&mode7= ' + mode7.value, '', 780, 460); window.close();">-->
         <input type="submit" name="submit" value="Търсене">
          <input type="button" name="exit" value="Изход" onclick="window.close()">
        </td>
      </tr>
    </table>
  </form>
</body>
</html>

