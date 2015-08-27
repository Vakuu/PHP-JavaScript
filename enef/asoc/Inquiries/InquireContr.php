<?php
include("../../inc/conf.php");
  //echo "tuk e";
  $query = "SELECT a.id, b.build_identify, a.asoc_numb,a.asoc_address, b.`build_numb`, a.asoc_name, a.`date_of_create`, b.kvartal, b.street, b.raion,d.number, d.`theirs_date`,d.status FROM asoc a, buildings b, 
documents d WHERE b.id=a.building_id AND d.type_flag=5 AND a.request=d.`id` and a.invalid='0' and b.invalid='0'
";
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
  if (!empty($hood)) { $query .= " AND b.kvartal = '$hood'"; }
  if (!empty($nasel)) { $query .= " AND b.nasel = '$nasel'"; }
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
    <tr>
      <td width="180px">
      </td>
      <td width="560px" align="center" valign="middle"><font color="blue"><b><i>Сдружения регистрирани за целите на ЗЕЕ</i></b></font></td>
      <td width="110px">&nbsp;</td>
    </tr>
  </table>
 <table id="tableh" width="1000px" cellspacing="0" cellpadding="0" border="1">
  <tr>
  <td class="left_bottom"><b>Легенда:</b></td>
  <td class="left_bottom">Teкст на договорите:</td>
  </tr>
  <tr>
  <td class="left_bottom">Дог1:</td>
  <td class="left_bottom">Договор - Община със СС</td>
 </tr>
   <tr>
  <td class="left_bottom">Дог2:</td>
  <td class="left_bottom">Договор - Целево финансиране</td>
 </tr>
   <tr>
  <td class="left_bottom">Дог3:</td>
  <td class="left_bottom">Договор - Техническо обследване</td>
 </tr>
   <tr>
  <td class="left_bottom">Дог4:</td>
  <td class="left_bottom">Договор - Проектиране и СМР</td>
 </tr>
   <tr>
  <td class="left_bottom">Дог5:</td>
  <td class="left_bottom">Договор - Инвеститорски контрол</td>
 </tr>
   </table>
  <br />

  
  
  </table>
  <table id="table" width="1000px" cellspacing="0" cellpadding="0" border="1">
    <tr>
      <td class="bottom" width="25px"><i>№</i></td>
      <td class="left_bottom" width="85px" align="center"><i>Идентиф.№<br>сграда</i></td>
      <td class="left_bottom" width="40px" align="center"><i>№ Сдружение</i></td>
       <td class="left_bottom" width="80px" align="center"><i>Име на Сдружение</i></td>
      <td class="left_bottom" width="180px"><i>Адрес:</i></td>
      <td class="left_bottom" width="85px" align="center"><i>Дата на рег.</i></td>
      <td class="left_bottom" width="80px" align="center"><i>№ЗИФП</i></td>
      <td class="left_bottom" width="85px" align="center"><i>Дата на подаване</i></td>
      <td class="left_bottom" width="160px" align="center"><i>Статус на ЗИФП</i></td>
    </tr>
  <?php
  $i=0;
  while($row = mysql_fetch_array($result)){
     $i++;
    /**
 *  $k = explode("~",$row['kvartal']);
 *      $nom_code_k = $k[0];
 *      $cod_cod_k = $k[1];
 *      $naspl = explode("~",$row['nasel']);
 *      $nom_code_n = $naspl[0];
 *      $cod_cod_n = $naspl[1];
 *      $jk_ar = explode("~",$row['jk']);
 *      $nom_code_jk = $jk_ar[0];
 *      $cod_cod_jk = $jk_ar[1];
 *      
 *   $get_raion = sql_q("SELECT region_name FROM regions WHERE show_cod ='".$row['raion']."'");
 *   $get_ra = mysql_fetch_array($get_raion);
 *   $ra = "Район:".$get_ra['region_name'];
 *       
 *   $get_kv_name_q = sql_q("SELECT cod_name FROM elements WHERE nom_code ='".$nom_code_k."' AND cod_cod='".$cod_cod_k."';");
 *   $kvartal = mysql_fetch_array($get_kv_name_q);
 *   $kvar = ", ".$kvartal['cod_name']; 
 *      
 *     $get_nas_name_q = sql_q("SELECT cod_name FROM elements WHERE nom_code ='".$nom_code_n."' AND cod_cod='".$cod_cod_n."';");
 *     $nasel_arr = mysql_fetch_array($get_nas_name_q);
 *     $nasel =", Нас.място ".$nasel_arr['cod_name'];
 *      
 *     $get_jk_name_q = sql_q("SELECT cod_name FROM elements WHERE nom_code ='".$nom_code_jk."' AND cod_cod='".$cod_cod_jk."';");
 *     $jk_arr = mysql_fetch_array($get_jk_name_q);
 *     $jk = ", ".$jk_arr['cod_name'];  
 *     
 *   
 *      
 *     $street ='';
 *  if($row['street']!=''){
 *     $street = ", ул. ".$row['street'];
 *  }
 *     $bl='';
 *     if($row['build_numb'] !=''){
 *         $bl = ", бл.".$row['build_numb'];
 *     }
 *     
 */
    $get_status = sql_q("SELECT cod_cod, cod_name FROM elements WHERE nom_code ='05' and cod_cod ='".$row['status']."'");
    $get_stat = mysql_fetch_array($get_status);
    $st = $get_stat['cod_name'];
    echo "<tr>";
    echo "<td class='left_bottom' width='10px' align='center'>".$i."</td>";
    echo "<td class='left_bottom' width='85px' align='center'>".$row['build_identify']."</td>";
    echo "<td class='left_bottom' width='85px' align='center'>&nbsp".$row['asoc_numb']."</td>";
    echo "<td class='left_bottom' width='85px' align='center'>&nbsp".$row['asoc_name']."</td>";
   echo "<td class='left_bottom' width='180px' align='center'>&nbsp".$row['asoc_address']."</td>";
   //echo "<td class='left_bottom' width='180px' align='center'>&nbsp".$ra.$kvar.$jk.$street.$bl."</td>";
      echo "<td class='left_bottom' width='70px' align='center'>".$row['date_of_create']."</td>";
    echo "<td class='left_bottom' width='85px' align='center'>&nbsp".$row['number']."</td>";
     echo "<td class='left_bottom' width='70px' align='center'>".$row['theirs_date']."</td>";
   echo "<td class='left_bottom' width='160px' align='center'>&nbsp".$st."</td>";
    echo "</tr>";
    echo '<tr>
    <td class="left_bottom" colspan="9"style="border:1px solid red">
    <table cellspacing="0" cellpadding="0" border="1" width="100%"><tr>
   <tr><td class="left_bottom" colspan=""><b>Договори на сдружение №'.$row['asoc_numb'].'</b></td></tr>
   <td>№договор</td>
   <td>От дата</td>
   <td>Статус</td>
   </tr>';
    echo "</td>";
    echo"</tr>";
    $get_contr = sql_q("SELECT * FROM documents WHERE `type_flag`=50 AND asoc_id='".$row['id']."'");
     $incr=0;
     while ($contr_data = mysql_fetch_array($get_contr)){
        $incr++;
        echo "<tr>";
        echo "<td class='left_bottom'>Дог.".$incr."-№".$contr_data['number']."</td>";
        
   $get_status = sql_q("SELECT cod_cod, cod_name FROM elements WHERE nom_code ='50' and cod_cod ='".$contr_data['status']."'");
  $get_stat = mysql_fetch_array($get_status);
  $st = $get_stat['cod_name'];
  // echo "<td class='left_bottom' width='160px' align='center'>&nbsp".$st."</td>";
        echo "<td class='left_bottom'>От дата:".$contr_data['theirs_date']."</td>";
         echo "<td class='left_bottom'>Статус:".$st."</td>";
        echo"</tr>";
     }
    echo "</table>";   
    //echo $query;
    
  }
  ?>
  
  </table>
  <font size="-2">Справката е генерирана от система Брайт РЕГЕС&ПРОГЕС на фирма "Брайт Комплекс АТ" ЕООД.</font>
<form name="xls" id="xls" method="post" action="InquireContrxls.php">
<input type="hidden" name="query_text" id="query_text" value="<?=$query?>"/>
<input type="submit" name="excel" id="excel" value="Excel"/>
</form>
</body>
</html>

