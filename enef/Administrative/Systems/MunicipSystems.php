<?php
  include("../../inc/conf.php");
$check_for_minusOne = sql_q("Select * from municipality where placement='-1'");
    if(mysql_num_rows($check_for_minusOne)>0)
    {  
    ?>
        <script language='javascript'>
        //showModalDialog('selectKingdom.php', null, 'dialogWidth:9px;dialogHeight:10px;resizable:yes;center:yes');//window.close();
         window.close();
         window.open('selectKingdom.php','name','height=50,width=50,toolbar=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=no,modal=1 center=yes');
        document.window.focus();
        </script>                                
        <?}

$sql = "SELECT PValue FROM `system_parameters` where PName = 'kasier_nareditel';";
$resv = mysql_fetch_array(sql_q($sql));
$resv = $resv[0];
if (isset($_GET['che']))
{	$resv = $_GET['che'];
	sql_q("update `system_parameters` set `PValue`='".$resv."' where PName = 'kasier_nareditel';");
	if ($resv == 0) {$focus='ob6tina_nareditel';}
	if ($resv == 1) {$focus='kasier_nareditel';}
	if ($resv == 2) {$focus='idob6tina_kasier_nareditel';}
}else
{	$focus='municipality';
}

if ($_POST['add_x'])
{	
    $placement =$_POST['placement'];
    $municipality = $_POST['municipality'];
	$ifmuni = $_POST['ifmuni'];
	$ifmayor = $_POST['ifmayor'];
	$mayor = $_POST['mayor'];
	$accountant = $_POST['accountant'];
	$mol = $_POST['mol'];
	$bulstat = $_POST['bulstat'];
	$dds_id = $_POST['dds_id'];
	$rate_numb = $_POST['rate_numb'];
	$ensure_numb = $_POST['ensure_numb'];
	$post_code = $_POST['post_code'];
	$populated_towns = $_POST['populated_towns'];
	$address = $_POST['address'];
	$phone_fax = $_POST['phone_fax'];
	$email = $_POST['email'];
	$bank_name = $_POST['bank_name'];
	$bank_branch = $_POST['bank_branch'];
	$bank_address = $_POST['bank_address'];
	$bank_code = $_POST['bank_code'];
	$bank_account = $_POST['bank_account'];
	$dds_bank_name = $_POST['dds_bank_name'];
	$dds_bank_branch = $_POST['dds_bank_branch'];
	$dds_bank_address = $_POST['dds_bank_address'];
	$dds_bank_code = $_POST['dds_bank_code'];
	$dds_bank_account = $_POST['dds_bank_account'];
	$date = split("-", $_POST['registration_date']);
	$registration_date = $date[2]."-".$date[1]."-".$date[0];
	$date = split("-", $_POST['re_registration_date']);
	$re_registration_date = $date[2]."-".$date[1]."-".$date[0];
	$dds_percent = $_POST['dds_percent'];
	$point_interest_percent = $_POST['point_interest_percent'];
	$start_work_h = $_POST['start_work_h'];
	$start_work_m = $_POST['start_work_m'];
	$start_lunch_h = $_POST['start_lunch_h'];
	$start_lunch_m = $_POST['start_lunch_m'];
	$end_lunch_h = $_POST['end_lunch_h'];
	$end_lunch_m = $_POST['end_lunch_m'];
	$end_work_h = $_POST['end_work_h'];
	$end_work_m = $_POST['end_work_m'];
	$pay_system = $_POST['pay_system'];
//	$result = sql_q("SELECT * FROM municipality"); //raboteshta do 02.2014 г. - преди връзката касиер населено място да бъде изградена
    //Добавено във връзка с отдалечени работни места от Петко Михайлов 02.2014г.
    	$result = sql_q("SELECT * FROM municipality where placement='$placement' ");
	
    $row_num = mysql_num_rows($result);
	
    if (empty($row_num)) {
      sql_q("INSERT INTO municipality
                   VALUES('$municipality', '$ifmuni', '$ifmayor', '$mayor', '$accountant', '$mol', '$bulstat', '$dds_id', '$rate_numb', '$ensure_numb', '$post_code',
                          '$populated_towns', '$address', '$phone_fax', '$email', '$bank_name', '$bank_branch', '$bank_address',
                          '$bank_code', '$bank_account', '$dds_bank_name', '$dds_bank_branch', '$dds_bank_address', '$dds_bank_code',
                          '$dds_bank_account', '$registration_date', '$re_registration_date', '$dds_percent', '1', '$point_interest_percent', 
                          '$start_work_h','$start_work_m','$start_lunch_h','$start_lunch_m','$end_lunch_h','$end_lunch_m',
                          '$end_work_h','$end_work_m','$pay_system','$placement')");
    } else {
      sql_q("UPDATE municipality
                   SET municipality = '$municipality', ifmuni = '$ifmuni', ifmayor = '$ifmayor', mayor = '$mayor', accountant = '$accountant', mol = '$mol',
                       bulstat = '$bulstat', dds_id = '$dds_id', rate_numb = '$rate_numb', ensure_numb = '$ensure_numb', post_code = '$post_code',
                       populated_towns = '$populated_towns', address = '$address', phone_fax = '$phone_fax', email = '$email',
                       bank_name = '$bank_name', bank_branch = '$bank_branch', bank_address = '$bank_address', bank_code = '$bank_code',
                       bank_account = '$bank_account', dds_bank_name = '$dds_bank_name', dds_bank_branch = '$dds_bank_branch',
                       dds_bank_address = '$dds_bank_address', dds_bank_code = '$dds_bank_code',
                       dds_bank_account = '$dds_bank_account', registration_date = '$registration_date',
                       re_registration_date = '$re_registration_date', dds_percent = '$dds_percent', point_interest_percent='$point_interest_percent', 
                       start_work_hour = '$start_work_h', start_work_minute = '$start_work_m', start_lunch_hour = '$start_lunch_h',
                       start_lunch_minute = '$start_lunch_m', end_lunch_hour = '$end_lunch_h', end_lunch_minute = '$end_lunch_m',
                       end_work_hour = '$end_work_h', end_work_minute = '$end_work_m', pay_system = '$pay_system' where placement='$placement'");
    }
    echo "<script language='JavaScript'> window.close(); </script>";
  }else{
    if ($_POST['getPlacement'])
    {   $placement =$_POST['getPlacement'];
    }else
    {$placement= $_SESSION['placement'];}
  }

  $result = sql_q("SELECT municipality, ifmuni, ifmayor, mayor, accountant, mol, bulstat, dds_id, rate_numb, ensure_numb,
                                post_code, populated_towns, address, phone_fax, email, bank_name, bank_branch,
                                bank_address, bank_code, bank_account, dds_bank_name, dds_bank_branch,
                                dds_bank_address, dds_bank_code, dds_bank_account, date_format(registration_date, '%d-%m-%Y'),
                                date_format(re_registration_date, '%d-%m-%Y'), dds_percent, point_interest_percent, start_work_hour, start_work_minute,
                                start_lunch_hour, start_lunch_minute, end_lunch_hour, end_lunch_minute, end_work_hour, end_work_minute, pay_system,'placement'
                         FROM municipality where placement='$placement'");
  $row = mysql_fetch_array($result);
  $res_ifmuni = sql_q("SELECT * FROM elements WHERE nom_code = '65' and cod_cod='".$row['ifmuni']."'");
  $row_ifmuni = mysql_fetch_assoc($res_ifmuni);
  $ifmuni=$row_ifmuni['cod_name'];
  $res_ifmayor = sql_q("SELECT * FROM elements WHERE nom_code = '66' and cod_cod='".$row['ifmayor']."'");
  $row_ifmayor = mysql_fetch_assoc($res_ifmayor);
  $ifmayor=$row_ifmayor['cod_name'];
?>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
  <meta http-equiv="Content-Language" content="bg">

  <title>Данни за <?=$ifmuni?></title>

  <script language="JavaScript" src="../JFunctions.js"></script>
</head>
<body background="../Images/Stone.jpg" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="document.getElementById('<?=$focus?>').focus()">
  <form name="fmunicip_systems" action="MunicipSystems.php" method="post">
    <table width="100%" height="100%">
      <tr valign="top">
        <td height="90%">
          <fieldset>
            <legend>Данни за <?=$ifmuni?></legend>
            <div style="height:420px; overflow-y:scroll;">
              <table align="center" width="100%" height="80%" border="1">
                <tr><td align="right">Населено място</td><td> <select name="placement" id="placement" onchange="document.getElementById('getPlacement').value = document.getElementById('placement').value;fmunicip_systems.submit();">
                <?php 
                
                $naselm = "SELECT * FROM elements WHERE nom_code ='06' ORDER BY cod_cod ASC"; //Petko Mihailov-programist Dobaveno vuv vruzka na kasieri s naseleni mesta
                $get_code_name = sql_q($naselm);
                $selected='';
                while($row2=mysql_fetch_array($get_code_name))
                {   if  ($_POST['getPlacement'])
                    {   if ($_POST['getPlacement']==$row2['cod_cod'])
                        {$selected = ' selected';
                        }else{$selected='';}
                    }else
                    {   if ($_SESSION['placement']==$row2['cod_cod'])
                        {$selected = ' selected';
                        }else{$selected='';}
                    }
                    echo "<option value ='".$row2['cod_cod']."'".$selected.">".$row2['cod_name']."</option>";   
                }
                
                //$get_placement = "select placement from users where id='".$user_id."'";
                //$placenemt = sql_q($get_placement);
                
                
                
                
                ?>
                </select>
                <input type="hidden" name="getPlacement" id="getPlacement" value="<?=$pla1;?>"/>
                </td>
                </tr>
                <tr>
                  <!--<td align="right" width="45%">Община:</td>-->
                  <td>
                    <select name="ifmuni" style = "width:100%; text-align: left;">
                      <option value=""></option>
							<?
								$result = sql_q("SELECT * FROM elements WHERE nom_code = '65' ORDER BY ASCII(UCASE(cod_name)), UCASE(cod_name)");
								while ($row_elem = mysql_fetch_array($result))
								{	$length=round(2.4*(26-strlen($row_elem['cod_name'])));
									$str=$row_elem['cod_name'];
									for ($i=0;$i<=$length;$i++)
									{	$str = '&nbsp;'.$str;}
									if ($row_elem['cod_cod'] == $row['ifmuni'])
									{
							?><option value="<?=$row_elem['cod_cod']?>" selected><? echo($str);?></option><?
									}else
									{
							?><option value="<?=$row_elem['cod_cod']?>"><? echo($str);?></option><?
									}
								}
							?>
                    </select>
                  </td>
                  <td width="55%"><input type="text" name="municipality" id="municipality" size="20%" maxlength="40" value="<?=htmlspecialchars($row['municipality'], ENT_QUOTES)?>"><input type="radio" class="text" name="ob6tina_kasier_nareditel" id="ob6tina_nareditel" value="0" onclick="window.location.href='MunicipSystems.php?che=0';" <?if ($resv==0) echo('checked');?>> Наредител</td>
                </tr>
                <tr>
                	<!--<td align="right">Кмет:</td>-->
                  <td>
                    <select name="ifmayor" style = "width:100%; text-align: left;">
                      <option value=""></option>
							<?
								$result = sql_q("SELECT * FROM elements WHERE nom_code = '66' ORDER BY ASCII(UCASE(cod_name)), UCASE(cod_name)");
								while ($row_elem = mysql_fetch_array($result))
								{	$length=round(2.4*(26-strlen($row_elem['cod_name'])));
									$str=$row_elem['cod_name'];
									for ($i=0;$i<=$length;$i++)
									{	$str = '&nbsp;'.$str;}
									if ($row_elem['cod_cod'] == $row['ifmayor'])
									{
							?><option value="<?=$row_elem['cod_cod']?>" selected><? echo($str);?></option><?
									}else
									{
							?><option value="<?=$row_elem['cod_cod']?>"><? echo($str);?></option><?
									}
								}
							?>
                    </select>
                  </td>
                  <td><input type="text" name="mayor" size="40%" maxlength="40" value="<?=$row['mayor']?>" onKeyPress="ValidateKeyChar(this)"></td>
                </tr>
                <tr>
                  <td align="right">Главен счетоводител:</td>
                  <td><input type="text" name="accountant" size="40%" maxlength="40" value="<?=$row['accountant']?>" onKeyPress="ValidateKeyChar(this)"></td>
                </tr>
                <tr>
                  <td align="right">МОЛ:</td>
                  <td><input type="text" name="mol" size="40%" maxlength="40" value="<?=$row['mol']?>" onKeyPress="ValidateKeyChar(this)"></td>
                </tr>
                <tr>
                  <td align="right">Булстат:</td>
                  <td><input type="text" name="bulstat" size="20%" maxlength="13" value="<?=$row['bulstat']?>" onKeyPress="ValidateKeyNumb(this)"></td>
                </tr>
                <tr>
                  <td align="right">ИН по ДДС:</td>
                  <td><input type="text" name="dds_id" size="20%" maxlength="15" value="<?=$row['dds_id']?>"></td>
                </tr>
                <tr>
                  <td align="right">Данъчен номер:</td>
                  <td><input type="text" name="rate_numb" size="20%" maxlength="10" value="<?=$row['rate_numb']?>" onKeyPress="ValidateKeyNumb(this)"></td>
                </tr>
                <tr>
                  <td align="right">Осигурителен номер:</td>
                  <td><input type="text" name="ensure_numb" size="13%" maxlength="6" value="<?=$row['ensure_numb']?>" onKeyPress="ValidateKeyNumb(this)"></td>
                </tr>
                <tr>
                  <td align="right">Пощенски код:</td>
                  <td>
                  <?
                    if (empty($row['post_code'])) {
                      $get_post_code = "";
                    } else {
                      $get_post_code = $row['post_code'];
                    }
                  ?>
                    <input type="text" name="post_code" size="13%" maxlength="4" value="<?=$get_post_code?>" onKeyPress="ValidateKeyNumb(this)">
                  </td>
                </tr>
                <tr>
                  <td align="right">Населено място:</td>
                  <td><input type="text" name="populated_towns" size="40%" maxlength="50" value="<?=$row['populated_towns']?>"></td>
                </tr>
                <tr>
                  <td align="right">Адрес:</td>
                  <td><input type="text" name="address" size="40%" maxlength="50" value="<?=htmlspecialchars($row['address'], ENT_QUOTES)?>"></td>
                </tr>
                <tr>
                  <td align="right">Телефон / Факс:</td>
                  <td><input type="text" name="phone_fax" size="30%" maxlength="30" value="<?=$row['phone_fax']?>" onKeyPress="ValidateKeyNumb(this, 45, 44, 47)"></td>
                </tr>
                <tr>
                  <td align="right">Електронен адрес:</td>
                  <td><input type="text" name="email" size="30%" maxlength="25" value="<?=$row['email']?>" onKeyPress="ValidateKeyCharNumb(this, 46, 64, 45, 95)"></td>
                </tr>
                <tr>
                  <td align="right">Банка:</td>
                  <td><input type="text" name="bank_name" size="30%" maxlength="25" value="<?=htmlspecialchars($row['bank_name'])?>"></td>
                </tr>
                <tr>
                  <td align="right">Банкoв клон:</td>
                  <td><input type="text" name="bank_branch" size="30%" maxlength="20" value="<?=htmlspecialchars($row['bank_branch'])?>"></td>
                </tr>
                <tr>
                  <td align="right">Банкoв адрес:</td>
                  <td><input type="text" name="bank_address" size="40%" maxlength="50" value="<?=htmlspecialchars($row['bank_address'])?>"></td>
                </tr>
                <tr>
                  <td align="right">BIC:</td>
                  <td>
                  <?
                    if (empty($row['bank_code'])) {
                      $get_bank_code = "";
                    } else {
                      $get_bank_code = $row['bank_code'];
                    }
                  ?>
                    <input type="text" name="bank_code" size="17%" maxlength="8" value="<?=$get_bank_code?>">
                  </td>
                </tr>
                <tr>
                  <td align="right">IBAN:</td>
                  <td>
                  <?
                    if (empty($row['bank_account'])) {
                      $get_bank_account = "";
                    } else {
                      $get_bank_account = $row['bank_account'];
                    }
                  ?>
                    <input type="text" name="bank_account" size="30%" maxlength="22" value="<?=$get_bank_account?>">
                  </td>
                </tr>
                <tr>
                  <td align="right">Банка /ДДС/:</td>
                  <td><input type="text" name="dds_bank_name" size="30%" maxlength="25" value="<?=htmlspecialchars($row['dds_bank_name'])?>"></td>
                </tr>
                <tr>
                  <td align="right">Банкoв клон /ДДС/:</td>
                  <td><input type="text" name="dds_bank_branch" size="30%" maxlength="20" value="<?=htmlspecialchars($row['dds_bank_branch'])?>"></td>
                </tr>
                <tr>
                  <td align="right">Банкoв адрес /ДДС/:</td>
                  <td><input type="text" name="dds_bank_address" size="40%" maxlength="50" value="<?=htmlspecialchars($row['dds_bank_address'])?>"></td>
                </tr>
                <tr>
                  <td align="right">BIC /ДДС/:</td>
                  <td>
                  <?
                    if (empty($row['dds_bank_code'])) {
                      $get_dds_bank_code = "";
                    } else {
                      $get_dds_bank_code = $row['dds_bank_code'];
                    }
                  ?>
                    <input type="text" name="dds_bank_code" size="17%" maxlength="8" value="<?=$get_dds_bank_code?>">
                  </td>
                </tr>
                <tr>
                  <td align="right">IBAN /ДДС/:</td>
                  <td>
                  <?
                    if (empty($row['dds_bank_account'])) {
                      $get_dds_bank_account = "";
                    } else {
                      $get_dds_bank_account = $row['dds_bank_account'];
                    }
                  ?>
                    <input type="text" name="dds_bank_account" size="30%" maxlength="22" value="<?=$get_dds_bank_account?>">
                  </td>
                </tr>
                <tr>
                  <td align="right">Дата на рег. по ДДС:</td>
                  <td>
                  <?
                    $registration_date = $row["date_format(registration_date, '%d-%m-%Y')"];
                    if ($registration_date == '00-00-0000') $registration_date = "";
                  ?>
                    <input type="text" name="registration_date" size="9%" maxlength="10" value="<?=$registration_date?>" onKeyPress="ValidateKeyNumb(this, 45)">
                  </td>
                </tr>
                <tr>
                  <td align="right">Дата на прекр. на рег. по ДДС:</td>
                  <td>
                  <?
                    $re_registration_date = $row["date_format(re_registration_date, '%d-%m-%Y')"];
                    if ($re_registration_date == '00-00-0000') $re_registration_date = "";
                  ?>
                    <input type="text" name="re_registration_date" size="9%" maxlength="10" value="<?=$re_registration_date?>" onKeyPress="ValidateKeyNumb(this, 45)">
                  </td>
                </tr>
                <tr>
                  <td align="right">Процент ДДС:</td>
                  <td><input type="text" name="dds_percent" size="4%" maxlength="6" value="<?=$row['dds_percent']?>" onKeyPress="ValidateKeyNumb(this, 46)"> %</td>
                </tr>
                <tr>
                  <td align="right">Осн. лихвен % на БНБ + </td>
                  <td><input type="text" name="point_interest_percent" size="4%" maxlength="6" value="<?=$row['point_interest_percent']?>" onKeyPress="ValidateKeyNumb(this, 46)"> пункта</td>
                </tr>
                <tr>
                  <td align="right">Начало на работния ден:</td>
                  <td>
                  <select name = 'start_work_h'>
                    <option value = '0' <? if($row['start_work_hour'] == 0){echo "selected";} ?>>00</option>
                    <option value = '1' <? if($row['start_work_hour'] == 1){echo "selected";} ?>>01</option>
                    <option value = '2' <? if($row['start_work_hour'] == 2){echo "selected";} ?>>02</option>
                    <option value = '3' <? if($row['start_work_hour'] == 3){echo "selected";} ?>>03</option>
                    <option value = '4' <? if($row['start_work_hour'] == 4){echo "selected";} ?>>04</option>
                    <option value = '5' <? if($row['start_work_hour'] == 5){echo "selected";} ?>>05</option>
                    <option value = '6' <? if($row['start_work_hour'] == 6){echo "selected";} ?>>06</option>
                    <option value = '7' <? if($row['start_work_hour'] == 7){echo "selected";} ?>>07</option>
                    <option value = '8' <? if($row['start_work_hour'] == 8){echo "selected";} ?>>08</option>
                    <option value = '9' <? if($row['start_work_hour'] == 9){echo "selected";} ?>>09</option>
                    <option value = '10' <? if($row['start_work_hour'] == 10){echo "selected";} ?>>10</option>
                    <option value = '11' <? if($row['start_work_hour'] == 11){echo "selected";} ?>>11</option>
                    <option value = '12' <? if($row['start_work_hour'] == 12){echo "selected";} ?>>12</option>
                    <option value = '13' <? if($row['start_work_hour'] == 13){echo "selected";} ?>>13</option>
                    <option value = '14' <? if($row['start_work_hour'] == 14){echo "selected";} ?>>14</option>
                    <option value = '15' <? if($row['start_work_hour'] == 15){echo "selected";} ?>>15</option>
                    <option value = '16' <? if($row['start_work_hour'] == 16){echo "selected";} ?>>16</option>
                    <option value = '17' <? if($row['start_work_hour'] == 17){echo "selected";} ?>>17</option>
                    <option value = '18' <? if($row['start_work_hour'] == 18){echo "selected";} ?>>18</option>
                    <option value = '19' <? if($row['start_work_hour'] == 19){echo "selected";} ?>>19</option>
                    <option value = '20' <? if($row['start_work_hour'] == 20){echo "selected";} ?>>20</option>
                    <option value = '21' <? if($row['start_work_hour'] == 21){echo "selected";} ?>>21</option>
                    <option value = '22' <? if($row['start_work_hour'] == 22){echo "selected";} ?>>22</option>
                    <option value = '23' <? if($row['start_work_hour'] == 23){echo "selected";} ?>>23</option>
                    </select>
                    <select name = 'start_work_m'>
                    <option value = '0' <? if($row['start_work_minute'] == 0){echo "selected";} ?>>00</option>
                    <option value = '1' <? if($row['start_work_minute'] == 1){echo "selected";} ?>>01</option>
                    <option value = '2' <? if($row['start_work_minute'] == 2){echo "selected";} ?>>02</option>
                    <option value = '3' <? if($row['start_work_minute'] == 3){echo "selected";} ?>>03</option>
                    <option value = '4' <? if($row['start_work_minute'] == 4){echo "selected";} ?>>04</option>
                    <option value = '5' <? if($row['start_work_minute'] == 5){echo "selected";} ?>>05</option>
                    <option value = '6' <? if($row['start_work_minute'] == 6){echo "selected";} ?>>06</option>
                    <option value = '7' <? if($row['start_work_minute'] == 7){echo "selected";} ?>>07</option>
                    <option value = '8' <? if($row['start_work_minute'] == 8){echo "selected";} ?>>08</option>
                    <option value = '9' <? if($row['start_work_minute'] == 9){echo "selected";} ?>>09</option>
                    <option value = '10' <? if($row['start_work_minute'] == 10){echo "selected";} ?>>10</option>
                    <option value = '11' <? if($row['start_work_minute'] == 11){echo "selected";} ?>>11</option>
                    <option value = '12' <? if($row['start_work_minute'] == 12){echo "selected";} ?>>12</option>
                    <option value = '13' <? if($row['start_work_minute'] == 13){echo "selected";} ?>>13</option>
                    <option value = '14' <? if($row['start_work_minute'] == 14){echo "selected";} ?>>14</option>
                    <option value = '15' <? if($row['start_work_minute'] == 15){echo "selected";} ?>>15</option>
                    <option value = '16' <? if($row['start_work_minute'] == 16){echo "selected";} ?>>16</option>
                    <option value = '17' <? if($row['start_work_minute'] == 17){echo "selected";} ?>>17</option>
                    <option value = '18' <? if($row['start_work_minute'] == 18){echo "selected";} ?>>18</option>
                    <option value = '19' <? if($row['start_work_minute'] == 19){echo "selected";} ?>>19</option>
                    <option value = '20' <? if($row['start_work_minute'] == 20){echo "selected";} ?>>20</option>
                    <option value = '21' <? if($row['start_work_minute'] == 21){echo "selected";} ?>>21</option>
                    <option value = '22' <? if($row['start_work_minute'] == 22){echo "selected";} ?>>22</option>
                    <option value = '23' <? if($row['start_work_minute'] == 23){echo "selected";} ?>>23</option>
                    <option value = '24' <? if($row['start_work_minute'] == 24){echo "selected";} ?>>24</option>
                    <option value = '25' <? if($row['start_work_minute'] == 25){echo "selected";} ?>>25</option>
                    <option value = '26' <? if($row['start_work_minute'] == 26){echo "selected";} ?>>26</option>
                    <option value = '27' <? if($row['start_work_minute'] == 27){echo "selected";} ?>>27</option>
                    <option value = '28' <? if($row['start_work_minute'] == 28){echo "selected";} ?>>28</option>
                    <option value = '29' <? if($row['start_work_minute'] == 29){echo "selected";} ?>>29</option>
                    <option value = '30' <? if($row['start_work_minute'] == 30){echo "selected";} ?>>30</option>
                    <option value = '31' <? if($row['start_work_minute'] == 31){echo "selected";} ?>>31</option>
                    <option value = '32' <? if($row['start_work_minute'] == 32){echo "selected";} ?>>32</option>
                    <option value = '33' <? if($row['start_work_minute'] == 33){echo "selected";} ?>>33</option>
                    <option value = '34' <? if($row['start_work_minute'] == 34){echo "selected";} ?>>34</option>
                    <option value = '35' <? if($row['start_work_minute'] == 35){echo "selected";} ?>>35</option>
                    <option value = '36' <? if($row['start_work_minute'] == 36){echo "selected";} ?>>36</option>
                    <option value = '37' <? if($row['start_work_minute'] == 37){echo "selected";} ?>>37</option>
                    <option value = '38' <? if($row['start_work_minute'] == 38){echo "selected";} ?>>38</option>
                    <option value = '39' <? if($row['start_work_minute'] == 39){echo "selected";} ?>>39</option>
                    <option value = '40' <? if($row['start_work_minute'] == 40){echo "selected";} ?>>40</option>
                    <option value = '41' <? if($row['start_work_minute'] == 41){echo "selected";} ?>>41</option>
                    <option value = '42' <? if($row['start_work_minute'] == 42){echo "selected";} ?>>42</option>
                    <option value = '43' <? if($row['start_work_minute'] == 43){echo "selected";} ?>>43</option>
                    <option value = '44' <? if($row['start_work_minute'] == 44){echo "selected";} ?>>44</option>
                    <option value = '45' <? if($row['start_work_minute'] == 45){echo "selected";} ?>>45</option>
                    <option value = '46' <? if($row['start_work_minute'] == 46){echo "selected";} ?>>46</option>
                    <option value = '47' <? if($row['start_work_minute'] == 47){echo "selected";} ?>>47</option>
                    <option value = '48' <? if($row['start_work_minute'] == 48){echo "selected";} ?>>48</option>
                    <option value = '49' <? if($row['start_work_minute'] == 49){echo "selected";} ?>>49</option>
                    <option value = '50' <? if($row['start_work_minute'] == 50){echo "selected";} ?>>50</option>
                    <option value = '51' <? if($row['start_work_minute'] == 51){echo "selected";} ?>>51</option>
                    <option value = '52' <? if($row['start_work_minute'] == 52){echo "selected";} ?>>52</option>
                    <option value = '53' <? if($row['start_work_minute'] == 53){echo "selected";} ?>>53</option>
                    <option value = '54' <? if($row['start_work_minute'] == 54){echo "selected";} ?>>54</option>
                    <option value = '55' <? if($row['start_work_minute'] == 55){echo "selected";} ?>>55</option>
                    <option value = '56' <? if($row['start_work_minute'] == 56){echo "selected";} ?>>56</option>
                    <option value = '57' <? if($row['start_work_minute'] == 57){echo "selected";} ?>>57</option>
                    <option value = '58' <? if($row['start_work_minute'] == 58){echo "selected";} ?>>58</option>
                    <option value = '59' <? if($row['start_work_minute'] == 59){echo "selected";} ?>>59</option>
                    </select>
                  </td></tr>
                  <tr>
                  <td align="right">Край на работния ден:</td>
                  <td>
                  <select name = 'end_work_h'>
                    <option value = '0' <? if($row['end_work_hour'] == 0){echo "selected";} ?>>00</option>
                    <option value = '1' <? if($row['end_work_hour'] == 1){echo "selected";} ?>>01</option>
                    <option value = '2' <? if($row['end_work_hour'] == 2){echo "selected";} ?>>02</option>
                    <option value = '3' <? if($row['end_work_hour'] == 3){echo "selected";} ?>>03</option>
                    <option value = '4' <? if($row['end_work_hour'] == 4){echo "selected";} ?>>04</option>
                    <option value = '5' <? if($row['end_work_hour'] == 5){echo "selected";} ?>>05</option>
                    <option value = '6' <? if($row['end_work_hour'] == 6){echo "selected";} ?>>06</option>
                    <option value = '7' <? if($row['end_work_hour'] == 7){echo "selected";} ?>>07</option>
                    <option value = '8' <? if($row['end_work_hour'] == 8){echo "selected";} ?>>08</option>
                    <option value = '9' <? if($row['end_work_hour'] == 9){echo "selected";} ?>>09</option>
                    <option value = '10' <? if($row['end_work_hour'] == 10){echo "selected";} ?>>10</option>
                    <option value = '11' <? if($row['end_work_hour'] == 11){echo "selected";} ?>>11</option>
                    <option value = '12' <? if($row['end_work_hour'] == 12){echo "selected";} ?>>12</option>
                    <option value = '13' <? if($row['end_work_hour'] == 13){echo "selected";} ?>>13</option>
                    <option value = '14' <? if($row['end_work_hour'] == 14){echo "selected";} ?>>14</option>
                    <option value = '15' <? if($row['end_work_hour'] == 15){echo "selected";} ?>>15</option>
                    <option value = '16' <? if($row['end_work_hour'] == 16){echo "selected";} ?>>16</option>
                    <option value = '17' <? if($row['end_work_hour'] == 17){echo "selected";} ?>>17</option>
                    <option value = '18' <? if($row['end_work_hour'] == 18){echo "selected";} ?>>18</option>
                    <option value = '19' <? if($row['end_work_hour'] == 19){echo "selected";} ?>>19</option>
                    <option value = '20' <? if($row['end_work_hour'] == 20){echo "selected";} ?>>20</option>
                    <option value = '21' <? if($row['end_work_hour'] == 21){echo "selected";} ?>>21</option>
                    <option value = '22' <? if($row['end_work_hour'] == 22){echo "selected";} ?>>22</option>
                    <option value = '23' <? if($row['end_work_hour'] == 23){echo "selected";} ?>>23</option>
                    </select>
                    <select name = 'end_work_m'>
                    <option value = '0' <? if($row['end_work_minute'] == 0){echo "selected";} ?>>00</option>
                    <option value = '1' <? if($row['end_work_minute'] == 1){echo "selected";} ?>>01</option>
                    <option value = '2' <? if($row['end_work_minute'] == 2){echo "selected";} ?>>02</option>
                    <option value = '3' <? if($row['end_work_minute'] == 3){echo "selected";} ?>>03</option>
                    <option value = '4' <? if($row['end_work_minute'] == 4){echo "selected";} ?>>04</option>
                    <option value = '5' <? if($row['end_work_minute'] == 5){echo "selected";} ?>>05</option>
                    <option value = '6' <? if($row['end_work_minute'] == 6){echo "selected";} ?>>06</option>
                    <option value = '7' <? if($row['end_work_minute'] == 7){echo "selected";} ?>>07</option>
                    <option value = '8' <? if($row['end_work_minute'] == 8){echo "selected";} ?>>08</option>
                    <option value = '9' <? if($row['end_work_minute'] == 9){echo "selected";} ?>>09</option>
                    <option value = '10' <? if($row['end_work_minute'] == 10){echo "selected";} ?>>10</option>
                    <option value = '11' <? if($row['end_work_minute'] == 11){echo "selected";} ?>>11</option>
                    <option value = '12' <? if($row['end_work_minute'] == 12){echo "selected";} ?>>12</option>
                    <option value = '13' <? if($row['end_work_minute'] == 13){echo "selected";} ?>>13</option>
                    <option value = '14' <? if($row['end_work_minute'] == 14){echo "selected";} ?>>14</option>
                    <option value = '15' <? if($row['end_work_minute'] == 15){echo "selected";} ?>>15</option>
                    <option value = '16' <? if($row['end_work_minute'] == 16){echo "selected";} ?>>16</option>
                    <option value = '17' <? if($row['end_work_minute'] == 17){echo "selected";} ?>>17</option>
                    <option value = '18' <? if($row['end_work_minute'] == 18){echo "selected";} ?>>18</option>
                    <option value = '19' <? if($row['end_work_minute'] == 19){echo "selected";} ?>>19</option>
                    <option value = '20' <? if($row['end_work_minute'] == 20){echo "selected";} ?>>20</option>
                    <option value = '21' <? if($row['end_work_minute'] == 21){echo "selected";} ?>>21</option>
                    <option value = '22' <? if($row['end_work_minute'] == 22){echo "selected";} ?>>22</option>
                    <option value = '23' <? if($row['end_work_minute'] == 23){echo "selected";} ?>>23</option>
                    <option value = '24' <? if($row['end_work_minute'] == 24){echo "selected";} ?>>24</option>
                    <option value = '25' <? if($row['end_work_minute'] == 25){echo "selected";} ?>>25</option>
                    <option value = '26' <? if($row['end_work_minute'] == 26){echo "selected";} ?>>26</option>
                    <option value = '27' <? if($row['end_work_minute'] == 27){echo "selected";} ?>>27</option>
                    <option value = '28' <? if($row['end_work_minute'] == 28){echo "selected";} ?>>28</option>
                    <option value = '29' <? if($row['end_work_minute'] == 29){echo "selected";} ?>>29</option>
                    <option value = '30' <? if($row['end_work_minute'] == 30){echo "selected";} ?>>30</option>
                    <option value = '31' <? if($row['end_work_minute'] == 31){echo "selected";} ?>>31</option>
                    <option value = '32' <? if($row['end_work_minute'] == 32){echo "selected";} ?>>32</option>
                    <option value = '33' <? if($row['end_work_minute'] == 33){echo "selected";} ?>>33</option>
                    <option value = '34' <? if($row['end_work_minute'] == 34){echo "selected";} ?>>34</option>
                    <option value = '35' <? if($row['end_work_minute'] == 35){echo "selected";} ?>>35</option>
                    <option value = '36' <? if($row['end_work_minute'] == 36){echo "selected";} ?>>36</option>
                    <option value = '37' <? if($row['end_work_minute'] == 37){echo "selected";} ?>>37</option>
                    <option value = '38' <? if($row['end_work_minute'] == 38){echo "selected";} ?>>38</option>
                    <option value = '39' <? if($row['end_work_minute'] == 39){echo "selected";} ?>>39</option>
                    <option value = '40' <? if($row['end_work_minute'] == 40){echo "selected";} ?>>40</option>
                    <option value = '41' <? if($row['end_work_minute'] == 41){echo "selected";} ?>>41</option>
                    <option value = '42' <? if($row['end_work_minute'] == 42){echo "selected";} ?>>42</option>
                    <option value = '43' <? if($row['end_work_minute'] == 43){echo "selected";} ?>>43</option>
                    <option value = '44' <? if($row['end_work_minute'] == 44){echo "selected";} ?>>44</option>
                    <option value = '45' <? if($row['end_work_minute'] == 45){echo "selected";} ?>>45</option>
                    <option value = '46' <? if($row['end_work_minute'] == 46){echo "selected";} ?>>46</option>
                    <option value = '47' <? if($row['end_work_minute'] == 47){echo "selected";} ?>>47</option>
                    <option value = '48' <? if($row['end_work_minute'] == 48){echo "selected";} ?>>48</option>
                    <option value = '49' <? if($row['end_work_minute'] == 49){echo "selected";} ?>>49</option>
                    <option value = '50' <? if($row['end_work_minute'] == 50){echo "selected";} ?>>50</option>
                    <option value = '51' <? if($row['end_work_minute'] == 51){echo "selected";} ?>>51</option>
                    <option value = '52' <? if($row['end_work_minute'] == 52){echo "selected";} ?>>52</option>
                    <option value = '53' <? if($row['end_work_minute'] == 53){echo "selected";} ?>>53</option>
                    <option value = '54' <? if($row['end_work_minute'] == 54){echo "selected";} ?>>54</option>
                    <option value = '55' <? if($row['end_work_minute'] == 55){echo "selected";} ?>>55</option>
                    <option value = '56' <? if($row['end_work_minute'] == 56){echo "selected";} ?>>56</option>
                    <option value = '57' <? if($row['end_work_minute'] == 57){echo "selected";} ?>>57</option>
                    <option value = '58' <? if($row['end_work_minute'] == 58){echo "selected";} ?>>58</option>
                    <option value = '59' <? if($row['end_work_minute'] == 59){echo "selected";} ?>>59</option>
                    </select>
                  </td></tr>
                  <tr>
                  <td align="right">Начало на обедната почивка:</td>
                  <td>
                  <select name = 'start_lunch_h'>
                    <option value = '0' <? if($row['start_lunch_hour'] == 0){echo "selected";} ?>>00</option>
                    <option value = '1' <? if($row['start_lunch_hour'] == 1){echo "selected";} ?>>01</option>
                    <option value = '2' <? if($row['start_lunch_hour'] == 2){echo "selected";} ?>>02</option>
                    <option value = '3' <? if($row['start_lunch_hour'] == 3){echo "selected";} ?>>03</option>
                    <option value = '4' <? if($row['start_lunch_hour'] == 4){echo "selected";} ?>>04</option>
                    <option value = '5' <? if($row['start_lunch_hour'] == 5){echo "selected";} ?>>05</option>
                    <option value = '6' <? if($row['start_lunch_hour'] == 6){echo "selected";} ?>>06</option>
                    <option value = '7' <? if($row['start_lunch_hour'] == 7){echo "selected";} ?>>07</option>
                    <option value = '8' <? if($row['start_lunch_hour'] == 8){echo "selected";} ?>>08</option>
                    <option value = '9' <? if($row['start_lunch_hour'] == 9){echo "selected";} ?>>09</option>
                    <option value = '10' <? if($row['start_lunch_hour'] == 10){echo "selected";} ?>>10</option>
                    <option value = '11' <? if($row['start_lunch_hour'] == 11){echo "selected";} ?>>11</option>
                    <option value = '12' <? if($row['start_lunch_hour'] == 12){echo "selected";} ?>>12</option>
                    <option value = '13' <? if($row['start_lunch_hour'] == 13){echo "selected";} ?>>13</option>
                    <option value = '14' <? if($row['start_lunch_hour'] == 14){echo "selected";} ?>>14</option>
                    <option value = '15' <? if($row['start_lunch_hour'] == 15){echo "selected";} ?>>15</option>
                    <option value = '16' <? if($row['start_lunch_hour'] == 16){echo "selected";} ?>>16</option>
                    <option value = '17' <? if($row['start_lunch_hour'] == 17){echo "selected";} ?>>17</option>
                    <option value = '18' <? if($row['start_lunch_hour'] == 18){echo "selected";} ?>>18</option>
                    <option value = '19' <? if($row['start_lunch_hour'] == 19){echo "selected";} ?>>19</option>
                    <option value = '20' <? if($row['start_lunch_hour'] == 20){echo "selected";} ?>>20</option>
                    <option value = '21' <? if($row['start_lunch_hour'] == 21){echo "selected";} ?>>21</option>
                    <option value = '22' <? if($row['start_lunch_hour'] == 22){echo "selected";} ?>>22</option>
                    <option value = '23' <? if($row['start_lunch_hour'] == 23){echo "selected";} ?>>23</option>
                    </select>
                    <select name = 'start_lunch_m'>
                    <option value = '0' <? if($row['start_lunch_minute'] == 0){echo "selected";} ?>>00</option>
                    <option value = '1' <? if($row['start_lunch_minute'] == 1){echo "selected";} ?>>01</option>
                    <option value = '2' <? if($row['start_lunch_minute'] == 2){echo "selected";} ?>>02</option>
                    <option value = '3' <? if($row['start_lunch_minute'] == 3){echo "selected";} ?>>03</option>
                    <option value = '4' <? if($row['start_lunch_minute'] == 4){echo "selected";} ?>>04</option>
                    <option value = '5' <? if($row['start_lunch_minute'] == 5){echo "selected";} ?>>05</option>
                    <option value = '6' <? if($row['start_lunch_minute'] == 6){echo "selected";} ?>>06</option>
                    <option value = '7' <? if($row['start_lunch_minute'] == 7){echo "selected";} ?>>07</option>
                    <option value = '8' <? if($row['start_lunch_minute'] == 8){echo "selected";} ?>>08</option>
                    <option value = '9' <? if($row['start_lunch_minute'] == 9){echo "selected";} ?>>09</option>
                    <option value = '10' <? if($row['start_lunch_minute'] == 10){echo "selected";} ?>>10</option>
                    <option value = '11' <? if($row['start_lunch_minute'] == 11){echo "selected";} ?>>11</option>
                    <option value = '12' <? if($row['start_lunch_minute'] == 12){echo "selected";} ?>>12</option>
                    <option value = '13' <? if($row['start_lunch_minute'] == 13){echo "selected";} ?>>13</option>
                    <option value = '14' <? if($row['start_lunch_minute'] == 14){echo "selected";} ?>>14</option>
                    <option value = '15' <? if($row['start_lunch_minute'] == 15){echo "selected";} ?>>15</option>
                    <option value = '16' <? if($row['start_lunch_minute'] == 16){echo "selected";} ?>>16</option>
                    <option value = '17' <? if($row['start_lunch_minute'] == 17){echo "selected";} ?>>17</option>
                    <option value = '18' <? if($row['start_lunch_minute'] == 18){echo "selected";} ?>>18</option>
                    <option value = '19' <? if($row['start_lunch_minute'] == 19){echo "selected";} ?>>19</option>
                    <option value = '20' <? if($row['start_lunch_minute'] == 20){echo "selected";} ?>>20</option>
                    <option value = '21' <? if($row['start_lunch_minute'] == 21){echo "selected";} ?>>21</option>
                    <option value = '22' <? if($row['start_lunch_minute'] == 22){echo "selected";} ?>>22</option>
                    <option value = '23' <? if($row['start_lunch_minute'] == 23){echo "selected";} ?>>23</option>
                    <option value = '24' <? if($row['start_lunch_minute'] == 24){echo "selected";} ?>>24</option>
                    <option value = '25' <? if($row['start_lunch_minute'] == 25){echo "selected";} ?>>25</option>
                    <option value = '26' <? if($row['start_lunch_minute'] == 26){echo "selected";} ?>>26</option>
                    <option value = '27' <? if($row['start_lunch_minute'] == 27){echo "selected";} ?>>27</option>
                    <option value = '28' <? if($row['start_lunch_minute'] == 28){echo "selected";} ?>>28</option>
                    <option value = '29' <? if($row['start_lunch_minute'] == 29){echo "selected";} ?>>29</option>
                    <option value = '30' <? if($row['start_lunch_minute'] == 30){echo "selected";} ?>>30</option>
                    <option value = '31' <? if($row['start_lunch_minute'] == 31){echo "selected";} ?>>31</option>
                    <option value = '32' <? if($row['start_lunch_minute'] == 32){echo "selected";} ?>>32</option>
                    <option value = '33' <? if($row['start_lunch_minute'] == 33){echo "selected";} ?>>33</option>
                    <option value = '34' <? if($row['start_lunch_minute'] == 34){echo "selected";} ?>>34</option>
                    <option value = '35' <? if($row['start_lunch_minute'] == 35){echo "selected";} ?>>35</option>
                    <option value = '36' <? if($row['start_lunch_minute'] == 36){echo "selected";} ?>>36</option>
                    <option value = '37' <? if($row['start_lunch_minute'] == 37){echo "selected";} ?>>37</option>
                    <option value = '38' <? if($row['start_lunch_minute'] == 38){echo "selected";} ?>>38</option>
                    <option value = '39' <? if($row['start_lunch_minute'] == 39){echo "selected";} ?>>39</option>
                    <option value = '40' <? if($row['start_lunch_minute'] == 40){echo "selected";} ?>>40</option>
                    <option value = '41' <? if($row['start_lunch_minute'] == 41){echo "selected";} ?>>41</option>
                    <option value = '42' <? if($row['start_lunch_minute'] == 42){echo "selected";} ?>>42</option>
                    <option value = '43' <? if($row['start_lunch_minute'] == 43){echo "selected";} ?>>43</option>
                    <option value = '44' <? if($row['start_lunch_minute'] == 44){echo "selected";} ?>>44</option>
                    <option value = '45' <? if($row['start_lunch_minute'] == 45){echo "selected";} ?>>45</option>
                    <option value = '46' <? if($row['start_lunch_minute'] == 46){echo "selected";} ?>>46</option>
                    <option value = '47' <? if($row['start_lunch_minute'] == 47){echo "selected";} ?>>47</option>
                    <option value = '48' <? if($row['start_lunch_minute'] == 48){echo "selected";} ?>>48</option>
                    <option value = '49' <? if($row['start_lunch_minute'] == 49){echo "selected";} ?>>49</option>
                    <option value = '50' <? if($row['start_lunch_minute'] == 50){echo "selected";} ?>>50</option>
                    <option value = '51' <? if($row['start_lunch_minute'] == 51){echo "selected";} ?>>51</option>
                    <option value = '52' <? if($row['start_lunch_minute'] == 52){echo "selected";} ?>>52</option>
                    <option value = '53' <? if($row['start_lunch_minute'] == 53){echo "selected";} ?>>53</option>
                    <option value = '54' <? if($row['start_lunch_minute'] == 54){echo "selected";} ?>>54</option>
                    <option value = '55' <? if($row['start_lunch_minute'] == 55){echo "selected";} ?>>55</option>
                    <option value = '56' <? if($row['start_lunch_minute'] == 56){echo "selected";} ?>>56</option>
                    <option value = '57' <? if($row['start_lunch_minute'] == 57){echo "selected";} ?>>57</option>
                    <option value = '58' <? if($row['start_lunch_minute'] == 58){echo "selected";} ?>>58</option>
                    <option value = '59' <? if($row['start_lunch_minute'] == 59){echo "selected";} ?>>59</option>
                    </select>
                  </td></tr>
                  <tr>
                  <td align="right">Край на обедната почивка:</td>
                  <td>
                  <select name = 'end_lunch_h'>
                    <option value = '0' <? if($row['end_lunch_hour'] == 0){echo "selected";} ?>>00</option>
                    <option value = '1' <? if($row['end_lunch_hour'] == 1){echo "selected";} ?>>01</option>
                    <option value = '2' <? if($row['end_lunch_hour'] == 2){echo "selected";} ?>>02</option>
                    <option value = '3' <? if($row['end_lunch_hour'] == 3){echo "selected";} ?>>03</option>
                    <option value = '4' <? if($row['end_lunch_hour'] == 4){echo "selected";} ?>>04</option>
                    <option value = '5' <? if($row['end_lunch_hour'] == 5){echo "selected";} ?>>05</option>
                    <option value = '6' <? if($row['end_lunch_hour'] == 6){echo "selected";} ?>>06</option>
                    <option value = '7' <? if($row['end_lunch_hour'] == 7){echo "selected";} ?>>07</option>
                    <option value = '8' <? if($row['end_lunch_hour'] == 8){echo "selected";} ?>>08</option>
                    <option value = '9' <? if($row['end_lunch_hour'] == 9){echo "selected";} ?>>09</option>
                    <option value = '10' <? if($row['end_lunch_hour'] == 10){echo "selected";} ?>>10</option>
                    <option value = '11' <? if($row['end_lunch_hour'] == 11){echo "selected";} ?>>11</option>
                    <option value = '12' <? if($row['end_lunch_hour'] == 12){echo "selected";} ?>>12</option>
                    <option value = '13' <? if($row['end_lunch_hour'] == 13){echo "selected";} ?>>13</option>
                    <option value = '14' <? if($row['end_lunch_hour'] == 14){echo "selected";} ?>>14</option>
                    <option value = '15' <? if($row['end_lunch_hour'] == 15){echo "selected";} ?>>15</option>
                    <option value = '16' <? if($row['end_lunch_hour'] == 16){echo "selected";} ?>>16</option>
                    <option value = '17' <? if($row['end_lunch_hour'] == 17){echo "selected";} ?>>17</option>
                    <option value = '18' <? if($row['end_lunch_hour'] == 18){echo "selected";} ?>>18</option>
                    <option value = '19' <? if($row['end_lunch_hour'] == 19){echo "selected";} ?>>19</option>
                    <option value = '20' <? if($row['end_lunch_hour'] == 20){echo "selected";} ?>>20</option>
                    <option value = '21' <? if($row['end_lunch_hour'] == 21){echo "selected";} ?>>21</option>
                    <option value = '22' <? if($row['end_lunch_hour'] == 22){echo "selected";} ?>>22</option>
                    <option value = '23' <? if($row['end_lunch_hour'] == 23){echo "selected";} ?>>23</option>
                    </select>
                    <select name = 'end_lunch_m'>
                    <option value = '0' <? if($row['end_lunch_minute'] == 0){echo "selected";} ?>>00</option>
                    <option value = '1' <? if($row['end_lunch_minute'] == 1){echo "selected";} ?>>01</option>
                    <option value = '2' <? if($row['end_lunch_minute'] == 2){echo "selected";} ?>>02</option>
                    <option value = '3' <? if($row['end_lunch_minute'] == 3){echo "selected";} ?>>03</option>
                    <option value = '4' <? if($row['end_lunch_minute'] == 4){echo "selected";} ?>>04</option>
                    <option value = '5' <? if($row['end_lunch_minute'] == 5){echo "selected";} ?>>05</option>
                    <option value = '6' <? if($row['end_lunch_minute'] == 6){echo "selected";} ?>>06</option>
                    <option value = '7' <? if($row['end_lunch_minute'] == 7){echo "selected";} ?>>07</option>
                    <option value = '8' <? if($row['end_lunch_minute'] == 8){echo "selected";} ?>>08</option>
                    <option value = '9' <? if($row['end_lunch_minute'] == 9){echo "selected";} ?>>09</option>
                    <option value = '10' <? if($row['end_lunch_minute'] == 10){echo "selected";} ?>>10</option>
                    <option value = '11' <? if($row['end_lunch_minute'] == 11){echo "selected";} ?>>11</option>
                    <option value = '12' <? if($row['end_lunch_minute'] == 12){echo "selected";} ?>>12</option>
                    <option value = '13' <? if($row['end_lunch_minute'] == 13){echo "selected";} ?>>13</option>
                    <option value = '14' <? if($row['end_lunch_minute'] == 14){echo "selected";} ?>>14</option>
                    <option value = '15' <? if($row['end_lunch_minute'] == 15){echo "selected";} ?>>15</option>
                    <option value = '16' <? if($row['end_lunch_minute'] == 16){echo "selected";} ?>>16</option>
                    <option value = '17' <? if($row['end_lunch_minute'] == 17){echo "selected";} ?>>17</option>
                    <option value = '18' <? if($row['end_lunch_minute'] == 18){echo "selected";} ?>>18</option>
                    <option value = '19' <? if($row['end_lunch_minute'] == 19){echo "selected";} ?>>19</option>
                    <option value = '20' <? if($row['end_lunch_minute'] == 20){echo "selected";} ?>>20</option>
                    <option value = '21' <? if($row['end_lunch_minute'] == 21){echo "selected";} ?>>21</option>
                    <option value = '22' <? if($row['end_lunch_minute'] == 22){echo "selected";} ?>>22</option>
                    <option value = '23' <? if($row['end_lunch_minute'] == 23){echo "selected";} ?>>23</option>
                    <option value = '24' <? if($row['end_lunch_minute'] == 24){echo "selected";} ?>>24</option>
                    <option value = '25' <? if($row['end_lunch_minute'] == 25){echo "selected";} ?>>25</option>
                    <option value = '26' <? if($row['end_lunch_minute'] == 26){echo "selected";} ?>>26</option>
                    <option value = '27' <? if($row['end_lunch_minute'] == 27){echo "selected";} ?>>27</option>
                    <option value = '28' <? if($row['end_lunch_minute'] == 28){echo "selected";} ?>>28</option>
                    <option value = '29' <? if($row['end_lunch_minute'] == 29){echo "selected";} ?>>29</option>
                    <option value = '30' <? if($row['end_lunch_minute'] == 30){echo "selected";} ?>>30</option>
                    <option value = '31' <? if($row['end_lunch_minute'] == 31){echo "selected";} ?>>31</option>
                    <option value = '32' <? if($row['end_lunch_minute'] == 32){echo "selected";} ?>>32</option>
                    <option value = '33' <? if($row['end_lunch_minute'] == 33){echo "selected";} ?>>33</option>
                    <option value = '34' <? if($row['end_lunch_minute'] == 34){echo "selected";} ?>>34</option>
                    <option value = '35' <? if($row['end_lunch_minute'] == 35){echo "selected";} ?>>35</option>
                    <option value = '36' <? if($row['end_lunch_minute'] == 36){echo "selected";} ?>>36</option>
                    <option value = '37' <? if($row['end_lunch_minute'] == 37){echo "selected";} ?>>37</option>
                    <option value = '38' <? if($row['end_lunch_minute'] == 38){echo "selected";} ?>>38</option>
                    <option value = '39' <? if($row['end_lunch_minute'] == 39){echo "selected";} ?>>39</option>
                    <option value = '40' <? if($row['end_lunch_minute'] == 40){echo "selected";} ?>>40</option>
                    <option value = '41' <? if($row['end_lunch_minute'] == 41){echo "selected";} ?>>41</option>
                    <option value = '42' <? if($row['end_lunch_minute'] == 42){echo "selected";} ?>>42</option>
                    <option value = '43' <? if($row['end_lunch_minute'] == 43){echo "selected";} ?>>43</option>
                    <option value = '44' <? if($row['end_lunch_minute'] == 44){echo "selected";} ?>>44</option>
                    <option value = '45' <? if($row['end_lunch_minute'] == 45){echo "selected";} ?>>45</option>
                    <option value = '46' <? if($row['end_lunch_minute'] == 46){echo "selected";} ?>>46</option>
                    <option value = '47' <? if($row['end_lunch_minute'] == 47){echo "selected";} ?>>47</option>
                    <option value = '48' <? if($row['end_lunch_minute'] == 48){echo "selected";} ?>>48</option>
                    <option value = '49' <? if($row['end_lunch_minute'] == 49){echo "selected";} ?>>49</option>
                    <option value = '50' <? if($row['end_lunch_minute'] == 50){echo "selected";} ?>>50</option>
                    <option value = '51' <? if($row['end_lunch_minute'] == 51){echo "selected";} ?>>51</option>
                    <option value = '52' <? if($row['end_lunch_minute'] == 52){echo "selected";} ?>>52</option>
                    <option value = '53' <? if($row['end_lunch_minute'] == 53){echo "selected";} ?>>53</option>
                    <option value = '54' <? if($row['end_lunch_minute'] == 54){echo "selected";} ?>>54</option>
                    <option value = '55' <? if($row['end_lunch_minute'] == 55){echo "selected";} ?>>55</option>
                    <option value = '56' <? if($row['end_lunch_minute'] == 56){echo "selected";} ?>>56</option>
                    <option value = '57' <? if($row['end_lunch_minute'] == 57){echo "selected";} ?>>57</option>
                    <option value = '58' <? if($row['end_lunch_minute'] == 58){echo "selected";} ?>>58</option>
                    <option value = '59' <? if($row['end_lunch_minute'] == 59){echo "selected";} ?>>59</option>
                    </select>
                  </td></tr>
                <tr>
                  <td align="right">Платежна система:</td>
                  <td><input type="text" name="pay_system" size="40%" maxlength="40" value="<?=htmlspecialchars($row['pay_system'], ENT_QUOTES)?>"></td>
                </tr>
					<tr>
						<td align="right" width="45%">Касиер - Вносител</td>
						<td width="55%">
							<input type="radio" class="text" name="ob6tina_kasier_nareditel" id="kasier_nareditel" value="1" onclick="window.location.href='MunicipSystems.php?che=1';" <?if ($resv==1) echo('checked');?>> Наредител
						</td>
					</tr>
					<tr>
						<td align="right" width="45%"><?=$ifmuni?> - Касиер - Вносител</td>
						<td width="55%">
							<input type="radio" class="text" name="ob6tina_kasier_nareditel" id="idob6tina_kasier_nareditel" value="2" onclick="window.location.href='MunicipSystems.php?che=2';" <?if ($resv==2) echo('checked');?>> Наредител
						</td>
					</tr>
					</tr>
              </table>
            </div>
          </fieldset>
        </td>
      </tr>
      <tr valign="bottom">
        <td height="10%" align="right">
          <input type="image" name="add" src="../Images/Add.gif" border="0" onClick="return VerifyValidData('fmunicip_systems')">
          <input type="image" name="exit" src="../Images/Exit.gif" border="0" onClick="window.close()">
        </td>
      </tr>
    </table>
  </form>
</body>
</html>

