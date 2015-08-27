<?php
 include("../inc/conf.php");

header("Content-type: text/html; charset=windows-1251");

if($_GET['file'] == 'register'){
	if($_GET['element'] == 'region')
	{	$sql = "SELECT show_cod, region_name FROM regions
					WHERE 1
				";
		if ($_SESSION['placement']!=$nasko)
		{	$sql.=" and show_cod='".$_SESSION['placement']."'";
		}$sql.= " ORDER BY show_cod ASC";
		$res = sql_q($sql);
		$sel = "<select name='raion_sel' id='raion_sel' onchange='document.getElementById(\"str_search\").value=\"\"; onchangeraion();'>";
		if ($_SESSION['placement']==$nasko)
		{	$sel .= "<option value=''></option>";
		}while($row = mysql_fetch_assoc($res))
		{	$show_cod=$row['show_cod'];
			if ($show_cod<10)
			{$show_cod='0'.$show_cod;}
			$sel .= "<option value='" . $row['show_cod'] . "'>".$show_cod.' '.$row['region_name']."</option>";
		}$sel .= "</select>";
		echo $sel;
	}if($_GET['type'] == 'onchangeraion')
	{	$raion=$_GET['raion'];
		$resx = mysql_fetch_assoc(sql_q("select sel_nom, kv_nom, jk_nom from regions where show_cod='$raion'"));
		$sel1 = "<select id='nasel_sel' name='nasel_sel' onchange='document.getElementById(\"str_search\").value=\"\"; ifstreet();'>";
		$sel2 = "<select id='hood_sel' name='hood_sel'>";
		$sel3 = "<select id='jk_sel' name='jk_sel'>";
		$sel2.= "<option value=''></option>";
		$sel3.= "<option value=''></option>";
		$sql1 = "SELECT * FROM elements where nom_code='".$resx['sel_nom']."' ORDER BY cod_name ASC";
		$sql2 = "SELECT * FROM elements where nom_code='".$resx['kv_nom']."' ORDER BY cod_name ASC";
		$sql3 = "SELECT * FROM elements where nom_code='".$resx['jk_nom']."' ORDER BY cod_name ASC";
		$res = sql_q($sql1);
		while($row = mysql_fetch_assoc($res))
		{	if ($row['cod_name']=='гр. София'){$selected='selected';}else {$selected='';}
			$sel1 .= "<option value='".$row['nom_code']."~".$row['cod_cod']."' $selected>".$row['cod_name']."</option>";
		}$sel1 .= "</select>";
		$res = sql_q($sql2);
		while($row = mysql_fetch_assoc($res))
		{	$sel2 .= "<option value='".$row['nom_code']."~".$row['cod_cod']."'>".$row['cod_name']."</option>";
		}$sel2 .= "</select>";
		$res = sql_q($sql3);
		while($row = mysql_fetch_assoc($res))
		{	$sel3 .= "<option value='".$row['nom_code']."~".$row['cod_cod']."'>".$row['cod_name']."</option>";
		}$sel3 .= "</select>";
 		echo $sel1.'$'.$sel2.'$'.$sel3;
	}    	
	if($_GET['element'] == 'construction'){
		$sql = "SELECT * 
				FROM elements 
				WHERE nom_code = '04' 
				ORDER BY cod_name ASC";
		$res = sql_q($sql) or die(mysql_error());
			$sel = "<select name='construct_type' id='construct_type'>";
			$sel .= "<option value=''></option>";
			while($row = mysql_fetch_assoc($res)){
				$sel .= "<option value='" . $row['cod_cod'] . "'>" . $row['cod_name'] . "</option>";
			}
			$sel .= "</select>";
				echo $sel;
	}
			if($_GET['type'] == 'sdr'){
			if($_GET['element'] == 'activity'){
				$sql = "SELECT *
						FROM elements 
						WHERE nom_code = '06' 
						ORDER BY cod_name ASC";
				$res = sql_q($sql) or die(mysql_error());
				$sel = "<select id='predmet' name='predmet'>";
				$sel .= "<option value=''></option>";
				while($row = mysql_fetch_assoc($res)){
					$sel .= "<option value='" . $row['cod_cod'] . "'>" . $row['cod_name'] . "</option>";
				}
				$sel .= "</select>";
					echo $sel;
			}
			if($_GET['element'] == 'predst'){
				$sql = "SELECT *
						FROM elements 
						WHERE nom_code = '03' 
						ORDER BY cod_name ASC";
				$res = sql_q($sql) or die(mysql_error());
				$sel = "<select name='predst' id='predst'>";
				$sel .= "<option value=''></option>";
				while($row = mysql_fetch_assoc($res)){
					$sel .= "<option value='" . $row['cod_cod'] . "'>" . $row['cod_name'] . "</option>";
				}
				$sel .= "</select>";
					echo $sel;
			}
			
		}

	if($_GET['what'] == 'save_build')
	{	if ($_GET['save_redact'] == 2)
		{	$sql = "SELECT *
					FROM buildings 
					WHERE id = '".$_GET['hid_build_id']."'";
			$num_rows = mysql_num_rows(sql_q($sql));
			if ($num_rows>0)
			{	$res = mysql_fetch_assoc(sql_q($sql));
				$sql1 = "SELECT max(sn) as sn
					FROM buildings_history
					WHERE build_id = '".$_GET['hid_build_id']."'";
				$num_rows1 = mysql_num_rows(sql_q($sql1));
				if ($num_rows1>0)
				{	$res1 = mysql_fetch_assoc(sql_q($sql1));
					$res1 = $res1['sn'];
					$next_sn=$res1+1;
				}else
				{	$next_sn=0;
				}sql_q("insert into buildings_history (build_id, build_identify, sn, date, user_id, build_numb,
						raion, nasel, kvartal, jk, vhodove, numb_floors, numb_under_floors,
						numb_half_under, numb_on_ground, all_objects, object_fiz,
						object_comp, object_os, object_ds, object_trade, year_of_const,
						type_const, total_square, pril_parts, secs, street, str_nom)
						 values ('".$res['id']."','".$res['build_identify']."', '".$next_sn."', now(), '".$res['user_id']."', '".$res['build_numb']."',
						  '".$res['raion']."', '".$res['nasel']."', '".$res['kvartal']."', '".$res['jk']."', '".$res['vhodove']."', '".$res['numb_floors']."', '".$res['numb_under_floors']."',
						  '".$res['numb_half_under']."', '".$res['numb_on_ground']."', '".$res['all_objects']."', '".$res['object_fiz']."',
						  '".$res['object_comp']."', '".$res['object_os']."', '".$res['object_ds']."', '".$res['object_trade']."', '".$res['year_of_const']."',
						  '".$res['type_const']."', '".$res['total_square']."', '".$res['pril_parts']."', '".$res['secs']."', '".$res['street']."', '".$res['str_nom']."')
						  ");
				sql_q("update buildings set build_identify='".$_GET['build_identify']."', user_id='".$_SESSION['user_id']."', build_numb='".$_GET['build_numb']."',
						raion='".$_GET['raion']."', nasel='".$_GET['nasel']."', kvartal='".$_GET['hood']."', jk='".$_GET['jk']."', vhodove='".$_GET['vhodove']."', numb_floors='".$_GET['numb_floors']."', numb_under_floors='".$_GET['numb_under_floors']."',
						numb_half_under='".$_GET['numb_half_under']."', numb_on_ground='".$_GET['numb_on_ground']."', all_objects='".$_GET['all_objects']."', object_fiz='".$_GET['object_fiz']."',
						object_comp='".$_GET['object_comp']."', object_os='".$_GET['object_os']."', object_ds='".$_GET['object_ds']."', object_trade='".$_GET['object_trade']."', year_of_const='".$_GET['year_of_const']."',
						type_const='".$_GET['construct_type']."', total_square='".$_GET['total_square']."', pril_parts='".$_GET['pril_parts']."', secs='".$_GET['secs']."', street='".$_GET['street']."', str_nom='".$_GET['str_nom']."' where id='".$res['id']."'");
				sql_q("update asoc set asoc_address='".$_GET['asoc_address']."' where building_id='".$_GET['hid_build_id']."';");
				echo("Успешен запис!".$_GET['hid_build_id']);
			}
		}else
		{	$sql = "SELECT *
				FROM buildings 
				WHERE build_identify = '".$_GET['build_identify']."' and invalid='0'";
			$num_rows = mysql_num_rows(sql_q($sql));
			if ($num_rows>0)
			{	echo("Вече има въведена сграда с такъв идентификационен номер! Моля въведете нов номер! Възможно е някой от друг район по погрешка да е въвел този номер, обърнете се към компетентно лице за отстраняване на проблема.");
			}else
			{
				sql_q("insert into buildings (build_identify, date, user_id, build_numb,
					raion, nasel, kvartal, jk, vhodove, numb_floors, numb_under_floors,
					numb_half_under, numb_on_ground, all_objects, object_fiz,
					object_comp, object_os, object_ds, object_trade, year_of_const,
					type_const, total_square, pril_parts, secs, street, str_nom)
					 values ('".$_GET['build_identify']."', now(), '".$_SESSION['user_id']."', '".$_GET['build_numb']."',
					  '".$_GET['raion']."', '".$_GET['nasel']."', '".$_GET['hood']."', '".$_GET['jk']."', '".$_GET['vhodove']."', '".$_GET['numb_floors']."', '".$_GET['numb_under_floors']."',
					  '".$_GET['numb_half_under']."', '".$_GET['numb_on_ground']."', '".$_GET['all_objects']."', '".$_GET['object_fiz']."',
					  '".$_GET['object_comp']."', '".$_GET['object_os']."', '".$_GET['object_ds']."', '".$_GET['object_trade']."', '".$_GET['year_of_const']."',
					  '".$_GET['construct_type']."', '".$_GET['total_square']."', '".$_GET['pril_parts']."', '".$_GET['secs']."', '".$_GET['street']."',
					  '".$_GET['str_nom']."')
					  ");
				$sqlx = "SELECT id 
							FROM buildings
							WHERE build_identify = '".$_GET['build_identify']."' and invalid='0'";
				$resx = mysql_fetch_assoc(sql_q($sqlx));
	  			echo("Успешен запис!".$resx['id']);
  			}
		}
	}
	if($_GET['what'] == 'ifstreet')
	{	if ($_GET['nasel']=='grs')
		{	$sql = "SELECT str_name 
				FROM streets 
				WHERE cod_name='гр. София'";
				//WHERE nom_code='' and cod_cod='0'";//АЛТЕРНАТИВА В СЛУЧАЙ НА ДОБАВЯНЕ ИЛИ РЕДАКТИРАНЕ НА УЛИЦА
		}else
		{	$nasel = explode('~',$_GET['nasel']);
			$sql = "SELECT str_name	FROM streets WHERE nom_code='".$nasel[0]."' and cod_cod='".$nasel[1]."'";
		}if (empty($_GET['str_search']))
		{	$str_search='';
		}else
		{	$sql.=" and str_name like '%".$_GET['str_search']."%'";
		}$num_rows1 = mysql_num_rows(sql_q($sql));
		if ($num_rows1==0)
		{	echo("0");
		}
		if ($num_rows1==1)
		{	$res = mysql_fetch_assoc(sql_q($sql));
			$html= "<select name='street_sel' id='street_sel' onchange='document.getElementById(\"str_search\").value=document.getElementById(\"street_sel\").value;fill_hid_adr();'>";
			$html.= "<option value=''></option>";
			$html.="<option value='".$res['str_name']."' selected>".$res['str_name']."</option>";
			$html.="</select>";
			echo("1".$html);
		}else
		{	$sel = "<select name='street_sel' id='street_sel' onchange='document.getElementById(\"str_search\").value=document.getElementById(\"street_sel\").value;fill_hid_adr();'>";
			$sel.= "<option value=''></option>";
			$row=sql_q($sql);
			while ($res = mysql_fetch_assoc($row))
			{	$sel .= "<option value='".$res['str_name']."'>".$res['str_name']."</option>";
			}$sel.="</select>";
			echo("2".$sel);
		}
	}
	if($_GET['what'] == 'ifbuild')
	{	$sign=$_GET['sign'];
		if ($sign=='=')
		{	$sign2='';
		}else
		{	$sign2='%';
		}$sql = "SELECT * 
				FROM buildings 
				WHERE build_identify ".$sign." '".$_GET['build_identify'].$sign2."' and invalid='0'";
		if ($_SESSION['placement']!=$nasko)
		{	$sql.=" and raion='".$_SESSION['placement']."'";
		}
		$num_rows = mysql_num_rows(sql_q($sql));
		if ($num_rows==0)
		{	echo("0");
		}else
		{	if ($num_rows==1)
			{	$res = mysql_fetch_assoc(sql_q($sql));
				$html=implode('@', $res);
				echo("1".$html);
			}else
			{	$sel = "<select name='manyb' id='manyb'
							onchange=\"fillformb(); document.getElementById('build_identify').value=document.getElementById('build_identifyh').value;
							if (document.getElementById('build_identify').value!='')
							{	document.getElementById('bselected').value='';
								displayHide(document.getElementById('build_form_container'), '+');
								document.forms['asoc_form'].reset();
								document.forms['represents'].reset();
								getOverIt();
								document.forms['rq_form'].reset();
								document.getElementById('contr_zaqv').className='hide';
								document.getElementById('asoc_ident_rn').value='';
								document.getElementById('asoc_ident_b').value='';
								ifasoc('like');
								ifbuild('=');
							}else
							{	document.getElementById('autocompletea').innerHTML='';
							}\" 
							onclick=\"if (document.getElementById('bselected').value == document.getElementById('manyb').value)
							{	document.getElementById('bselected').value='';
								fillformb(); document.getElementById('build_identify').value=document.getElementById('build_identifyh').value;
								if (document.getElementById('build_identify').value!='')
								{	displayHide(document.getElementById('build_form_container'), '+');
									document.forms['asoc_form'].reset();
									document.forms['represents'].reset();
									getOverIt();
									document.forms['rq_form'].reset();
									document.getElementById('contr_zaqv').className='hide';
									document.getElementById('asoc_ident_rn').value='';
									document.getElementById('asoc_ident_b').value='';
									ifasoc('like');
									ifbuild('=');
								}else
								{	document.getElementById('autocompletea').innerHTML='';
								}
							}else
							{	document.getElementById('bselected').value=document.getElementById('manyb').value;
							}
							\">";
				$row=sql_q($sql);
				while ($res = mysql_fetch_assoc($row))
				{	$sel .= "<option value='".implode('@', $res)."'>".$res['build_identify']."</option>";
				}$sel.="</select>";
				echo("2".$sel);
			}
		}
	}if($_GET['what'] == 'save_asoc')
	{	if ($_GET['save_redact'] == 2)
		{	$sql = "SELECT *
					FROM asoc 
					WHERE id = '".$_GET['hid_asoc_id']."'";
			$num_rows = mysql_num_rows(sql_q($sql));
			if ($num_rows>0)
			{	$res = mysql_fetch_assoc(sql_q($sql));
				$sql1 = "SELECT max(sn) as sn
					FROM asoc_history
					WHERE asoc_id = '".$_GET['hid_asoc_id']."'";
				$num_rows1 = mysql_num_rows(sql_q($sql1));
				if ($num_rows1>0)
				{	$res1 = mysql_fetch_assoc(sql_q($sql1));
					$res1 = $res1['sn'];
					$next_sn=$res1+1;
				}else
				{	$next_sn=0;
				}sql_q("insert into asoc_history (asoc_id, user_id, date, sn, asoc_numb, bulstat, asoc_name,
				asoc_address, entries, date_of_create, srok, date_of_entry, predmet,
				predst, asoc_term_year, asoc_ideal_parts, asoc_manager_id,
				manager_team, control_id, request, building_id, bl_secs)
				values ('".$res['id']."', '".$res['user_id']."', '".$res['date']."', '".$next_sn."', '".$res['asoc_numb']."',
				 '".$res['bulstat']."', '".$res['asoc_name']."', '".$res['asoc_address']."', '".$res['entries']."', '".$res['date_of_create']."', '".$res['srok']."',
				 '".$res['date_of_entry']."', '".$res['predmet']."', '".$res['predst']."', '".$res['asoc_term_year']."', '".$res['asoc_ideal_parts']."',
				 '".$res['asoc_manager_id']."', '".$res['manager_team']."', '".$res['control_id']."', '".$res['request']."',
				 '".$res['building_id']."', '".$res['bl_secs']."')
				");
			  sql_q("update asoc set user_id='".$_SESSION['user_id']."', asoc_numb='".trim($_GET['asoc_numb'])."', bulstat='".$_GET['bulstat']."',
			   asoc_name='".$_GET['asoc_name']."', asoc_address='".$_GET['asoc_address']."', entries='".$_GET['entries']."', date_of_create='".format_date($_GET['date_of_create'])."',
				srok='".$_GET['srok']."', date_of_entry='".format_date($_GET['date_of_entry'])."', predmet='".$_GET['predmet']."', predst='".$_GET['predst']."',
				asoc_ideal_parts='".$_GET['asoc_ideal_parts']."', building_id='".$_GET['hid_build_id']."', bl_secs='".$_GET['bl_secs']."' where id='".$_GET['hid_asoc_id']."'");
		  		echo("Успешен запис!".$_GET['hid_asoc_id']);
			}
		}else
		{	$sql = "SELECT * FROM asoc WHERE invalid='0'";
			if ($_GET['bulstat']=='')
			{	$sql.=" and asoc_numb = '".$_GET['asoc_numb']."'";
			}else
			{	$sql.=" and (bulstat = '".$_GET['bulstat']."' or asoc_numb = '".$_GET['asoc_numb']."')";
			}
			$num_rows = mysql_num_rows(sql_q($sql));
			if ($num_rows>0)
			{	echo("Вече има въведено сдружение с такъв булстат или с такъв регистрационен номер! Моля въведете булстат и номер, или натиснете бутон 'редактирай текущото' за да промените булстата или рег номера на текущото !");
			}else
			{	if (empty($_GET['asoc_numb']))
				{	echo('Регистрационен номер на сдружение е задължителен!');
				}else
				{	sql_q("insert into asoc (user_id, date, asoc_numb, bulstat, asoc_name,
					asoc_address, entries, date_of_create, srok, date_of_entry, predmet,
					predst, asoc_ideal_parts, building_id, bl_secs)
					values ('".$_SESSION['user_id']."', now(), '".$_GET['asoc_numb']."', '".$_GET['bulstat']."', '".$_GET['asoc_name']."',
					 '".$_GET['asoc_address']."','".$_GET['entries']."', '".format_date($_GET['date_of_create'])."', '".$_GET['srok']."', '".format_date($_GET['date_of_entry'])."', '".$_GET['predmet']."',
					 '".$_GET['predst']."', '".$_GET['asoc_ideal_parts']."', '".$_GET['hid_build_id']."', '".$_GET['bl_secs']."')
					  ");
					$sqlx = "SELECT id 
							FROM asoc
							WHERE asoc_numb = '".$_GET['asoc_numb']."' and building_id='".$_GET['hid_build_id']."'
							";
					$resx = mysql_fetch_assoc(sql_q($sqlx));
		  			echo("Успешен запис!".$resx['id']);
	  			}
  			}
		}
	}
	if($_GET['what'] == 'ifasoc')
	{	$sign=$_GET['sign'];
		if ($sign=='=')
		{	$sign2='';
		}else
		{	$sign2='%';
		}$sql = "SELECT *, DATE_FORMAT(date_of_create,'%d-%m-%Y') AS date_of_create, DATE_FORMAT(date_of_entry,'%d-%m-%Y') AS date_of_entry 
				FROM asoc 
				WHERE invalid='0'";
		if (!empty($_GET['asoc_ident_rn']))
		{	$sql .= " and asoc_numb ".$sign." '".$_GET['asoc_ident_rn'].$sign2."'";
		}if (!empty($_GET['asoc_ident_b']))
		{	$sql .= " and bulstat like '".$_GET['asoc_ident_b']."%'";
		}if (!empty($_GET['hid_build_id']))
		{	$sql .=" and building_id='".$_GET['hid_build_id']."'";
		}$num_rows = mysql_num_rows(sql_q($sql));
		if ($num_rows==0)
		{	echo("0");
		}else
		{	$row=sql_q($sql);
			if ($num_rows==1)
			{	$res = mysql_fetch_assoc($row);
				$html=implode('@', $res);
				$fsql="SELECT * FROM attached_files WHERE asoc_id='".$res['id']."' AND dell_flag=0";
				$files=mysql_num_rows(sql_q($fsql));
				$html.="@".$files;
				echo("1".$html);
			}else
			{	$sel = "<select name='manya' id='manya'
							onchange=\"fillforma(); document.getElementById('asoc_ident_rn').value=document.getElementById('asoc_numbh').value;
							if (document.getElementById('asoc_ident_rn').value!='')
							{	document.getElementById('aselected').value='';
								displayHide(document.getElementById('association_form_container'), '+');
								document.forms['represents'].reset();
								getOverIt();
								document.forms['rq_form'].reset();
								document.getElementById('contr_zaqv').className='hide';
								ifasoc('=');
							}else
							{	document.getElementById('autocompletea').innerHTML='';
							}\"
							onclick=\" if (document.getElementById('aselected').value == document.getElementById('manya').value)
							{	document.getElementById('aselected').value='';
								fillforma(); document.getElementById('asoc_ident_rn').value=document.getElementById('asoc_numbh').value;
								if (document.getElementById('asoc_ident_rn').value!='')
								{	displayHide(document.getElementById('association_form_container'), '+');
									document.forms['represents'].reset();
									getOverIt();
									document.forms['rq_form'].reset();
									document.getElementById('contr_zaqv').className='hide';
									ifasoc('=');
								}else
								{	document.getElementById('autocompletea').innerHTML='';
								}
							}else
							{	document.getElementById('aselected').value=document.getElementById('manya').value;
							}
							\" >";
				while ($res = mysql_fetch_assoc($row))
				{	$fsql="SELECT * FROM attached_files WHERE asoc_id='".$res['id']."' AND dell_flag=0";
					$files=mysql_num_rows(sql_q($fsql));
					$sel .= "<option value='".implode('@', $res)."@".$files."'>Рег.№:".$res['asoc_numb']."</option>";
				}$sel.="</select>";
				echo("2".$sel);
			}
		}
	}
	if($_GET['element'] == 'predstaviteli')
	{	$sql = "SELECT * 
				FROM elements 
				WHERE nom_code = '01'";
		$res = sql_q($sql) or die(mysql_error());
		$sel = "<select name='type' id='type'
						onchange='
									document.getElementById(\"name\").value=\"\";
									document.getElementById(\"address\").value=\"\";
									document.getElementById(\"phone\").value=\"\";
									document.getElementById(\"email\").value=\"\";
									document.getElementById(\"cureditp\").disabled=true;
									'
				>";
		while($row = mysql_fetch_assoc($res))
		{	$sel .= "<option value='" . $row['cod_cod'] . "'>". $row['cod_name'] . "</option>";
		}
		$sel .= "</select>";
		$sel .= "&nbsp; на сдружение &nbsp;";
		$sel .= "<input type='text' name='sdruj_name' id='sdruj_name' readonly />";
		echo $sel;
	}
	if($_GET['what'] == 'save_rep')
	{	if ($_GET['save_redact'] == 2)
		{	$mecho="да";
			if ($_GET['type']=='1')
			{	$sql = "SELECT *
					FROM people 
					WHERE type = '1' and asoc_id = '".$_GET['asoc_id']."' and invalid='0'";
				$row=mysql_fetch_assoc(sql_q($sql));
				$num_rows = mysql_num_rows(sql_q($sql));
				if ($num_rows>0)
				{	if ($row['id']!=$_GET['people_id'])
					{	$mecho="Председателят на това сдружение е вече въведен!";
					}
				}
			}else
			{	if ($_GET['type']=='2')
				{	$sql = "SELECT *
							FROM people 
							WHERE type = '2' and asoc_id = '".$_GET['asoc_id']."' and invalid='0'";
					$row=mysql_fetch_assoc(sql_q($sql));
					$num_rows = mysql_num_rows(sql_q($sql));
					if ($num_rows>0)
					{	if ($row['id']!=$_GET['people_id'])
						{	$mecho="Контрольора на това сдружение е вече въведен!";
						}
					}
				}
			}if ($mecho=="да")
			{	$sql = "SELECT *
						FROM people 
						WHERE id = '".$_GET['people_id']."' and invalid='0'";
				$num_rows = mysql_num_rows(sql_q($sql));
				if ($num_rows>0)
				{	$res = mysql_fetch_assoc(sql_q($sql));
					$sql1 = "SELECT max(sn) as sn
						FROM people_history
						WHERE people_id = '".$_GET['people_id']."'";
					$num_rows1 = mysql_num_rows(sql_q($sql1));
					if ($num_rows1>0)
					{	$res1 = mysql_fetch_assoc(sql_q($sql1));
						$res1 = $res1['sn'];
						$next_sn=$res1+1;
					}else
					{	$next_sn=0;
					}sql_q("insert into people_history (people_id, sn, name, address, phone, email, type, asoc_id, date, user_id)
					values ('".$res['id']."', '".$next_sn."', '".$res['name']."', '".$res['address']."', '".$res['phone']."',
					 '".$res['email']."', '".$res['type']."', '".$res['asoc_id']."', '".$res['date']."', '".$res['user_id']."')
					");
					sql_q("update people set user_id='".$_SESSION['user_id']."', name='".$_GET['name']."', address='".$_GET['address']."',
						phone='".$_GET['phone']."', email='".$_GET['email']."', type='".$_GET['type']."', asoc_id='".$_GET['asoc_id']."' where id='".$_GET['people_id']."'"
						);
				   echo("Успешна редакция!");
			   }
			}else
			{	echo($mecho);
			}
		}else
		{	if ($_GET['type']=='1')
			{	$sql = "SELECT *
					FROM people 
					WHERE type = '1' and asoc_id = '".$_GET['asoc_id']."' and invalid='0'";
				$mecho="Председателят на това сдружение е вече въведен!";
				$num_rows = mysql_num_rows(sql_q($sql));
				if ($num_rows>0)
				{	echo($mecho);
				}else
				{	sql_q("insert into people (name, address, phone, email, type,
						asoc_id, date, user_id)
						values ('".$_GET['name']."', '".$_GET['address']."', '".$_GET['phone']."', '".$_GET['email']."', 
						'".$_GET['type']."', '".$_GET['asoc_id']."', now(), '".$_SESSION['user_id']."');
				  			");
					$sqlx = "SELECT id 
							FROM people
							WHERE phone = '".$_GET['phone']."' and invalid='0'";
					$resx = mysql_fetch_assoc(sql_q($sqlx));
		  			echo("Успешен запис!");
				}
			}else
			{	if ($_GET['type']=='2')
				{	$sql = "SELECT *
						FROM people 
						WHERE type = '2' and asoc_id = '".$_GET['asoc_id']."' and invalid='0'";
					$mecho="Контрольора на това сдружение е вече въведен!";
					$num_rows = mysql_num_rows(sql_q($sql));
					if ($num_rows>0)
					{	echo($mecho);
					}else
					{	sql_q("insert into people (name, address, phone, email, type,
							asoc_id, date, user_id)
							values ('".$_GET['name']."', '".$_GET['address']."', '".$_GET['phone']."', '".$_GET['email']."', 
							'".$_GET['type']."', '".$_GET['asoc_id']."', now(), '".$_SESSION['user_id']."');
					  			");
						$sqlx = "SELECT id 
								FROM people
								WHERE phone = '".$_GET['phone']."' and invalid='0'";
						$resx = mysql_fetch_assoc(sql_q($sqlx));
			  			echo("Успешен запис!");
					}
				}else
				{	sql_q("insert into people (name, address, phone, email, type,
						asoc_id, date, user_id)
						values ('".$_GET['name']."', '".$_GET['address']."', '".$_GET['phone']."', '".$_GET['email']."', 
						'".$_GET['type']."', '".$_GET['asoc_id']."', now(), '".$_SESSION['user_id']."');
				  			");
					$sqlx = "SELECT id 
							FROM people
							WHERE phone = '".$_GET['phone']."' and invalid='0'";
					$resx = mysql_fetch_assoc(sql_q($sqlx));
		  			echo("Успешен запис!");
				}
			}
		}
	}if($_GET['what'] == 'ifpeople')
	{	$sql = "SELECT * 
					FROM people
					WHERE id = '".$_GET['people_id']."'";
		$num_rows = mysql_num_rows(sql_q($sql));
		if ($num_rows==0)
		{	echo("0");
		}else
		{	if ($num_rows==1)
			{	$res = mysql_fetch_assoc(sql_q($sql));
				$html=implode('~', $res);
				echo("1".$html);
			}
		}
	}
	if($_GET['what'] == 'refresh_list')
	{	$sql = "SELECT p.id, p.name, e.cod_name 
					FROM people p, elements e
					WHERE p.asoc_id = '".$_GET['asoc_id']."'
					and p.type=e.cod_cod and e.nom_code='01' and p.invalid='0'";
		$res=sql_q($sql);
		$sel = '<select id="persons" name="persons" size="15" onchange="ifpeople();">';
		//$sel .= "<option value=''></option>";
		while($row = mysql_fetch_assoc($res))
		{	$sel .= "<option value='".$row['id']."'>".$row['name']." - ".$row['cod_name']."</option>";
		}$sel .= "</select>";
		echo $sel;
	}			
	if($_GET['what'] == 'refresh_rq_co')
	{	$ima6ti=0;
		$sqlself = "SELECT request FROM asoc
					WHERE id = '".$_GET['asoc_id']."'";
		$resself=mysql_fetch_assoc(sql_q($sqlself));
		$sql = "SELECT id, number, DATE_FORMAT(theirs_date,'%d-%m-%Y') AS theirs_date, status, description, type_flag, DATE_FORMAT(theirs2_date,'%d-%m-%Y') AS theirs2_date, doc_type
					FROM documents
					WHERE asoc_id = '".$_GET['asoc_id']."'";
		if ($resself['request']!='')
		{	$sql.=" or id='".$resself['request']."'";
			$ima6ti=$resself['request'];
		}
		$sql.="order by type_flag asc, id asc";
		$num_rows = mysql_num_rows(sql_q($sql));
		if ($num_rows==0)
		{	$sel = "<select name='manyrc' id='manyrc'>";
			$sel .= "<option value=''>Няма въведени нито заявление нито договори!</option>";
			$sel.="</select>";
			echo("0".$sel);
		}else
		{	if ($num_rows==1)
			{	$res = mysql_fetch_assoc(sql_q($sql));
				if ($res['type_flag']==5)
				{	$type_flag='Заявление: '.$res['number'];
				}if ($res['type_flag']==50)
				{	$type_flag='Договор: '.$res['number'];
				}if ($res['type_flag']==55)
				{	$type_flag='Документ: '.$res['number'];
				}
				$sel = "<select name='manyrc' id='manyrc'
							onchange=\"document.getElementById('what_att').value='';
										document.getElementById('save_rq_button').disabled=true;
										document.getElementById('save_rq_button2').disabled=false;
										getwoman(this.value,'status_section');
										\"
							>";
				$sel.= "<option value=''></option>";
				$sel.= "<option value='".implode('@', $res)."'>".$type_flag."</option>";
				$sel.="</select>";
				echo("1".$sel);
			}else
			{	$row=sql_q($sql);
				$sel = "<select name='manyrc' id='manyrc'
							onchange=\"document.getElementById('what_att').value='';
										document.getElementById('save_rq_button').disabled=true;
										document.getElementById('save_rq_button2').disabled=false;
										getwoman(this.value,'status_section');
										\"
							>";
				$sel.= "<option value=''></option>";
				while ($res = mysql_fetch_assoc($row))
				{	if ($res['type_flag']==5)
					{	$type_flag='Заявление: '.$res['number'];
					}if ($res['type_flag']==50)
					{	$type_flag='Договор: '.$res['number'];
					}if ($res['type_flag']==55)
					{	$type_flag='Документ: '.$res['number'];
					}
					$sel .= "<option value='".implode('@', $res)."'>".$type_flag."</option>";
				}$sel.="</select>";
				echo("2".$sel);
			}
		}
		$sql2 = "SELECT id, asoc_numb, asoc_name, request
					FROM asoc
					WHERE building_id = '".$_GET['build_id']."'";
		if ($ima6ti==0)
		{	$sql2.=" and request=''";
		}else
		{	$sql2.=" and (request='' or request='".$ima6ti."')";
		}$sql2.=" order by id asc";
		$num_rows2 = mysql_num_rows(sql_q($sql2));
		if ($num_rows2==0)
		{	$sel2 = "Няма въведено нито едно сдружение! Не възможно!";
		}else
		{	$sel2="Сдружения към избраната сграда:<br />";
			$broq4=1;
			$row2=sql_q($sql2);
			while ($res2 = mysql_fetch_assoc($row2))
			{	if ($res2['request']!='')
				{	$checked='checked';
				}else
				{	$checked='';
				}
				$sel2.="<input type='checkbox' name='ch".$broq4."' id='ch".$broq4."' value='".$res2['id']."' ".$checked."/>";
				$sel2.="<span id='span_".$broq4."'>"."№:".$res2['asoc_numb']." име:".$res2['asoc_name']."</span>";
				$sel2.="<br />";
				$broq4++;
			}
		}
		echo("$".$sel2);
	}
	if($_GET['what'] == 'attaching')
	{	$year=date("Y");
		$day=date("Y-m-d");
      $user_id=$_SESSION['user_id'];
		if (!is_dir($path.$year)) mkdir($path.$year);
		if (!is_dir($path.$year."/".$day)) mkdir($path.$year."/".$day);
		$dir=$path.$year."/".$day."/".$_GET['asoc_id'];
		$short_dir=$year."/".$day."/".$_GET['asoc_id']."/";
		if (!is_dir($dir))mkdir($dir);
		$dir.="/";
		$filename=$_FILES["file"]["name"];
		$filesize = $_FILES["file"]["size"];
		$err_num = $_FILES["file"]["error"];
		switch($err_num)
		{	case 1:
				$error = "Файла е по-голям от 128 Mb";
					break;
			case 2:
				$error = "Файла е по-голям от зададения размер";
					break;
			case 3:
				$error = "Файла се прикачи частично";
					break;
			case 4:
				$error = "Моля, изберете и маркирайте файл!";
					break;
			case 6:
				$error = "Липсва временната директория";
					break;
			case 7:
				$error = "Файла не можа да се запише на диска";
					break;
			case 8:
				$error = "PHP разширение спря прикачването на файла";
					break;
			default:
				$error = "Свържете се с Брайт Комплекс АТ";
		}
		if ($_FILES["file"]["error"] > 0)
		{	echo ('Грешка: '.$error);
		}else
			if (file_exists($dir.$filename))
			{	echo ('Грешка: Файл с име "'.$filename.'" вече съществува!');
			}else
			{	move_uploaded_file($_FILES["file"]["tmp_name"],$dir.$filename);
				sql_q("INSERT INTO attached_files (asoc_id,uploader_id,filesize,attach_filename,attach_dir)
   					VALUES ('".$_GET['asoc_id']."','$user_id','$filesize','$filename','$short_dir')");
				$num_rows=mysql_num_rows(sql_q("SELECT * FROM attached_files WHERE asoc_id='".$_GET['asoc_id']."' AND dell_flag=0 "));
				echo("Успешен запис!".$num_rows);
	  		}
  	}
	if($_GET['what'] == 'rq_save')
	{	if ($_GET['save_up']=='up')
		{	sql_q("UPDATE documents
						SET number='".$_GET['rq_numb']."', theirs_date='".format_date($_GET['theirs_date'])."',
							asoc_id='".$_GET['asoc_id']."', build_id='".$_GET['build_id']."',
							status='".$_GET['doc_status']."', description='".$_GET['description']."',
							date=now(),user_id='".$_SESSION['user_id']."',
							theirs2_date='".format_date($_GET['theirs2_date'])."',doc_type='".$_GET['doc_type']."'
							where id='".$_GET['doc_hid_id']."';
					");
			if ($_GET['str']!='')
			{	sql_q("update asoc set request='".$_GET['doc_hid_id']."' where id in (".$_GET['str'].")");
			}if ($_GET['str2']!='')
			{	sql_q("update asoc set request='' where id in (".$_GET['str2'].")");
			}
			echo("Успешен запис!");
		}else
		{	if ($_GET['theirs2_date']!='')
			{	$theirs2_datef=',theirs2_date';
				$theirs2_date=",'".format_date($_GET['theirs2_date'])."'";
			}else
			{	$theirs2_datef='';
				$theirs2_date='';
			}
			if ($_GET['what_att']==50)
			{	$sql1 = "SELECT * 
					FROM documents 
					WHERE asoc_id = '".$_GET['asoc_id']."' and type_flag='5'";
				$num_rows1 = mysql_num_rows(sql_q($sql1));
				if ($num_rows1!=0)
				{	$sql = "SELECT * 
						FROM documents 
						WHERE asoc_id = '".$_GET['asoc_id']."' and number='".$_GET['rq_numb']."' and type_flag='50'";
					$num_rows = mysql_num_rows(sql_q($sql));
					if ($num_rows!=0)
					{	echo('Вече има въведен договор с този номер за това сдружение!');
					}else
					{	sql_q("INSERT INTO documents (number,theirs_date,asoc_id,build_id,status,description,type_flag,date,user_id".$theirs2_datef.",doc_type)
							VALUES ('".$_GET['rq_numb']."','".format_date($_GET['theirs_date'])."','".$_GET['asoc_id']."','".$_GET['build_id']."','".$_GET['doc_status']."','".$_GET['description']."','".$_GET['what_att']."',now(),'".$_SESSION['user_id']."'".$theirs2_date.",'".$_GET['doc_type']."')");
						echo("Успешен запис!");
					}
				}else
				{	echo('Не може да се въвежда договор, преди да е въведено заявление!');
				}
			}else
			{	sql_q("INSERT INTO documents (number,theirs_date,asoc_id,build_id,status,description,type_flag,date,user_id".$theirs2_datef.",doc_type)
					VALUES ('".$_GET['rq_numb']."','".format_date($_GET['theirs_date'])."','".$_GET['asoc_id']."','".$_GET['build_id']."','".$_GET['doc_status']."','".$_GET['description']."','".$_GET['what_att']."',now(),'".$_SESSION['user_id']."'".$theirs2_date.",'".$_GET['doc_type']."')");
				$res10=mysql_fetch_assoc(sql_q("select id from documents where asoc_id='".$_GET['asoc_id']."' and build_id='".$_GET['build_id']."'"));
				if ($_GET['what_att']==5)
				{	if ($_GET['str']!='')
					{	sql_q("update asoc set request='".$res10['id']."' where id in (".$_GET['str'].")");
					}
				}
				echo("Успешен запис!");
			}
		}
	}if($_GET['what'] == 'getnomen')
	{	if (($_GET['nom_code']=='5')&&($_GET['selected_status']==''))
		{	$sqlself = "SELECT request FROM asoc
					WHERE id = '".$_GET['asoc_id']."'";
			$resself=mysql_fetch_assoc(sql_q($sqlself));
			$zsql = "SELECT * 
					FROM documents 
					WHERE (type_flag='5' and asoc_id = '".$_GET['asoc_id']."')";
			if ($resself['request']!='')
			{	$zsql.=" or id='".$resself['request']."'";
			}
			$num_rows = mysql_num_rows(sql_q($zsql));
			if ($num_rows!=0)
			{	echo('Вече има въведено заявление за това сдружение!');
			}else
			{	$sql = "SELECT * 
						FROM elements 
						WHERE nom_code = '".$_GET['nom_code']."'";
				$res = sql_q($sql);
				$sel = "<select name='doc_status' id='doc_status'>";
				$sel.= "<option value=''></option>";
				while($row = mysql_fetch_assoc($res))
				{	if ($_GET['selected_status']==$row['cod_cod'])
					{ $selected='selected';
					}else
					{	$selected='';
					}
					$sel.= "<option value='".$row['cod_cod']."' $selected>".$row['cod_name']."</option>";
				}
				$sel.= "</select>";
				echo $sel;
			}
		}else
		{	if ($_GET['nom_code']=='50')
			{	$status_efect="doc_status_efect();";
			}else
				if ($_GET['nom_code']=='05')
				{	$status_efect="rq_status_efect();";
				}
			$sql = "SELECT * 
					FROM elements 
					WHERE nom_code = '".$_GET['nom_code']."'";
			$res = sql_q($sql);
			$sel = "<select name='doc_status' id='doc_status'
						onchange='$status_efect'
					>";
			$sel.= "<option value=''></option>";
			while($row = mysql_fetch_assoc($res))
			{	if ($_GET['selected_status']==$row['cod_cod'])
				{ $selected='selected';
				}else
				{	$selected='';
				}
				$sel.= "<option value='".$row['cod_cod']."' $selected>".$row['cod_name']."</option>";
			}
			$sel.= "</select>";
			if(($_GET['nom_code']=='50')&&($_GET['selected_doc_type']!=''))
			{	$sql = "SELECT * 
						FROM elements 
						WHERE nom_code = '54'";
				$res = sql_q($sql);
				$sel2 = "@<select name='doc_type' id='doc_type'>";
				$sel2.= "<option value=''></option>";
				while($row = mysql_fetch_assoc($res))
				{	if ($_GET['selected_doc_type']==$row['cod_cod'])
					{ $selected='selected';
					}else
					{	$selected='';
					}
					$sel2.= "<option value='".$row['cod_cod']."' $selected>".$row['cod_name']."</option>";
				}
				$sel2.= "</select>";
			}else
			{$sel2='';
			}
			echo $sel.$sel2;
		}
	}if($_GET['what'] == 'delete_build')
	{	delete_build($_GET['build_id']);
	}if($_GET['what'] == 'delete_asoc')
	{	delete_asoc($_GET['asoc_id']);
	}if($_GET['what'] == 'delete_person')
	{	delete_person($_GET['person_id']);
	}
}
/* **************************************************************************************************************** */
	if($_GET['file'] == 'regCard'){
		$sql1 = "SELECT `name`, address, phone, type 
				 FROM people 
				 WHERE asoc_id = '" . $_GET['a_id'] . "' and invalid='0'";
		$res1 = mysql_query($sql1) or die(mysql_error());
			$table = "<table id='the_table'>";
			while($row1 = mysql_fetch_assoc($res1)){
				if($row1['type'] == 1){
					$table .= "<tr><td align='center'>Управител:</td></tr>";
					$table .= "<tr><td>" . $row1['name'] . ", " . $row1['address'] . ", " . $row1['phone'] . "</td></tr>";
				}
				if($row1['type'] == 2){
					$table .= "<tr><td align='center'>Контрольор:</td></tr>";
					$table .= "<tr><td>" . $row1['name'] . ", " . $row1['address'] . ", " . $row1['phone'] . "</td></tr>";
				}
				if($row1['type'] == 3){
					$table .= "<tr><td align='center'>Членове на управителния съвет:</td></tr>";
					$table .= "<tr><td>" . $row1['name'] . ", " . $row1['address'] . ", " . $row1['phone'] . "</td></tr>";
				}
				if($row1['type'] == 4){
					$table .= "<tr><td align='center'>Членове на контролния съвет:</td></tr>";
					$table .= "<tr><td>" . $row1['name'] . ", " . $row1['address'] . ", " . $row1['phone'] . "</td></tr>";
				}				
			}
			$table .= "</table>";
				echo $table;
	}
function delete_build($hich)
{	sql_q("update buildings set invalid='1' where id='$hich';");
	sql_q("update asoc set invalid='1' where building_id='$hich';");
	sql_q("update people set invalid='1' where asoc_id in (select id from asoc where building_id='$hich');");
	////sql_q("update documents set invalid='1' where build_id='$hich';");
}function delete_asoc($hich)
{	sql_q("update asoc set invalid='1' where id='$hich';");
	sql_q("update people set invalid='1' where asoc_id='$hich';");
	////sql_q("update documents set invalid='1' where asoc_id='$hich';");
}function delete_person($hich)
{	sql_q("update people set invalid='1' where id='$hich';");
}
//function delete_rq($hich)
//{	sql_q("update documents set invalid='1' where id='$hich';");
//}
?>