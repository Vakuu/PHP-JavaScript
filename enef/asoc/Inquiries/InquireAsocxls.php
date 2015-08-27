<?
include("../../inc/conf.php");
  $query_text = $_POST["query_text"];
  $query_exe = stripslashes($query_text);
  
   
    if($query_text!=''){
    $result = sql_q($query_exe);
    }
    $fields_num = mysql_num_fields($result);
	header('Content-Type: application/vnd.ms-excel');	//define header info for browser
	header('Content-Disposition: attachment; filename='."Справка".'-'.date('Ymd').'.xls');
	header('Pragma: no-cache');
	header('Expires: 0');
mysql_query("SET NAMES CP1251");
	/*for ($i = 0; $i < mysql_num_fields($result); $i++)	 // show column names as names of MySQL fields
		echo mysql_field_name($result, $i)."\t";
	print("\n");
*/
	$i=0;
    while($row = mysql_fetch_array($result))
	{
if($i==0)
        {
$output = ''; 
$output.= '№'."\t";
$output.= 'Дата/Запис'."\t";
$output.= 'Идентиф.№ сграда'."\t";
$output.='Адрес'."\t";
$output.= 'Име на Сдружение'."\t";
$output.= 'Ид.№ Сдружение'."\t";
$output.= 'Вид на сдружението'."\t";
$output.= 'Дата на регистрация'."\t";
$output.= 'За срок'."\t";
$output = preg_replace("/\r\n|\n\r|\n|\r/", ' ', $output);
print(trim($output))."\t\n";
        }
  $i++;
     /**
 * $k = explode("~",$row['kvartal']);
 *      $nom_code_k = $k[0];
 *      $cod_cod_k = $k[1];
 *      $naspl = explode("~",$row['nasel']);
 *      $nom_code_n = $naspl[0];
 *      $cod_cod_n = $naspl[1];
 *      $jk_ar = explode("~",$row['jk']);
 *      $nom_code_jk = $jk_ar[0];
 *      $cod_cod_jk = $jk_ar[1];

 * $get_raion = sql_q("SELECT region_name FROM regions WHERE show_cod ='".$row['raion']."'");
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
        //set_time_limit(60); // you can enable this if you have lot of data		
/**
 *  $street ='';
 *  if($row['street']!=''){
 *     $street = ", ул. ".$row['street'];
 *  }
 */
$output = '';  
$output .= $i."\t";	
$output .= $row['date']."\t";
$output .= $row['build_identify']."\t";
$output.= $row['asoc_address']."\t";
$output.= $row['asoc_name']."\t";
$output.= $row['asoc_numb']."\t";
$output.= $type."\t";
$output.= $row['date_of_create']."\t";
$output.= $srok."\t";
$output = preg_replace("/\r\n|\n\r|\n|\r/", ' ', $output);
		print(trim($output))."\t\n";
	}
?>