<?php
include("../../inc/conf.php");
  
//$query = "SELECT a.asoc_numb, a.date, a.bulstat, a.asoc_name, b.build_identify, b.build_numb,b.kvartal,b.nasel,b.jk, b.raion,d.status FROM asoc a, buildings b, 
//documents d WHERE b.id=a.building_id AND d.type_flag=5 AND a.id=d.`asoc_id`
//";
$query = "SELECT a.asoc_numb, a.date, a.bulstat, a.asoc_name, b.build_identify, b.build_numb,b.kvartal,b.nasel,b.jk, b.raion,d.number, d.status FROM asoc a, buildings b, 
documents d WHERE b.id=a.building_id AND d.type_flag=5 AND a.request  = d.`id` and a.invalid='0' and b.invalid='0'";
$build_identify = $_GET ['build_identify'];	
$raion = $_GET['raion'];
$hood = $_GET['hood'];
$jk = $_GET['jk'];
$nasel = $_GET['nasel'];
$build_numb = $_GET['build_numb'];
$asoc_numb = $_GET['asoc_numb'];
$bulstat  = $_GET['bulstath'];
$asoc_name = $_GET['asoc_name'];
$status = $_GET['status'];
  
  if (!empty($build_identify)) { $query .= " AND b.build_identify LIKE'%".$build_identify."%'"; } 
  if (!empty($raion)) { $query .= " AND b.raion = '$raion'"; }
  if (!empty($nasel)) { $query .= " AND b.nasel = '$nasel'"; }
  if (!empty($hood)) { $query .= " AND b.kvartal = '$hood'"; }
  if (!empty($jk)) { $query .= " AND b.jk = '$jk'"; }
  if (!empty($build_numb)) { $query .= " AND b.build_numb LIKE '%".$build_numb."%'"; }
  if (!empty($asoc_numb)) { $query .= " AND a.asoc_numb LIKE '%".$asoc_numb."%'"; }
  if (!empty($bulstat)) { $query .= " AND a.bulstat LIKE '%".$bulstat."%'"; }
  if (!empty($asoc_name)) { $query .= " AND a.asoc_name LIKE '%".$asoc_name."%'"; }
  if (!empty($status)) { $query .= " AND d.status = '$status'"; }


  $result = sql_q($query);
?>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
  <meta http-equiv="Content-Language" content="bg">
  <style type="text/css">
    #table { border-color: black; border-style: dotted; border-width: 1 1 0 1 }
    td { border-width: 0 0 0 0; border-style: dotted; padding: 0px; font-size: 14px }
    td.bottom { border-width: 0 0 1px 0; }
    td.left_bottom { border-width: 0 0 1px 1px; }
  </style>
