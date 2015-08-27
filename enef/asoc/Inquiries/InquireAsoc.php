<? 
include ("../../inc/conf.php");
$build_identify = $_GET ['build_identify'];	
$raion = $_GET['raion'];
$hood = $_GET['hood'];
$jk = $_GET['jk'];
$nasel = $_GET['nasel'];
$asoc_numb = $_GET['asoc_numb'];	
$query = "SELECT a.date, a.date_of_create, a.predmet, a.asoc_numb, a.bulstat,a.asoc_address, a.asoc_name, b.build_identify, 
						b.build_numb, b.kvartal, b.nasel, b.jk, b.street, b.raion, a.`srok`
FROM asoc a, buildings b
WHERE b.id=a.building_id and a.invalid='0' and b.invalid='0'";

if($raion != ''){
    

     $get_raion = sql_q("SELECT region_name FROM regions WHERE show_cod ='".$raion."'");
  $get_ra = mysql_fetch_array($get_raion);
  $ra_show = "Район:".$get_ra['region_name'];
    }
      if($hood!= ''){
      $k = explode("~",$hood);
     $cod_cod_k = $k[1];
      $get_kv_name_q = sql_q("SELECT cod_name FROM elements WHERE nom_code ='".$nom_code_k."' AND cod_cod='".$cod_cod_k."';");
    $kvartal = mysql_fetch_array($get_kv_name_q);
     $kvar_show = $kvartal['cod_name']; 
}

if($jk !=''){
    $jk_ar = explode("~",$jk);
     $nom_code_jk = $jk_ar[0];
     $cod_cod_jk = $jk_ar[1];
    $get_jk_name_q = sql_q("SELECT cod_name FROM elements WHERE nom_code ='".$nom_code_jk."' AND cod_cod='".$cod_cod_jk."';");
    $jk_arr = mysql_fetch_array($get_jk_name_q);
    $jk_show = $jk_arr['cod_name'];   
}
if($nasel !=''){
 $naspl = explode("~",$nasel);
     $nom_code_n = $naspl[0];
     $cod_cod_n = $naspl[1];
 $get_nas_name_q = sql_q("SELECT cod_name FROM elements WHERE nom_code ='".$nom_code_n."' AND cod_cod='".$cod_cod_n."';");
    $nasel_arr = mysql_fetch_array($get_nas_name_q);
     $nasel_show ="Нас.място: ".$nasel_arr['cod_name'];
}
else{
    $kvar_show = 'Квартал: Всички';
    $ra_show = 'Район: Всички';
    $jk_show = 'жк: Всички';
    $nasel_show ='Нас.място: Всички';
}


if (!empty($build_identify)) { $query .= " AND b.build_identify LIKE'%".$build_identify."%'"; } 
  if (!empty($raion)) { $query .= " AND b.raion = '$raion'"; }
  if (!empty($nasel)) { $query .= " AND b.nasel = '$nasel'"; }
  if (!empty($hood)) { $query .= " AND b.kvartal = '$hood'"; }
  if (!empty($jk)) { $query .= " AND b.jk = '$jk'"; }
  if (!empty($asoc_numb)) { $query .= " AND a.asoc_numb LIKE '%".$asoc_numb."%'"; }
 $result = sql_q($query);

?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="../css/InquireAsoc.css" />
<style type="text/css">
	#table {width: 70%; border-color: black; border-style: dotted; border-width: 1 1 0 1 }
	td { border-width: 0 0 0 0; border-style: dotted; padding: 0px; font-size: 14px }
	td.bottom { border-width: 0 0 1px 0; }
	td.left_bottom { border-width: 0 0 1px 1px; }
</style>
</head>

