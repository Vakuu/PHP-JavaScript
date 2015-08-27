<?php
	include_once "../inc/conf.php";
?>
<!DOCTYPE html>
<html>
<head>
	<title>Добавяне в календара</title>
<style type="text/css">
table{
/*	margin-left: auto;
	margin-right: auto;*/
	width: 100%;
}

input{
	text-align: center;
}

.hide{
	display: none;
}
</style>
<script src="js/jquery-1.11.2.min.js"></script>
<script type="text/javascript">
function thisYear(id){
//this year
	var date = new Date();
	var thisYear = date.getFullYear();
		document.getElementById(id).value = thisYear;
}

function checkDate(id){
//проверява за коректното въвеждане на датите 
	pattern = /^(0?[1-9]|[12][0-9]|3[01])[\/\-](0?[1-9]|1[012])[\/\-]\d{4}$/;
		if((document.getElementById(id).value !== '') && (document.getElementById(id).value.match(pattern))){
			return true;
		}else{
			alert('Невалидна дата');
			document.getElementById(id).value = '';
			document.getElementById(id).focus();
		}
}
	
function createElements(){
//създаване на 4 реда с полета за въвеждане
	document.getElementById('del').className = "";	
	var date = new Date();
	var thisYear = date.getFullYear();
	var table = document.getElementById('calendar_table');
	var row = table.insertRow(3);//kude v tablicata da insert-ne noviq tr
	var cell1 = row.insertCell(0);
	var cell2 = row.insertCell(1);
	var cell3 = row.insertCell(2);
	var cell4 = row.insertCell(3);
	var cell5 = row.insertCell(4);
	var lastRow = table.rows.length  - 3;
		var chbox = document.createElement('input');
			chbox.type = "checkbox";
			chbox.setAttribute('id', 'chbox' + lastRow);
			chbox.setAttribute('name', 'check' + lastRow);
			// chbox.checked = true; // дали да са чекнати по default
			if(document.getElementById('check1').value == '1'){chbox.value = lastRow;}
			cell1.appendChild(chbox);
			
		var year = document.createElement('input');
			year.type = "text";
			year.setAttribute('id', 'year' + lastRow);
			year.setAttribute('name', 'year' + lastRow);
			year.value = thisYear;
			cell2.appendChild(year);
			
		var rest_day = document.createElement('input');
			rest_day.type = "text";
			rest_day.setAttribute('id', 'rest_day' + lastRow);
			rest_day.setAttribute('name', 'rest_day' + lastRow);
			rest_day.setAttribute('class', 'rest_day');
			cell3.appendChild(rest_day);
			
		var work_day = document.createElement('input');
			work_day.type = "text";
			work_day.setAttribute('id', 'work_day' + lastRow);
			work_day.setAttribute('name', 'work_day' + lastRow);
			work_day.setAttribute('class', 'work_day');
			work_day.value = "";
			cell4.appendChild(work_day);
			
		var reason = document.createElement('textarea');
			reason.cols = 31;
			reason.rows = 4;
			reason.setAttribute('id', 'reason' + lastRow);
			reason.setAttribute('name', 'reason' + lastRow);
			reason.value = "";
			cell5.appendChild(reason);

		$('#addRow').click(function(){
			if(lastRow == 5){
				$(this).attr('disabled', true);
			}else{
				$(this).attr('disabled', false);
			}
		});

}

function checkDatesAndCallAjax(){
	var date = new Date();
	var d = (date.getDate()) < 10 ? '0' + (date.getDate()) : (date.getDate());
	var m = (date.getMonth() + 1) < 10 ? '0' + (date.getMonth() + 1) : (date.getMonth() + 1);
	var y = date.getFullYear();
	var now = d + '-' + m + '-' + y;
	
	for(var i = 1; i < 6; i++){
		if((convertDate(document.getElementById('rest_day' + i).value) == '') && (convertDate(document.getElementById('work_day' + i).value) == '')){
			alert('Моля въведете дати');
			return false;
		}else{
			if(convertDate(document.getElementById('rest_day' + i).value) > convertDate(document.getElementById('work_day' + i).value)){
				alert('Датата за почивен ден неможе да бъде по-голяма от датата за отработване');
				return false;
			}else if(convertDate(document.getElementById('rest_day' + i).value) == convertDate(document.getElementById('work_day' + i).value)){
				alert('Датите немогат да бъдат еднакви!');
				return false;
			}else if(convertDate(document.getElementById('work_day' + i).value) < convertDate(now)){
				alert('Неможе да се въведе дата на отработване за отминал период,моля въведете дата след ' + now);
				return false;
			}else if(document.getElementById('reason' + i).value == ''){
				alert('Моля въведете основание');
				return false;
			}else{
				//ajax
				var listQ = $('#calendar_form').serialize();
				var ajax = new XMLHttpRequest();
					ajax.open('GET', 'calendar_save.php?' + decodeURIComponent(listQ), false);
						ajax.onreadystatechange = function(){
							if((ajax.readyState == 4) && (ajax.status == 200)){
								if(ajax.responseText == 'good'){
									alert('Успешен запис');
									return false;
								}else{
									alert('Не може да се извърши запис');
									return false;
								}
							}
						}
				ajax.send(null);
				return ajax.responseText;
			}
		}//end if
	}//end loop
}