<!--  ********** added  ******** -->
<script src="js/table2Excel.js"></script>
</head>
<body>
  <table width="970px" cellspacing="0" cellpadding="0">
  
  </table>
  <table width="970px" cellspacing="0" cellpadding="0">
    <tr>
      <td width="180px">
      </td>
      <td width="560px" align="center" valign="middle"><font color="blue"><b><i>Справка за обекти включени по програма НПЕЕ</i></b></font></td>
      <td width="110px">&nbsp;</td>
    </tr>
  </table>
  <table id="table" width="1000px" cellspacing="0" cellpadding="0" border="1">
    <tr>
      <td class="bottom" width="25px"><i>№</i></td>
      <td class="left_bottom" width="85px" align="center"><i>Дата</i></td>
      <td class="left_bottom" width="85px" align="center"><i>Идентиф.№<br>сграда</i></td>
      <td class="left_bottom" width="80px" align="center"><i>Район</i></td>
      <td class="left_bottom" width="80px" align="center"><i>Населено място</i></td>
      <td class="left_bottom" width="80px" align="center"><i>Квартал</i></td>
      <td class="left_bottom" width="80px" align="center"><i>ЖК.</i></td>
      <td class="left_bottom" width="90px"><i>№ Блок</i></td>
      <td class="left_bottom" width="180px"><i>Име на Сдружение</i></td>
      <td class="left_bottom" width="40px" align="center"><i>№ Сдружение</i></td>
      <td class="left_bottom" width="180px" align="center"><i>Булстат</i></td>
      <td class="left_bottom" width="60px" align="center"><i>№ заявление.</i></td>
      <td class="left_bottom" width="160px" align="center"><i>Статус на заявление</i></td>
    </tr>
  <?php
  $i=0;
  while($row = mysql_fetch_array($result)){
    $i++;
    $k = explode("~",$row['kvartal']);
     $nom_code_k = $k[0];
     $cod_cod_k = $k[1];
     $naspl = explode("~",$row['nasel']);
     $nom_code_n = $naspl[0];
     $cod_cod_n = $naspl[1];
     $jk_ar = explode("~",$row['jk']);
     $nom_code_jk = $jk_ar[0];
     $cod_cod_jk = $jk_ar[1];
     
      $get_raion = sql_q("SELECT region_name FROM regions WHERE show_cod ='".$row['raion']."'");
  $get_ra = mysql_fetch_array($get_raion);
  $ra = $get_ra['region_name'];
      
      $get_kv_name_q = sql_q("SELECT cod_name FROM elements WHERE nom_code ='".$nom_code_k."' AND cod_cod='".$cod_cod_k."';");
    $kvartal = mysql_fetch_array($get_kv_name_q);
     $kvar = $kvartal['cod_name']; 
     
     $get_nas_name_q = sql_q("SELECT cod_name FROM elements WHERE nom_code ='".$nom_code_n."' AND cod_cod='".$cod_cod_n."';");
    $nasel_arr = mysql_fetch_array($get_nas_name_q);
     $nasel = $nasel_arr['cod_name'];
     
    $get_jk_name_q = sql_q("SELECT cod_name FROM elements WHERE nom_code ='".$nom_code_jk."' AND cod_cod='".$cod_cod_jk."';");
    $jk_arr = mysql_fetch_array($get_jk_name_q);
    $jk = $jk_arr['cod_name'];  
     
  $get_status = sql_q("SELECT cod_cod, cod_name FROM elements WHERE nom_code ='05' and cod_cod ='".$row['status']."'");
  $get_stat = mysql_fetch_array($get_status);
  $st = $get_stat['cod_name'];
    
   echo "<tr>";
   echo "<td class='left_bottom' width='10px' align='center'>".$i."</td>";
   echo "<td class='left_bottom' width='70px' align='center'>".$row['date']."</td>";
   echo "<td class='left_bottom' width='85px' align='center'>".$row['build_identify']."</td>";
   echo "<td class='left_bottom' width='85px' align='center'>&nbsp".$ra."</td>";
   echo "<td class='left_bottom' width='85px' align='center'>&nbsp".$nasel."</td>";
   echo "<td class='left_bottom' width='85px' align='center'>&nbsp".$kvar."</td>";
   echo "<td class='left_bottom' width='85px' align='center'>&nbsp".$jk."</td>";
   echo "<td class='left_bottom' width='85px' align='center'>&nbsp".$row['build_numb']."</td>";
   echo "<td class='left_bottom' width='85px' align='center'>&nbsp".$row['asoc_name']."</td>";
   echo "<td class='left_bottom' width='85px' align='center'>&nbsp".$row['asoc_numb']."</td>";
   echo"<td class='left_bottom' width='85px' align='center'>&nbsp".$row['bulstat']."</td>";
   echo "<td class='left_bottom' width='60px' align='center'>&nbsp".$row['number']."</td>";
   echo "<td class='left_bottom' width='160px' align='center'>&nbsp".$st."</td>";
   echo "</tr>"; 
  }
  ?>
  </table>
  <font size="-2">Справката е генерирана от система Брайт РЕГЕС&ПРОГЕС на фирма "Брайт Комплекс АТ" ЕООД.</font>
<form name="xls" id="xls" method="post" action="xls.php">
<input type="hidden" name="query_text" id="query_text" value="<?=$query?>"/>
<input type="submit" name="excel" id="excel" value="Excel"/>
</form>
</body>
</html>

