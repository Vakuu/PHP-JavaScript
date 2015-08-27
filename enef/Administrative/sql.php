<?
	include("../inc/conf.php");
	include('header.php');
	header("Content-type: text/html; charset=windows-1251");
?>
<!DOCTYPE html>
<html>
<meta charset="utf-8" />
<head>
<style type="text/css">
fieldset{ width: 200px; border: none;}
</style>
<script type="text/javascript">
function beginPage(){
	document.location.href = "Index.html";
}

function callAjax(){
	var ajax = new XMLHttpRequest();
	var sql = document.getElementById('sql').value;
		// alert(encodeURI(sql));
	if(sql != ''){
		ajax.open('POST', 'sql2.php', true);
		ajax.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		ajax.onreadystatechange = function(){
			if(ajax.readyState == 4 && ajax.status == 200){
				// alert(decodeURIComponent(ajax.responseText));
				var result = ajax.responseText;
				// alert(result);
					if(result !== ''){
						document.getElementById('res').style.width = '680px';
						document.getElementById('res').style.border = '1px solid black';
						document.getElementById('res').style.height = '300px';
						document.getElementById('res').style.overflowY = 'scroll';
						document.getElementById('res').style.paddingLeft = '5px';
						document.getElementById('res').style.paddingRight = '5px';
						document.getElementById('res').innerHTML = decodeURIComponent(result).replace(/\+/g, ' ');
						document.getElementById('sql').value = '';
					}
			}
		}
		var data = 'data=' + sql;
		ajax.send(data);
	}else{
		alert('Моля, въведете заявки за изпълнение!');
		return false;
	}
}
</script>
</head>

<body>
	<div id="container" align="center">
		<form name="form" id="form">
			<fieldset>
			<legend><b>MySQL Admin</b></legend>
					<textarea id="sql" cols="80" rows="14" name="sql"></textarea>
			</fieldset>
		</form>
			<div id="res" align="left" width="680px"></div>
				<br/>
		<div id="btns">
			<input type="button" id="run" value="Изпълни" onClick="callAjax()"/>
			<input type="button" id="exit" value="Начало" onClick="beginPage();"/>
		</div>
	</div>
</body>
</html>