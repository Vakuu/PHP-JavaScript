<?php
include("../inc/conf.php");
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
  <meta http-equiv="Content-Language" content="bg">
<title>������������ �� ���������</title>
<link rel="stylesheet" href="css/register_bib.css"/>
<style>
body{background-image: url('images/Stone.jpg');}
</style>
<script type="text/javascript" src="js/functions.js"></script>
<script type="text/javascript" src="../Administrative/JFunctions.js"></script>
<script type="text/javascript" src="js/jQuery1.11.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	getRegion();
<?php
if ($_SESSION['placement']!=$nasko)
{	echo('onchangeraion();');
}
?>
	constructionType();
	getActivity();
	getPredst();
	getRepresentators();
	getLength('sdruj_name');
	var today = new Date();
	var min = 1940;
	var max = today.getFullYear();
	var sel = document.getElementById('year_of_const');
	var opt = document.createElement('option');
	opt.value = '';
	opt.innerHTML = '';
	sel.appendChild(opt);
	for(var i = max; i >= min; i--)
	{	var opt = document.createElement('option');
		opt.value = i;
		opt.innerHTML = i;
		sel.appendChild(opt);
	}
	FORM_CHANGEb = false;
	FORM_CHANGEa = false;
	FORM_CHANGEp = false;
	$('#build_form').on('change', function(){
		FORM_CHANGEb = true;
	});
		$('#curedit').click(function(){
			if(FORM_CHANGEb){
				var formId = $('#build_form').attr('id');
				var btnId = $('#curedit').attr('id');
					validateForm(formId, btnId);
			}else{
				alert('�� ��� ��������� �������!');
			}
		});
	$('#asoc_form').on('change', function(){
			FORM_CHANGEa = true;
	});
		$('#curedita').click(function(){
			if(FORM_CHANGEa){
				var formId = $('#asoc_form').attr('id');
				var btnId = $('#curedita').attr('id');
						validateForm(formId, btnId);
			}else{
				alert('�� ��� ��������� �������!');
			}
		});
	$('#represents').on('change', function(){
			FORM_CHANGEp = true;
	});
		$('#cureditp').click(function(){
			if(FORM_CHANGEp){
				var formId = $('#represents').attr('id');
				var btnId = $('#cureditp').attr('id');
				validateForm(formId, btnId);
			}else{
				alert('�� ��� ��������� �������!');
			}
		});
});
</script>
</head>

<body>
<!--<img src="images/es.jpg" alt="header" id="header" /><!-- header -->
<input type="button" value="�����" name="back" id="back" onclick="location.href='index.php'"/>
<input type="button" value="������" name="modules" id="modules" onclick="location.href='../Modules.php'"/>
<input type="button" value="�����" name="exit" id="exit" onclick="location.href='../Logout.php'"/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;����������:
<? echo(' '.$_SESSION['username']);
	if ($_SESSION['placement']!=$nasko)
	{	$res=mysql_fetch_assoc(sql_q("select show_cod, region_name from regions where show_cod='".$_SESSION['placement']."'"));
		$show_cod=$res['show_cod'];
		if ($show_cod<10)
		{$show_cod='0'.$show_cod;}
		echo(', �-� '.$show_cod.' '.$res['region_name']);
	}else
	{	echo(' - �������� ������');
		$show_cod='06';
	}
