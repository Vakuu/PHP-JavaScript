<?php
   include_once("../inc/conf.php");
?>
<html>
<head>
<style type="text/css">
table{width: 100%;text-align: center;}
#container{width: 100%;height: 100%;}
#result_container{width: 100%;overflow-y: auto;height:93%;}
#table_results{width: 100%;text-align: center;}
.right{float: right;}
</style>
</head>
<body background='../Images/Stone.jpg'>
	<div id="container">
		<div id="result_container">
<?php
	if(isset($_POST['id'])){
		$id_d=$_POST['id'];
		$query_del = "DELETE FROM calendar WHERE id = $id_d";
		$result = sql_q($query_del);
		if($result){
			echo "<font color='#ff33aa'>Записът е изтрит успещно</font><br>";
		}else{
			echo "<font color='#ff0000'>Има проблем със системата. Моля оведомете BHS !!!</font><br>";
		}
	}
?>
<table border="1">
	<tr>
		<td>№</td>
		<td>Година</td>
		<td>Извънреден почивен ден</td>
		<td>Извънреден работен ден</td>
		<td>Основание</td>
		<td>Изтриване</td>
	</tr>
<?php
$query = "select id, year, date_format(extra_work_day, '%d-%m-%Y') as ewd, date_format(extra_not_work_day, '%d-%m-%Y') as enwd, reason
 from calendar order by extra_not_work_day";
$result = sql_q($query);
if(mysql_num_rows($result)==0)
{echo "<tr><td colspan='6'><font color='#ff0000'>Не са намерени записи в БД</font></td></tr>";}
else{ $br = 1;
while($arr = mysql_fetch_assoc($result))
{
$id = $arr['id'];
$year = $arr['year'];
$e_w_day = $arr['ewd'];
$e_n_w_day = $arr['enwd'];
//tablicata e doopravena
if(!empty($arr['reason'])){
	$osnovanie = $arr['reason'];
}else{
	$osnovanie = "&nbsp;";
}

echo "<form name = del action=calendar_update.php method=post><tr><td>$br</td><td>$year</td><td>$e_n_w_day</td><td>";
if($e_w_day!='00-00-0000'){echo $e_w_day;}else {echo "не се отработва";}
echo "</td><td>$osnovanie</td>";
//$date = date();
if($e_n_w_day > date("Y-m-d"))
{
echo "<input type='hidden' name='id' value='".$id."'>";
echo "<td><input type='submit' name='subm_zap' value='Изтрий'/></td></tr></form>";
}else{
echo "<td><input type='submit' name='subm_zap' value='Изтрий' disabled='disabled' /></td></tr></form>";
}
$br++;
}
}
?>
				</table>
			</div><br/>
		<input type="button" onClick="window.close();" class="right" value="Затвори" />
	</div>
</body>
</html>