<?php
	include("../inc/conf.php");
/* ****************************************************************************************************************** */
function getKv($kv){
	$kr = explode('~', $kv);
	$nom_code = $kr[0];
	$cod_cod = $kr[1];
	$sql2 = "SELECT cod_name 
			 FROM elements 
			 WHERE nom_code = '" . $nom_code . "' AND cod_cod = '" . $cod_cod . "'";
	$res2 = mysql_query($sql2) or die(mysql_error());
	$row2 = mysql_fetch_assoc($res2);
		return $kvr = $row2['cod_name'];
}
function getConstrType($type){
	$sql = "SELECT cod_name 
			FROM elements 
			WHERE nom_code = '04' AND cod_cod = '$type'";
	$res = mysql_query($sql) or die(mysql_error());
	$row = mysql_fetch_assoc($res);
		return $type = $row['cod_name'];
}
function getPredmet($num){
	$sql = "SELECT cod_name 
			FROM elements 
			WHERE nom_code = '06' AND cod_cod = '" . $num . "'";
	$res = mysql_query($sql) or die(mysql_error());
	$row = mysql_fetch_assoc($res);
		return $num = $row['cod_name'];
}
function getSrok($srok){
	$sql = "SELECT cod_name 
			FROM elements 
			WHERE nom_code = '53' AND cod_cod = '$srok'";
	$res = mysql_query($sql) or die(mysql_error());
	$row = mysql_fetch_assoc($res);
		return $srok = $row['cod_name'];
}
function getPredstavitelstvo($p){
	$sql = "SELECT cod_name 
			FROM elements 
			WHERE nom_code = '03' AND cod_cod = '$p'";
	$res = mysql_query($sql) or die(mysql_error());
	$row = mysql_fetch_assoc($res);
		return $p = $row['cod_name'];
}
	//sql zaqvki
	$sql = "SELECT r.region_name, r.show_cod 
			FROM regions r 
			ORDER BY r.show_cod ASC";
	$res = mysql_query($sql) or die(mysql_error());
/* **************************************************************************************************************** */
	$html = "<!DOCTYPE html>";
	$html .= "<html>";
	$html .= "<head>";
	$html .= "<meta charset='windows-1251'/>";
	$html .= "<style>body{margin: 0;padding: 0;}.results{width: 100%;height: auto;}.test{width: 100%;height: 300px;}.add_for_container{height: 400px;}.hide{display: none;}.style_table tr td{border: 1px solid black;width:auto;}.span{display: inline;}#raion{border-bottom: 1px solid black;text-align: center;}.sdr_container{border: 1px solid black;width: 26%;}.sdr_results{width: 73%;float: right;margin-top: -115px;}hr{color: white;visibility: hidden;}.left{float:left;}.right{float:right;}.full_data{color:blue; cursor: pointer;}.full_data:link{color: blue; text-decoration: none;}.full_data:visited{color: blue; text-decoration: none;}.full_data:hover{color: blue; text-decoration: none;}.full_data:active{color: blue; text-decoration: none;}</style>";
	$html .= "</head>";
	$html .= "<body>";