?>
<div id="container">
	<div id="build_container">
		<table>
			<tr>
				<td>
					<input type="button" style="font-weight:bold" value="+" id="build_btn" onclick="displayHide(document.getElementById('build_form_container'), this.value);" />
				</td>
				<td>
					<font color="magenta"><b>������</b></font>
				</td>
				<td>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				</td>
				<td>
					����� �� ������<span class="red">*</span><br />
					<input type="text" name="build_identify" id="build_identify"
						onkeyup="
						if (this.value!='')
						{	displayHide(document.getElementById('build_form_container'), '+');
							document.forms['asoc_form'].reset();
							document.forms['represents'].reset();
							getOverIt();
							document.forms['rq_form'].reset();
							document.getElementById('contr_zaqv').className='hide';
							document.getElementById('asoc_ident_rn').value='';
							document.getElementById('asoc_ident_b').value='';
							ifbuild('like');
							ifasoc('like');
						}else
						{	document.forms['build_form'].reset();
							document.forms['asoc_form'].reset();
							document.forms['represents'].reset();
							getOverIt();
							document.forms['rq_form'].reset();
							document.getElementById('contr_zaqv').className='hide';
							document.getElementById('autocompleteb').innerHTML='';
							document.getElementById('autocompletea').innerHTML='';
							document.getElementById('hid_asoc_id').value='';
							document.getElementById('asoc_ident_rn').value='';
							document.getElementById('request_container').className='hide';
							displayHide(document.getElementById('build_form_container'), '-');
						}"
						/> �������: <u>68134.512.205.2</u> ; <u><?=$show_cod?>.2</u>
					<input type="hidden" name="bselected" id="bselected" value=""/>
					<div id="autocompleteb">
					</div>
				</td>
			</tr>
		</table>
	</div>				
	<div id="build_form_container" class="hide"><!-- tova da se skrie -->
		<form id="build_form" name="build_form" method="" action="">
			<?include("BuildForm.php");?>
		</form>
	</div>
<div id="association_plus_people_container">
	<font color="magenta"><b>���������</b></font>
	<table border="3" bordercolor="green">
	<tr><td>
	<div id="association_container">
		<table>
			<tr>
				<td>
					<input type="button" style="font-weight:bold" value="+" id="association_btn" onclick="displayHide(document.getElementById('association_form_container'), this.value);" />
				</td>
				<td>
					<font color="maroon"><b>����� �� ���������</b></font>
				</td>
				<td>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				</td>
				<td>
					���. �����:<span class="red">*</span><br />
					<span id="esso"></span>
					<input type="text" name="asoc_ident_rn" id="asoc_ident_rn" value="" style="width:95px;"
					onkeyup="
					//if ((this.value!='')||(document.getElementById('asoc_ident_b').value!=''))
					if (this.value!='')
					{	displayHide(document.getElementById('association_form_container'), '+');
						document.forms['represents'].reset();
						getOverIt();
						document.forms['rq_form'].reset();
						document.getElementById('contr_zaqv').className='hide';
						ifasoc('like');
					}else
					{	document.forms['asoc_form'].reset();
						document.forms['represents'].reset();
						getOverIt();
						document.forms['rq_form'].reset();
						document.getElementById('contr_zaqv').className='hide';
						document.getElementById('request_container').className='hide';
						displayHide(document.getElementById('association_form_container'), '-');
					}
					"
					/> ������: ����02-13-0015
					<input type="hidden" name="aselected" id="aselected" value=""/>
				</td>
				<td>
					<!--�������:<br />-->
					<input type="hidden" name="asoc_ident_b" id="asoc_ident_b"
					onkeyup="
					if ((this.value!='')||(document.getElementById('asoc_ident_rn').value!=''))
					{	displayHide(document.getElementById('association_form_container'), '+');
						ifasoc('like');
					}else
					{	document.forms['asoc_form'].reset();
						displayHide(document.getElementById('association_form_container'), '-');
					}"
					onclick="
					if ((this.value!='')||(document.getElementById('asoc_ident_rn').value!=''))
					{	displayHide(document.getElementById('association_form_container'), '+');
						ifasoc('like');
					}else
					{	document.forms['asoc_form'].reset();
						displayHide(document.getElementById('association_form_container'), '-');
					}"
					onfocus="
					if (document.getElementById('build_identify').value=='')
					{	alert('���� ����� �������� ���� �������� ������, �� �� �� ���� ��� ��� ������ � �����������!')
						document.getElementById('build_identify').focus();
					}else
					{	if ((this.value!='')||(document.getElementById('asoc_ident_rn').value!=''))
						{	displayHide(document.getElementById('association_form_container'), '-');
						}
					}"/>
				</td>
			</tr>
			<tr>
				<td colspan="3">
					&nbsp;
				</td>
				<td colspan="2">
				<div id="autocompletea">
				</div>
				</td>
			</tr>
		</table>
	</div>
	<div id="association_form_container" class="hide"><!-- tova da se skrie -->
		<form id="asoc_form" name="asoc_form" method="" action="">
			<?include("AsocForm.php");?>
		</form>
	</div>
	<div id="people_container"><!-- tova da se skrie -->
		<table>
			<tr>
				<td>
					<input type="button" style="font-weight:bold;" value="+" id="represents_btn" onclick="displayHide(document.getElementById('people_form_container'), this.value)" />
				</td>
				<td>
					<font color="maroon"><b>����� �� ������� �� ���������</b></font>
				</td>
			</tr>
		</table>
	</div>
	<div id="people_form_container" class="hide"><!-- tova da se skrie -->
		<form id="represents" name="represents">
			<?include "hora.php";?>
		</form>
	</div>
	</td></tr>
	</table>