function convertDate(d){
// връща датите във формат гггг-мм-дд
	pattern = /^(0?[1-9]|[12][0-9]|3[01])[\/\-](0?[1-9]|1[012])[\/\-]\d{4}$/;
	date = d;
		if(date.match(pattern)){
			date = date.split('-');
			newdate = date[2] + '-' + date[1] + '-' + date[0];
			return newdate;
		}else{
			return false;
		}
}

function clearForm(){
	var els = document.calendar_form.elements;
	var txtareas = document.getElementsByTagName('textarea');
		for(var i = 0; i < els.length; i++){
			// console.log(document.calendar_form.elements[i].name); // в конзолата изкарва всички атрибути name
				if(els[i].getAttribute('type') == 'text'){
					if((els[i].getAttribute('id') !== 'year') && (els[i].getAttribute('id') !== 'year2') && 
						(els[i].getAttribute('id') !== 'year3') && (els[i].getAttribute('id') !== 'year4') && 
						(els[i].getAttribute('id') !== 'year5')){
							els[i].value = '';
					}
				}
		for(var j = 0; j < txtareas.length; j++){
			if(txtareas[j].value !== ''){
				txtareas[j].value = '';
			}
		}
	}
}

$(document).ready(function(){
		$('#del').click(function(){
			$('#calendar_table').find('input[type=checkbox]').each(function(){
				if($(this).is(':checked') && ($(this).val() !== '1')){
					$(this).parents('tr').remove();
					$('#addRow').attr('disabled', false);
						table = document.getElementById('calendar_table');
						lastRow = table.rows.length;
			}
		});
	});
});
</script>
</head>

<body background="../Images/Stone.jpg" onLoad="thisYear('year')">
	<form name="calendar_form" id="calendar_form">
		<table border="2" id="calendar_table">
			<tr>
				<td colspan="5" align="center">
					<font color="#FF3300">Моля въведете датата в формат ден-месец-година (25-06-2008)</font>
				</td>
			</tr>
			<tr>
				<td>
					&nbsp;
				</td>
				<td align="center">
					Година
				</td>
				<td align="center">
					Извънреден почивен ден
				</td>
				<td align="center">
					Извънреден работен ден
				</td>
				<td align="center">
					Основание
				</td>
			</tr>
			<tr>
				<td align="center">
					<input type="checkbox" id="check1" name="check1" value="1" checked />
				</td>
				<td align="center">
					<input type="text" id="year" name="year" />
				</td>
				<td align="center">
					<input type="text" id="rest_day1" name="rest_day" class="rest_day" value="" />
				</td>
				<td align="center">
					<input type="text" id="work_day1" name="work_day" class="work_day" value="" />
				</td>
				<td align="center">
					<textarea rows="4" cols="31" name="reason" id="reason1"></textarea>
				</td>
			</tr>
			<tr>
				<td colspan="5" align="right">
					<input type="button" name="save" id="save" value="Запази" onclick="checkDatesAndCallAjax();"/>
					<input type="button" name="addRow" id="addRow" value="Добави нов ред" onClick="createElements();"/>
					<input type="button" name="del" id="del" class="hide" value="Изтрий ред" />
					<input type="button" name="reset" id="reset" class="reset" value="Изчисти" onClick="clearForm();" />
					<input type="button" name="exit" id="exit" value="Изход" onClick="window.close();"/>
				</td>
			</tr>
		</table>
	</form>
</body>
</html>