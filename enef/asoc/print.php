<?php
	include("../inc/conf.php");
	include "functions.php";

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	$a_id = mysql_real_escape_string($_GET['as_id']);
		
	if(!empty($a_id)){
		$sql = "SELECT asoc_numb, building_id, asoc_address 
				FROM asoc 
				WHERE id = '". $a_id . "'";
	}

	$res = mysql_query($sql) or die(mysql_error());
		while($row = mysql_fetch_assoc($res)){
			$a_numb = $row['asoc_numb'];
		}
		
	$sql2 = "SELECT cod_name 
			 FROM elements 
			 WHERE nom_code = '02' AND cod_cod = '" . $_SESSION['placement'] . "'";
	$res2 = mysql_query($sql2) or die(mysql_error());
	$row2 = mysql_fetch_assoc($res2);
	$obshtina = $row2['cod_name'];
	if($obshtina == 'Столична община'){
		$ob = '';
	}else{
		$ob = 'ОБЩИНА ';
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	$sqlRaion = "SELECT cod_name 
				 FROM elements 
				 WHERE nom_code = '02' AND cod_cod = '" . $_SESSION['placement'] . "'";
	$resRaion = mysql_query($sqlRaion) or die(mysql_error());
	$rowRaion = mysql_fetch_assoc($resRaion);
	// echo $rowRaion['cod_name'];
/* ----------------------------------------------------------------------------------------------------- */	
	//tuk ne selektiram ime na sdrujenie
	// 6te se vzima ot GET-a	
	$sqlUd = "SELECT z.number, p.*, a.date_of_entry, a.asoc_name, a.asoc_address, 
					a.srok, a.predmet, a.asoc_numb, a.predst, 
					b.build_numb, b.kvartal, b.street, b.str_nom, 
					a.asoc_ideal_parts 
			  FROM documents z, people p, asoc a, buildings b  
			  WHERE a.id = '$a_id' 
			  AND p.type = '1'
			  AND a.building_id = b.id and a.invalid='0' and b.invalid='0' and p.invalid='0'";
	$resUd = mysql_query($sqlUd) or die(mysql_error());
		while($rowUd = mysql_fetch_assoc($resUd)){
			$vh_nom = $rowUd['number'];
			$preds = $rowUd['name'];
			$sdr_name = $rowUd['asoc_name'];
			$vp_date = $rowUd['date_of_entry'];
			$aso_id = $rowUd['asoc_numb'];
				$kvIra = getKvAndRaion($rowUd['kvartal']);
				$street = $rowUd['street'];
				$bl = $rowUd['build_numb'];
			$address = $kvIra . ', ' . $street . ' №' . $rowUd['str_nom'] . ', бл.' . $bl;
			$predmet = getPredmet($rowUd['predmet']);
			$srok = $rowUd['srok'];
			$ideal = $rowUd['asoc_ideal_parts'];
			$name = $rowUd['name'];
			$n_predst = getPredstavitelstvo($rowUd['predst']);
		}
		 //echo $vh_nom;
		 //echo $preds;
		 //echo $sdr_name;
		//echo convertDate($vp_date);
		//echo $r;
		 //echo $address;
		// echo $predmet;
		 //echo $srok;
		 //echo $ideal;
		// echo $chlens; //za ponedelnik
		// echo $n_predst;
///////////////////////////////////////////////////////////////////////////////////////////////////////////
	$sqlReg = "SELECT b.build_identify, b.year_of_const, b.type_const, b.total_square, b.numb_on_ground, 
					b.numb_half_under, b.numb_under_floors, b.numb_floors,b.all_objects, a.asoc_numb, u.id, a.id 
			   FROM buildings b, asoc a, users u 
			   WHERE a.building_id = b.id AND a.id = '$a_id' and a.invalid='0' and b.invalid='0'";
	$resReg = mysql_query($sqlReg) or die(mysql_error());
		while($rowReg = mysql_fetch_assoc($resReg)){
			$id = $rowReg['id'];
			$name = $rowReg['asoc_numb'];
			$numb = $rowReg['build_identify'];
			$build_year = $rowReg['year_of_const'];
			$type_c = getConstrType($rowReg['type_const']);
			$floors = $rowReg['numb_floors'];
				$on_ground = $rowReg['numb_on_ground'];
				$half_under = $rowReg['numb_half_under'];
				$under = $rowReg['numb_under_floors'];
			$total_square = $rowReg['total_square'];
            $all_objects = $rowReg['all_objects'];            
			$user = getCreator($rowReg['id']);
		}
		// echo $numb;
		// echo $build_year;
		// echo $type_c;
		// echo $total_square;
		// echo $on_ground;
		// echo $half_under;
		// echo $under;
		// echo $floors;
		// echo $name;
		// echo $user;
///////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
<style type="text/css">
	@media screen{div.bb{visibility: visible;}}
	@media print{div.bb{visibility: hidden;}}
</style>
<input type="hidden" id="v" value="<?= $a_id?>" />
<?php
if($_GET['id'] == 11)
{	$sql=sql_q("select d.number, a.* 
					from documents d, asoc a
					where d.id=a.request and a.id='$a_id';");
//					where d.type_flag='5' and d.asoc_id='$a_id' and d.asoc_id=a.id");
	$num_rows = mysql_num_rows($sql);
	if ($num_rows==0)
	{	echo"Няма въведено заявление за това сдружение!";
	}else
	{	$sql2=sql_q("select name from people where type='1' and asoc_id='$a_id' and invalid='0'");
		$num_rows2 = mysql_num_rows($sql2);
		if ($num_rows2==0)
		{ echo"Няма въведен председател за това сдружение!";
		}else
		{	$res=mysql_fetch_assoc($sql);
			$res2=mysql_fetch_assoc($sql2);
			$sql3=sql_q("select name, address, email from people where type='3' and asoc_id='$a_id' and invalid='0' order by name");
			$chlenove='';
			$broq4=0;
			$num_rows3 = mysql_num_rows($sql3);
			if ($num_rows3==0)
			{ echo"Няма въведени членове за това сдружение!";
			}else
			{	$chlenove.='<table border="1" style="margin-left:20px;"><tr><td>&nbsp;</td><td>Трите имена</td><td>Адрес</td><td>Електронна поща</td><tr>';
				while($row=mysql_fetch_assoc($sql3))
				{	$broq4++;
					$chlenove.='<tr><td>'.$broq4.'</td><td>'.$row['name'] . '&nbsp;</td><td>' . $row['address'] . '&nbsp;</td><td>' . $row['email'] . '&nbsp;</td></tr>';
				}
				$chlenove.='</table>';
			}
			$filename = "templates/regSdruj_46a.html";
			$handle = fopen($filename, "r");
			$contents = fread($handle, filesize($filename));
			fclose($handle);
			
            $get_act = " SELECT * FROM elements WHERE nom_code='06' AND cod_cod='".$res['predmet']."'";
            $get_act_q  = sql_q($get_act);
            $ac = mysql_fetch_array($get_act_q);
            $act = $ac['cod_name'];
           
            
            
            $get_rep = "SELECT * FROM elements WHERE nom_code='03' AND cod_cod='".$res['predst']."'";
            $get_rep_q  = sql_q($get_rep);
            $rp = mysql_fetch_array($get_rep_q);
            $rep = $rp['cod_name'];
            
            $sql_srok = "SELECT * FROM elements WHERE nom_code = '53' AND cod_cod='".$res['srok']."'";
            $getsrok = mysql_query($sql_srok) or die(mysql_error());
	        $row_srok = mysql_fetch_assoc($getsrok);
            $srok  = $row_srok['cod_name'];
            
            
            $text = $contents;
			$text = str_replace("%ob%", $ob, $text);
			$text = str_replace("%obshtina%", $obshtina, $text);
			$text = str_replace("%nomer%", $res['number'], $text);
			$text = str_replace("%ime_predsedatel%", $res2['name'], $text);
			$text = str_replace("%ime_sdrujenie%", $res['asoc_name'], $text);
			$text = str_replace("%data_vpisvane%", convertDate($res['date_of_entry']), $text);
			$text = str_replace("%sdruj_nomer%", $res['asoc_numb'], $text);
			$text = str_replace("%naimenovanie%", $res['asoc_name'], $text);
			$text = str_replace("%adres%", $res['asoc_address'], $text);
			$text = str_replace("%deinost%", $act, $text);
			$text = str_replace("%srok%", $srok, $text);
			$text = str_replace("%ideal_parts%", $res['asoc_ideal_parts'], $text);
			$text = str_replace("%br_upr%", $chlenove, $text);
			$text = str_replace("%predstavitelstvo%", $rep, $text);
			$text = str_replace("%ime_kmet%", $kmet, $text);
			echo $text;
		}
	}
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
	if($_GET['id'] == 12){
		// echo"petko". $a_numb;
//echo "12".$a_id;	
    	$sqlp=sql_q("select * from people where type='1' and asoc_id='$a_id' and invalid='0'");
        $rowp = mysql_fetch_assoc($sqlp);
        $preds_name = $rowp['name'].', ';
        $preds_address = "адрес: ".$rowp['address'].', ';
        $preds_phone = "тел.: ".$rowp['phone'].', ';
        $preds_email = "ел.поща: ".$rowp['email'];
        $row_pr = $preds_name. $preds_address.$preds_phone.$preds_email;
        
        
        $sqlc=sql_q("select * from people where type='2' and asoc_id='$a_id' and invalid='0'");
        $rowc = mysql_fetch_assoc($sqlc);
        $c_name = $rowc['name'].', ';
        $c_address = "адрес: ".$rowc['address'].', ';
        $c_phone = "тел.: ".$rowc['phone'].', ';
        $c_email = "ел.поща: ".$rowc['email'];
        $row_c = $c_name. $c_address.$c_phone.$c_email;
    
    $sql3=sql_q("select * from people where type='3' and asoc_id='$a_id' and invalid='0' order by name");
			$chlenove='';
			$broq4=0;
			while($row=mysql_fetch_assoc($sql3))
			{	$broq4++;
				//if ($broq4==1)
				//{	
				    $chlenove.='1.2.'.$broq4.'. '.$row['name'].", адрес: ".$row['address'].", тел.:".$row['phone'].", ел.поща: ".$row['email'].'</br>';
			//	}else
				
			}
    
    $sql4 = sql_q("select * from people where type='4' and asoc_id='$a_id' and invalid='0' order by name");
    $chlenove_k='';
			$broq4r=0;
			while($rowk=mysql_fetch_assoc($sql4))
			{	$broq4r++;
            
                 $chlenove_k.='2.2.'.$broq4r.'. '.$rowk['name'].", адрес: ".$rowk['address'].", тел.:".$rowk['phone'].", ел.поща: ".$rowk['email'].'</br>';
			} 
    $sql_srok = "SELECT * FROM elements WHERE nom_code = '53' AND cod_cod='".$srok."'";
            $getsrok = mysql_query($sql_srok) or die(mysql_error());
	        $row_srok = mysql_fetch_assoc($getsrok);
            $srok1  = $row_srok['cod_name'];
    
    	$filename = "templates/sdrujRegCard.html";
		$handle = fopen($filename, "r");
		$contents = fread($handle, filesize($filename));
		fclose($handle);
		$text = $contents;
		
		$text = str_replace("%reg_numb%", $name, $text);
		$text = str_replace("%reg_year%", convertDate($vp_date), $text);
		// ОСНОВНИ ДАННИ ЗА СДРУЖЕНИЕТО
		$text = str_replace("%naimenovanie%", $sdr_name, $text);
		$text = str_replace("%sdruj_adres%", $address, $text);
		$text = str_replace("%p_deinost%", $predmet, $text);
		$text = str_replace("%srok%", $srok1, $text);
		$text = str_replace("%predstavitelstvo%", $n_predst, $text);
		$text = str_replace("%ideal_parts%", $ideal, $text);
		// ОСНОВНИ ХАРАКТЕРИСТИКИ НА СГРАДАТА
		$text = str_replace("%build_ident%", $numb, $text);
		$text = str_replace("%year_build%", $build_year, $text);
		$text = str_replace("%sys_build%", $type_c, $text);
		$text = str_replace("%numb_floors%", $floors, $text);
		$text = str_replace("%ground%", $on_ground, $text);
		$text = str_replace("%half_ground%", $half_under, $text);
		$text = str_replace("%underground%", $under, $text);
		$text = str_replace("%tova_neznam_kak_da_go_napi6a%", $total_square, $text);
		$text = str_replace("%_build_objects%", $all_objects, $text); // tuk da se opravi
		// УПРАВИТЕЛНИ И КОНТРОЛНИ ОРГАНИ
		$text = str_replace("%data%", date('d-m-Y'), $text);
		$text = str_replace("%srok_godini%", $srok1, $text);
		$text = str_replace("%ime_contr%", $row_c, $text);
       $text = str_replace("%ime_predsedatel%", $row_pr, $text);
       $text = str_replace("%br_upr%", $chlenove, $text);
		// СЪСТАВИТЕЛ
		$text = str_replace("%ime_suzdal%", $user, $text);
        $text = str_replace("%k_s%", $chlenove_k, $text);
		// ДАТА НА СЪЗДАВАНЕ
		$text = str_replace("%data_suzdavane%", date('d-m-Y'), $text);
		echo $text;
	}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
	if($_GET['id'] == 13){
		// echo $a_numb;
		// тук няма да се правят sql заявки
		// кода да не се трие, за да може да се показва файла на екрана
		$filename = "templates/controlList.html";
		$handle = fopen($filename, "r");
		$contents = fread($handle, filesize($filename));
		fclose($handle);
		$text = $contents;
		
		$text = str_replace("%obshtina%", 'sql_res', $text);
		$text = str_replace("%obshtina%", 'sql_res', $text);
		$text = str_replace("%obshtina%", 'sql_res', $text);
		$text = str_replace("%obshtina%", 'sql_res', $text);
		$text = str_replace("%obshtina%", 'sql_res', $text);
		$text = str_replace("%obshtina%", 'sql_res', $text);
		$text = str_replace("%obshtina%", 'sql_res', $text);
		$text = str_replace("%obshtina%", 'sql_res', $text);
		$text = str_replace("%obshtina%", 'sql_res', $text);
		$text = str_replace("%obshtina%", 'sql_res', $text);
		$text = str_replace("%obshtina%", 'sql_res', $text);
		$text = str_replace("%obshtina%", 'sql_res', $text);
		$text = str_replace("%obshtina%", 'sql_res', $text);
		$text = str_replace("%obshtina%", 'sql_res', $text);
		echo $text;
	}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
?>