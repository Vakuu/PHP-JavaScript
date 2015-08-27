<?
include("../../inc/conf.php");
    $query_text = $_POST["query_text"];
    if($query_text!=''){
    $query_exe = stripslashes($query_text);
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
        $output.= 'Район'."\t";
        $output.= 'Населено място'."\t";
        $output.= 'Квартал'."\t";
        $output.= 'ЖК.'."\t";
        $output.= '№ Блок'."\t";
        $output.= 'Име на Сдружение'."\t";
        $output.= 'Сдружение'."\t";
        $output.= 'Булстат'."\t";
        $output.= '№ на заявление'."\t";
        $output.= 'Статус на заявление'."\t";
       	$output = preg_replace("/\r\n|\n\r|\n|\r/", ' ', $output);
		print(trim($output))."\t\n";
        }
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
$st;

        //set_time_limit(60); // you can enable this if you have lot of data
		
                $output = '';  
		        $output .= $i."\t";	
            	$output .= $row['date']."\t";
                $output .= $row['build_identify']."\t";
                $output.= $ra."\t";
                $output.= $nasel."\t";
                $output.= $kvar."\t";
                $output.= $jk."\t";
                 $output.= $row['build_numb']."\t";
                 $output.= $row['asoc_name']."\t";
                 $output.= $row['asoc_numb']."\t";
                  $output.= $row['bulstat']."\t";
                  $output.= $row['number']."\t";
                  $output.=$st."\t";
                  
		$output = preg_replace("/\r\n|\n\r|\n|\r/", ' ', $output);
		print(trim($output))."\t\n";
	}
?>