/* **************************************************************************************************************** */
/* **************************************************************************************************************** */
	$sql2 = "SELECT a.*, p.*, b.raion, r.region_name 
			 FROM asoc a, people p, buildings b, regions r 
			 WHERE r.show_cod = b.raion 
			 AND b.raion = r.show_cod
			 AND a.id = p.asoc_id 
			 AND b.id = a.building_id
			  and a.invalid='0'
			   and b.invalid='0'
			    and p.invalid='0'
			 GROUP BY a.id 
			 ORDER BY a.asoc_numb ASC";
	$res2 = mysql_query($sql2) or die(mysql_error());
			$html .= "<div id='global_div'>";
			$raion2 = "";
		while($row2 = mysql_fetch_assoc($res2)){
			$raion1 = $row2['region_name'];
			if($raion1 == $raion2){
				$html .= "";
			}else{
				$html .= "<div id='raion'><h3>Район \"" . $row2['region_name'] . "\"</h3></div><br/>";
			}
			$raion2 = $row2['region_name'];
			$html .= "<div class='container'>";
			$html .= "<table class='sdr_container'><tr>";
				$html .= "<td>Сдружение рег.№: " . $row2['asoc_numb'];
					$html .= "<input type='hidden' class='hid' value='" . $row2['asoc_numb'] . "' name='hid_asoc'/>";
				$html .= "</td></tr>";
				$html .= "<tr><td>Дата на регистрация: " . format_date($row2['date_of_create']) . "</td></tr>";
				if('date' != '0000-00-00 00-00-00'){
					$html .= "<tr><td>Последно изменение: " . $row2['date'] . "</td></tr>";
				}else{
					$html .= "<tr><td>&nbsp;</td></tr>";
				}
			$html .= "</table><br/>";
/* ****************************************** results tables ************************************************ */
			$html .= "<br/><table class='sdr_results' border='1'>";
				$html .= "<tr>";
				$html .= "<td class='tds'><span>Наименование: " . $row2['asoc_name'] . "</span>";
					$html .= "<div class='results hide'>";
						$html .= "<table class='style_table'>";
							$html .= "<tr>";
								$html .= "<td valign='top'>Адрес: </td>";
								$html .= "<td valign='top'>".$row2['asoc_address']."</td>";
							$html .= "</tr>";
							$html .= "<tr>";
								$html .= "<td>Предмет на дейност: </td>";
								$html .= "<td>".getPredmet($row2['predmet'])."</td>";
							$html .= "</tr>";
							$html .= "<tr>";
								$html .= "<td>Срок на учредяване: </td>";
								$html .= "<td>".getSrok($row2['srok'])."</td>";
							$html .= "</tr>";
							$html .= "<tr>";
								$html .= "<td>Представение идеални части: </td>";
								$html .= "<td valign='top'>".$row2['asoc_ideal_parts']."</td>";
							$html .= "</tr>";
							$html .= "<tr>";
								$html .= "<td valign='top'>Управителен съвет: </td>";
								$html .= "<td valign='top'>";
									$html .= "<div style='overflow-y: auto; height: 184px;'>";
										$sql3 = "SELECT p.*, e.cod_name  
												 FROM people p, elements e 
												 WHERE p.asoc_id = '".$row2['asoc_id']."' 
												 AND e.nom_code = '01' 
												 AND p.type = e.cod_cod and p.invalid='0'";
										$res3 = mysql_query($sql3) or die(mysql_error());
												$typeS = "";
											while($row3 = mysql_fetch_assoc($res3)){
												$typeP = $row3['type'];
												if($typeP == $typeS){
													$html .= "";
												}else{
													$html .= "<b>".$row3['cod_name'] ." :</b><br/>".$row3['name'] . ".<br/> <b>Адрес:</b> ".$row3['address']."<br/>";
												}
												$typeS = $row3['type'];
											}
									$html .= "</div>";
								$html .= "</td>";
							$html .= "</tr>";
							$html .= "<tr>";
							$html .= "<td>";
							$html .= "Начин на представителство";
							$html .= "</td>";
							$html .= "<td>".getPredstavitelstvo($row2['predst'])."</td>";
							$html .= "</tr>";
							$html .= "<tr>";
							$html .= "<td height='150px' valign='top'>";
							$html .= "Документи";
							$html .= "</td>";
							$html .= "<td valign='top'>";
								$sql4 = "SELECT e.cod_name, d.number, d.theirs_date, d.status, d.type_flag 
										 FROM elements e, documents d 
										 WHERE e.cod_cod = d.status 
										 AND d.asoc_id = '".$row2['asoc_id']."'
										 AND e.nom_code = IF (d.type_flag<10,CONCAT('0',d.type_flag),d.type_flag)";
								$res4 = mysql_query($sql4) or die(mysql_error());
										$statusS = "";
									while($row4 = mysql_fetch_assoc($res4)){
										if($row4['type_flag'] == '5'){
											$type_flag = 'Заявление: ';
										}
										if($row4['type_flag'] == '50'){
											$type_flag = 'Договор: ';
										}
										if($row4['type_flag'] == '55'){
											$type_flag = 'Документ: ';
										}
										
										$statusP = $row4['cod_name'];
											if($statusP == $statusS){
												$html .= "";
											}else{
												$html .= $type_flag." - №" . $row4['number'] . ' ' . format_date($row4['theirs_date']) . ' ' . $row4['cod_name'] . "<br/>";
											}
										$statusS = $row4['cod_name'];
										$type_flag = "";
									}
							$html .= "</td>";
							$html .= "</tr>";
						$html .= "</table>";
					$html .= "</div>";
				$html .= "<span class='full_data right' onclick='displayHide(this.id, this.parentNode.id);' name='full_data'>виж пълните данни &gt;&gt;&gt;</span>";
				$html .= "</td>";
				$html .= "</tr>";
			$html .= "</table>";
			$html .= "</div>";
		}
// }
	$html .= "</div>";
	$html .= "</body>";
	$html .= "<script>var full_data = document.getElementsByClassName('full_data');var containers = document.getElementsByClassName('container');var hid = document.getElementsByClassName('hid');var cont = document.getElementsByClassName('sdr_container');var sdr = document.getElementsByClassName('sdr_results');var tds = document.getElementsByClassName('tds');var div = document.getElementsByClassName('results');for(var e = 0; e < full_data.length; e++){full_data[e].setAttribute('id', 'span' + e);}for(var f = 0; f < containers.length; f++){containers[f].setAttribute('id', 'con' + f);}for(var g = 0; g < hid.length; g++){hid[g].setAttribute('id', 'hid' + g);}for(var h = 0; h < cont.length; h++){cont[h].setAttribute('id', 'cont' + h);}for(var i = 0; i < sdr.length; i++){sdr[i].setAttribute('id', 'sdr' + i);}for(var j = 0; j < tds.length; j++){tds[j].setAttribute('id', 'tds' + j);}for(var k = 0; k < div.length; k++){div[k].setAttribute('id', 'div' + k);}</script>";
	$html .= "<script>function displayHide(s, a){var td_s = document.getElementById(a);var div = td_s.firstChild.nextSibling;var container = td_s.parentNode.parentNode.parentNode.parentNode;if(document.getElementById(s).innerHTML.slice(0, 17) == 'виж пълните данни'){document.getElementById(s).innerHTML = 'скрий &lt;&lt;&lt;';document.getElementById(div.id).className = '';document.getElementById(container.id).style.height = '600px';}else{if(document.getElementById(s).innerHTML.slice(0, 5) == 'скрий'){document.getElementById(s).innerHTML = 'виж пълните данни &gt;&gt;&gt;';document.getElementById(container.id).style.height = '126px';document.getElementById(div.id).className = 'hide';}}}</script>";
	$html .= "</html>";
	// if($_POST){
		header('Content-type: text/html');
		header("Content-Disposition: attachment; filename=". date('d_m_Y') . '_' . "filename.html");
		echo $html;
	// }else{
		// echo $html;
	// }
// echo "<br/>";
// echo "<form name='' method='post' action='#'>";
// echo "<input type='submit' name='submit' value='Експортиране' style='position: absolute; bottom: 10px; right: 5px;'/>";
// echo "</form>";
?>