<body>
	<table id="tbl1" cellspacing="0" cellpadding="0">
		<tr>
			<td colspan="3" align="center">
				<b><i>Справка за регистрирани сдружения на собствениците(СС)</i></b>
			</td>
		</tr>
		<tr>
			<td>
				<i><?= $ra_show."</br>"?></i>
				<i><?= $nasel_show."</br>"?></i>
                <i><?= $kvar_show."</br>"?></i>
                <i><?= $jk_show ."</br>"?></i><br/>
				<i>Дата:</i> <?= date('d-m-Y');?>
			</td>
		</tr>
	</table>
	<table id="table" cellspacing="0" cellpadding="0" border="1">
		<tr>
			<td class="bottom" width=""><i>№</i></td>
			<td class="left_bottom" align="center"><i>Дата на запис</i></td>
			<td class="left_bottom" align="center"><i>Сграда - Идентификатор</i></td>
			<td class="left_bottom" align="center"><i>Сграда - Адрес</i></td>
			<td class="left_bottom" align="center"><i>Сдружение - Рег.№</i></td>
            <td class="left_bottom" align="center"><i>Име на сдружението</i></td>
			<td class="left_bottom" align="center"><i>Вид на сдружението</i></td>
			<td class="left_bottom" align="center"><i>Дата на регистрация</i></td>
			<td class="left_bottom" align="center"><i>За срок</i></td>
		</tr>
<?
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
 *       $get_raion = sql_q("SELECT region_name FROM regions WHERE show_cod ='".$row['raion']."'");
 *   $get_ra = mysql_fetch_array($get_raion);
 *   $ra = "Район:".$get_ra['region_name'];
 *       
 *       $get_kv_name_q = sql_q("SELECT cod_name FROM elements WHERE nom_code ='".$nom_code_k."' AND cod_cod='".$cod_cod_k."';");
 *     $kvartal = mysql_fetch_array($get_kv_name_q);
 *      $kvar = ", ".$kvartal['cod_name']; 
 *      
 *      $get_nas_name_q = sql_q("SELECT cod_name FROM elements WHERE nom_code ='".$nom_code_n."' AND cod_cod='".$cod_cod_n."';");
 *     $nasel_arr = mysql_fetch_array($get_nas_name_q);
 *      $nasel =", Нас.място ".$nasel_arr['cod_name'];
 *      
 *     $get_jk_name_q = sql_q("SELECT cod_name FROM elements WHERE nom_code ='".$nom_code_jk."' AND cod_cod='".$cod_cod_jk."';");
 *     $jk_arr = mysql_fetch_array($get_jk_name_q);
 *     $jk = ", ".$jk_arr['cod_name'];  
 *      
 */
  
  $get_asoc_type = sql_q("SELECT cod_cod, cod_name FROM elements WHERE nom_code ='06' and cod_cod ='".$row['predmet']."'");
  $get_t =mysql_fetch_array($get_asoc_type);
  $type = $get_t['cod_name'];
  
   $sql_srok = "SELECT * FROM elements WHERE nom_code = '53' AND cod_cod='".$row['srok']."'";
            $getsrok = mysql_query($sql_srok) or die(mysql_error());
	        $row_srok = mysql_fetch_assoc($getsrok);
            $srok  = $row_srok['cod_name'];
/**
 *  $street ='';
 *  if($row['street']!=''){
 *     $street = ", ул. ".$row['street'];
 *  }
 */
  echo "<tr>";
  echo "<td class='left_bottom' width='5px' align='center'>&nbsp".$i."</td>";
  echo "<td class='left_bottom' width='70px' align='center'>&nbsp".$row['date']."</td>";
  echo "<td class='left_bottom' width='70px' align='center'>&nbsp".$row['build_identify']."</td>";
 // echo "<td class='left_bottom' width='180px' align='center'>&nbsp".$ra.$nasel.$kvar.$jk.$street. "</td>";
  echo "<td class='left_bottom' width='180px' align='center'>&nbsp".$row['asoc_address']."</td>";
  echo "<td class='left_bottom' width='60px' align='center'>&nbsp".$row['asoc_numb']."</td>";
  echo "<td class='left_bottom' width='60px' align='center'>&nbsp".$row['asoc_name']."</td>";
  echo "<td class='left_bottom' width='80px' align='center'>&nbsp".$type."</td>";
  echo "<td class='left_bottom' width='60px' align='center'>&nbsp".$row['date_of_create']."</td>";
  echo "<td class='left_bottom' width='5px' align='center'>&nbsp".$srok."</td>";
  echo "</tr>";
}
?>
	</table>
<font size="-2">Справката е генерирана от система Брайт РЕГЕС&ПРОГЕС на фирма "Брайт Комплекс АТ" ЕООД.</font>
<form name="xls" id="xls" method="post" action="InquireAsocxls.php">
<input type="hidden" name="query_text" id="query_text" value="<?=stripslashes($query);?>"/>
<input type="submit" name="excel" id="excel" value="Excel"/>
</form>
</body>
</html>