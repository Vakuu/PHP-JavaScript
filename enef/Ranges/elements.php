<?
	session_start();
######################################
# File: elements.php
# Last modified: 2005.10.07
# by Martin Lazarov
######################################
	include("../inc/conf.php");

	$range_code = $_GET['range_code'];
	$cod_name = $_POST['cod_name'];
	$elem_code = $_POST['elem_code'];
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
	<meta http-equiv="Content-Language" content="bg">
<script>
function showit(){
	$f = document.elements;
	$s = document.elements.elem_code;  
	$len = $s.length;
		for(var i = 0; i < $len; i++){
			if($s.options[i].selected == true){
				document.elements.fname.value = $s.options[i].text;
			}
		}
}
/* ************************************ BIB ************************************************************ */
	function enableEditDel(){
		var range_code = <?= $range_code?>;
			if(range_code != ''){
				document.getElementById('edit_element').disabled = false;
				document.getElementById('del_element').disabled = false;
			}
	}
	
	function enableAdd(){
		var range_code = <?= $range_code?>;
		var cod_name = document.getElementById('cod_name').value;
			for(var i = 0; i < cod_name.length; i++){
				if(cod_name == ''){
					document.getElementById('add_element').disabled = true;
				}
			}
			if(range_code != ''){
				document.getElementById('add_element').disabled = false;
			}
			
			if(cod_name == ''){
				document.getElementById('add_element').disabled = true;
				document.getElementById('edit_element').disabled = true;
			}
	}
/* ***************************************************************************************************** */
</script>
<style>
select{
	border: 1px solid Gray;
}

select.choice_element{
	margin-left: 0px; 	
	text-align: left;
	overflow: auto;
	width: 95%;
	height: 80%; 
	color: Green; 
}
</style>       
</head>

<body background = "../Images/Stone.jpg">
	<form name="elements" method="post" border="0">
<?php
	$result = sql_q("SELECT * FROM ranges WHERE nom_cod = '$range_code'");
	$row = mysql_fetch_array($result);
		if(!empty($row)){$range_name = ", ".$row["nom_name"];}
?>  
    
Елементи по номенклатура: <font color="blue"><?php echo $range_code.$range_name; ?></font>
    <hr style="clear:left;">
<?php
	if(($_POST['add_element']) || ($_POST['edit_element']) || ($_POST['del_element'])){
		$result = sql_q("SELECT nom_flag FROM ranges WHERE nom_cod = '$range_code'");
		$row = mysql_fetch_array($result);
    
		if($row[0] == 1){
			echo "<script language='JavaScript'> alert('Нямате права да извършвате промени.'); </script>";
		}else{
			if($_POST['add_element']){
				if(empty($cod_name)){
					echo "<script language='JavaScript'> alert('Грешка! Не е въведено наименование.'); </script>";
				}else{
					$result = sql_q("SELECT MAX(cod_cod) FROM elements WHERE nom_code = '$range_code'");
					$row = mysql_fetch_array($result);
					$increment = $row[0] + 1;
						sql_q("INSERT INTO elements VALUES('$range_code', $increment, '$cod_name')");
				}
			}elseif($_POST['edit_element']){
				if(empty($elem_code)){
					echo "<script language='JavaScript'> alert('Грешка! Не е избрано наименование.'); </script>";
				}else{
					sql_q("UPDATE elements SET cod_name = '$cod_name' WHERE nom_code = '$range_code' AND cod_cod = $elem_code");
				} 
			}elseif($_POST['del_element']){
				if(empty($elem_code)){
					echo "<script language='JavaScript'> alert('Грешка! Не е избрано наименование'); </script>";
            }else{
				sql_q("DELETE FROM elements WHERE nom_code = '$range_code' AND cod_cod = $elem_code");
            }
		}
    }
}
?>
<table border="0">
	<tr>
		<td align="left" valign=top>
			<label for="fname" accesskey="a">Н<U>а</U>именование</label>
				<input id="fname" type="text" name="cod_name" id="cod_name" size="30" onKeyUp="enableAdd()" />
		</td>
	</tr>
	<tr>
		<td align=right>
<?
	$result = sql_q("SELECT * FROM rights WHERE user_name = '$user_name'");
	$row_rights = mysql_fetch_array($result);

	if($row_rights["right_func"] != 2){
?>
		<input type="submit" name="add_element" value="Добавяне" disabled />
		<input type="submit" name="edit_element" value="Редактиране" disabled />
		<input type="submit" name="del_element" value="Изтриване" disabled />
<?
}else{
?>
		<input type="submit" name="add_element" value="Добавяне" disabled />
		<input type="submit" name="edit_element" value="Редактиране" disabled />
		<input type="submit" name="del_element" value="Изтриване" disabled />
<?
}
?>
		</td>
	</tr>
</table>
	<hr>
			<select name="elem_code" size="30" class="choice_element" onClick='showit();' onChange="enableEditDel()">
<?
	if($range_code != ''){
		$result = sql_q("SELECT * 
						 FROM elements 
						 WHERE nom_code = '$range_code' 
						 ORDER BY ASCII(UCASE(cod_name)), UCASE(cod_name) ASC");
	}
while($row = mysql_fetch_array($result)){
?>
	<option value="<?= $row['cod_cod'] ?>"><?= $row['cod_name'];?></option>
<?
}
?>
			</select>
		</form>
	</body>
</html>