</div>
<div id="request_container" class="hide"><!-- zaqvlenie -->
	<form id="rq_form" method="get" name="rq_form" action="#"><!-- form na zaqvlenieto -->
		&nbsp;<font color="magenta"><b>��������� � ��������:</b></font>
		�� ���������:
		<?
		$sql = "SELECT * 
				FROM elements 
				WHERE nom_code = '51'";
		$res = sql_q($sql);
		$sel = "<select name='what_att' id='what_att'
					onchange='document.getElementById(\"manyrc\").value=\"\";
								document.getElementById(\"rq_numb\").value=\"\";
								document.getElementById(\"description\").value=\"\";
								document.getElementById(\"save_rq_button2\").disabled=true;
								document.getElementById(\"save_rq_button\").disabled=false;
								getwoman(this.value,\"status_section\");
								'
				>";
		$sel.= "<option value=''></option>";
		while($row = mysql_fetch_assoc($res))
		{	$sel.= "<option value='".$row['cod_cod']."'>".$row['cod_name']."</option>";
		}
		$sel.= "</select>";
		echo $sel;
		?>
		<input type="button" style="font-weight:bold;" id="save_rq_button" value="�����" onclick="validateForm('rq_form');" disabled />
		�� �����������:
		<span id="rq_co_table">
		<select name='no_name' id='no_name'>"
			<option value=''></option>
		</select>
		</span>
		<input type="button" style="font-weight:bold;" id="save_rq_button2" value="�����" onclick="validateForm('rq_form','vtori');" disabled />
		<div id="contr_zaqv" class="hide" style="margin-left:20px">
			<input type="hidden" name="doc_hid_id" id="doc_hid_id"/>
			�<input type="text" name="rq_numb" style="width:73px;" value="" id="rq_numb" />								
			<span id="reg_date"></span>
			<input type="text" name="theirs_date" maxlength="10" style="width:73px;" value="<?=date('d-m-Y');?>" id="theirs_date"/>
			<span id="status_section_name">������:</span>
			<span id="status_section"><input type="text" name="theirs2_date" maxlength="10" style="width:73px;" value="" id="theirs2_date"/></span>
			<span id="type_section_name" class="hide"></span>
			<span id="type_section" class="hide">
				<select name='doc_type' id='doc_type'>"
				<option value=''></option>
				</select>
			</span>
			&nbsp;<span id="acc_rej_date"></span>
			<br />			
			��������:<textarea name="description" cols="70" class="cyrullic" rows="1" id="description" /></textarea>
		</div>
		<div id="asoc_list" class="hide">
		</div>
	</form>
	<div id="docs_container">
		<table id="docs_tbl">
			<tr>
				<td>
					<input type="button" style="font-weight:bold" id="docs_btn" name="docs_btn" onclick="preebeteMiITaqFunc(document.getElementById('docs_area').id, this.value);" value="+">
				</td>
				<td>
					<font color="magenta"><b>�������� ���������:</b></font>
				</td>
			</tr>
		</table>
	</div>
	<div id="docs_area" class="hide">
		<? include "docs_form.php";?>
	</div>
</div>
<script>
//class cyrullic
// ����� � ����� ������� �� ��� ����� � gmail.com? 
// - gmail@chucknorris.com
$('.cyrullic').keypress(function(e){
	var verified = String.fromCharCode(e.which).match(/[a-zA-Z]/);
		if (verified) {
			alert('���� ������ �� ��������!');
			e.preventDefault();
		}	
});

$('.cyrullica').keypress(function(e){
	var verified = String.fromCharCode(e.which).match(/[�-�,�-�]/);
		if(verified){
		}else{
			alert('����������� �� ����� ��� �������� ����� � ���������! ���� �������� ����� �� �������� ��������� ��� �������');
			e.preventDefault();
		}
});
</script>
</body>
</html>