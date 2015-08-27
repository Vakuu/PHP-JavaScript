<?
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
function NameOfMonth($month)
{
    switch ($month){
    case 1: return 'Януари';break;     case '1': return 'Януари';break;     case '01':return 'Януари';break; 
    case 2: return 'Февруари';break;   case '2': return 'Февруари';break;   case '02':return 'Февруари';break;
    case 3: return 'Март';break;       case '3': return 'Март';break;       case '03':return 'Март';break;
    case 4: return 'Април';break;      case '4': return 'Април';break;      case '04':return 'Април';break;
    case 5: return 'Май';break;        case '5': return 'Май';break;        case '05':return 'Май';break;
    case 6: return 'Юни';break;        case '6': return 'Юни';break;        case '06':return 'Юни';break;
    case 7: return 'Юли';break;        case '7': return 'Юли';break;        case '07':return 'Юли';break;
    case 8: return 'Август';break;     case '8': return 'Август';break;     case '08':return 'Август';break;
    case 9: return 'Септември';break;  case '9': return 'Септември';break;  case '09':return 'Септември';break;
    case 10:return 'Октомври';break;   case '10':return 'Октомври';break;
    case 11:return 'Ноември';break;    case '11':return 'Ноември';break;
    case 12:return 'Декември';break;   case '12':return 'Декември';break;
    }    
} 
function string_of_option($array){
    $string="";
    $nbsp="";
	while (list($key, $val) = each($array)){	
      $lenght_of_string=strlen($val);
      if ($lenght_of_string > $key){
	    $dif=$lenght_of_string-$key;
	    $string.=substr($val,0,-$dif)."&nbsp;&nbsp;&nbsp;";
      }
      else {
	    $dif=$key-$lenght_of_string;
	    for ($i=1;$i<=$dif;$i++)$nbsp.="&nbsp;";
	    $string.=$val.$nbsp."&nbsp;&nbsp;&nbsp;";
	    $nbsp="";
      }
    }
    $string = str_replace(" ", "&nbsp;", $string);
    return $string;	
}
function LastDayOfMonth($month, $year) { 
  $daysInMonth = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31); 
  if ($month != 2) { return $daysInMonth[$month - 1]; } 
  else { return (checkdate($month, 29, $year)) ? 29 : 28; } 
}
########################################################
################## DEBUGING FUNCTION ###################
function d($w){
  $debug_backtrace="";
  $time=date("Y-m-d H:i:s");
  $year=date("Y");
  $month=date("M");
  $dfile="backtrace_$month.log";
  if (!is_dir("$_SESSION[home_dir]/log/$year"))mkdir("$_SESSION[home_dir]/log/$year");
  if (!is_dir("$_SESSION[home_dir]/log/$year/$month"))mkdir("$_SESSION[home_dir]/log/$year/$month");
  if(function_exists(debug_backtrace)){
    $trace=debug_backtrace();
    if(isset($trace[1]['function'])){
      $function=$trace[1]['function'];
      $arg="'";
      $arg.=implode("','",$trace[1]['args']);
      $arg.="'";
      $ffile=basename($ffile);
      $fline=$trace[1]['line'];
      $fpath=$trace[1]['file'];
    }
    $debug_backtrace="[$fpath]\r\n[$fline:$function($arg)]";
  }
  if(SHOW_DEBUG==true){
  	if (!$_SESSION['home_dir']){
  		//if (getcwd()=='asoc')
  		$prom=explode("\\",getcwd());
  		if ($prom[count($prom)-1]=='asoc')
		{	$link='../';
		}else
		{	$link='./';
		}
	  	die("<font color=red><b>Изтекла сесия! Излезте от система 'РЕГЕС', след което влезте повторно в нея</b></font> <a href='".$link."' title='Вие като не можете да си напишете линка... Ние ще ви го напишем :)'>Тук</а>");//<label for='Вие като не можете да си напишете линка... Ние ще ви го напишем :)'></label>
	}  	
    else
	if ($w!='DEBUG_ERR:005')
	{
	echo "\n\n\n<b>[$time] $debug_backtrace:</b><BR>\n
	          <font color=blue><PRE>ГРЕШКА: [$w]</PRE></font><br>
			  <font color=red><b>Уведомете фирмата поддържаща система 'РЕГЕС' за възникналата ситуация!</b></font>\n\n ";
	}
  }
  if($file=fopen("$_SESSION[home_dir]/log/$year/$month/$dfile",'a')){
    fputs($file,"[".$time."]".$debug_backtrace.": \r\n$w\r\n\r\n");
    fclose($file);
  }
  else die('DEBUGING ERR: 011 '.__FILE__);
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function sql_log($sql,$file){
  if(LOG_SQL==true){
    #ако е пуснат дебъга се логват query-тата
    $year=date("Y");
    $month=date("M");
    $file_name=date("Y-m-d").".log";
    if (!is_dir("$_SESSION[home_dir]/log/$year"))mkdir("$_SESSION[home_dir]/log/$year");
    if (!is_dir("$_SESSION[home_dir]/log/$year/$month"))mkdir("$_SESSION[home_dir]/log/$year/$month");    
    if($f=fopen("$_SESSION[home_dir]/log/$year/$month/$file_name",'a')){
      $time=date("Y-m-d H:i:s");
      fputs($f,"/*[$time-->$file-->$_SESSION[username]]*/\r\n$sql;\r\n");
      fclose($f);
    }
   else d('DEBUG_ERR:005');
  }
  
  
}
#########################################################
/* Логване на системна _не_критична_ информация
 * например кой кога се е логнал 
 */ 
function logit($log_string){
  $file="system.log";
  if($f=fopen($file,'a')){
    $time=date("d.M.Y H:i:s");
    $log="[".$time."] IP:'".REMOTE_IP."' USER='".$_SESSION['username']."' ACTION:'".$log_string."'\n";
    fputs($f,"$log");
    fclose($f);
  }
    else d('ERR:012');
}
#########################################################
##### Проверка на правата и валидноста на потребител ####
function ConfirmUser($username, $password){
  /* Return Status:
   * 0 - Потребителя е потвърден
   * 1 - грешно потребителско име
   * 2 - неактивен акаунт
   * 3 - грешна парола
   */ 
  global $connect;
  
  if (!get_magic_quotes_gpc()) {
    $username = addslashes($username);
  }
  
  $query = "SELECT id, password, status FROM users WHERE username = '$username'";
  $result = sql_q($query, $connect);
  if (!$result || (mysql_numrows($result) < 1)) { return 1; }
  
  $row = mysql_fetch_array($result);
  if ($row['status'] == 0) { return 2; }
  /*
   * ? Md5 ?
   * $row['password']  = stripslashes($row['password']);     
   * $password = stripslashes($password);
   */
  if ($password == $row['password']){ return 0; } else { return 3; }
}
#########################################################
####### Проверка на потребителя в сесията ########
function CheckLogin(){
  /* Return Status:
   * true - Потребителя е потвърден
   * false - Потребителя НЕ Е потвърден
   */ 
  if (isset($_SESSION['username']) && isset($_SESSION['password'])){
    if (ConfirmUser($_SESSION['username'], $_SESSION['password']) != 0){
      unset($_SESSION['username']);
      unset($_SESSION['password']);
      
      return false;
    }
    return true;
  } else{
    return false;
  }
}
#########################################################
##########  Създаване на JavaScript Alert() #############
function js_alert($alert){
  return "<script language='JavaScript'>alert('".htmlspecialchars($alert)."');</script>\n";  
}
#########################################################
######### MySql заявка към сървъра  ########################
function sql_q($q){
  if ($_SESSION['home_dir']){	
    global $connect;
    $trace=debug_backtrace();
    $file=$trace[0]['file'];
    $home_dir_length=strlen($_SESSION['home_dir']);
    $file=substr($file,$home_dir_length+1);
    $query = iconv("WINDOWS-1251", CONVERT_TO_CHARSET, $q);
    $res=@mysql_query($query,$connect);
    if(mysql_error())die(d(mysql_error()));
    else if(strtoupper(substr(trim($q), 0, 6)) != "SELECT")sql_log($q,$file);  
    return $res;
  }
  else  d('ИЗТЕКЛА СЕСИЯ!');
}
#########################################################
function convert_to_charset($string)
{
	$result = iconv(CONVERT_TO_CHARSET, "WINDOWS-1251", $string);
	return $result;
}
#########################################################
function sql_like($string){
  $string=trim($string);
  $string=sql_e($string);
  $string="%$string%";
  $string=preg_replace("/ +/","%",$string);
  return sql_e($string);
}

#########################################################
function sql_e($string){
  # Да махнем излишното а?:)
  $string=trim($string);
  if (get_magic_quotes_gpc()) {
    $string = stripslashes($string);
  }
  // Quote if not integer
  if (!is_numeric($string)) {
    $string = mysql_real_escape_string($string);
  }
  return $string;
}
#########################################################
function sql_n($sql_result){
  # Връща броя на записите от sql заявка
  global $connect;
  return mysql_num_rows($sql_result);
}
#########################################################
function sql_row($sql){
  /*
   * прави заявка към mysql и връща първия ред
   * функцията е полезна само когато се очаква 
   * да има само един ред като резултат
   */
  $result=sql_q($sql);
  $row=mysql_fetch_array($result);
  return $row;
}
#########################################################
function show($var){
  # За дъмпване на информация.
  if(SHOW_DEBUG==true){
    echo "<pre>";
    if(is_array($var)) 
    print_r($var);
    else 
    var_dump($var);
    echo "</pre>";
  }
}
###########################################################################
function red_star($star_id=""){
  # Извежда червена звездичка (за задължителните полета)
  if($star_id!="") echo "<a href='help.php?".$star_id."'>";
  echo "<img src='templates/images/red_star.png'>";
  if($star_id!="") echo "</a>";
  
}
###########################################################################
function print_nomen($code_number,$select_name,$value,$default){
  /*
   * Извеждане на номенклатурите
   * Функцията приема следните аргументи
   * по реда на приемане:
   * print_nomer(номер_на_номенклатура, име_на_select_менюто, стара_стойност, 
   * стойност_на_първото_поле_от_менюто)
   */
  
  echo "\n<select name=\"".$select_name."\" class=input>\n";
  if(!empty($default)){
    echo "\t<option value=\"\">".$default."</option>\n";
  }
  $sql = "SELECT cod_cod, cod_name FROM elements
     WHERE nom_code='".$code_number."' GROUP BY cod_cod ORDER BY cod_name";
  $result = sql_q($sql);
  while ($row = mysql_fetch_array($result)) {
    if ( $value == $row[cod_cod]) $selected = " selected";
    else $selected = "";
    echo "\t<option value='".$row[cod_cod]."'".$selected.">".
    $row[cod_name]."</option>\n";
  }
  mysql_free_result($result);
  echo "</select>\n";
}

function acts_new_num($act_type){
  /* i sega malko shit zaradi wersiqta na sql i lipsata na wlojeni zaqwki */
  sql_q('begin'); // ehh.. te tiq tranzakcii ako raboteha ... :)
  sql_q("DROP TABLE IF EXISTS temp_union");
  $sql="CREATE TEMPORARY TABLE temp_union TYPE=HEAP select act_number from actove where act_type='".$act_type."'";
  switch($act_type)  
  {
  case 1: 
  $sql_act = " OR act_type='3'";
  break;
  case 2: 
  $sql_act = " OR act_type='4' ";
  break;
  case 3: 
  $sql_act = " OR act_type='1' ";
  break;
  case 4: 
  $sql_act = " OR act_type='2'";
  break;
  case 5: 
  $sql_act = " OR act_type='6' ";
  break;
  case 6: 
  $sql_act = " OR act_type='5'";
  break;
  }
  $sql .=$sql_act;
  $sql.=" group by act_number;";
  sql_q($sql);
  $sql1 = "INSERT INTO temp_union select number from actove_reserved where act_type='".$act_type."'";
  $sql1 .=$sql_act;
  $sql1 .= " group by number;";
  sql_q($sql1);
  $result=sql_q("SELECT DISTINCT * from temp_union order by act_number");
  sql_q("DROP TABLE temp_union");
  sql_q("commit");
  $number=1;
  while($number<=mysql_num_rows($result)+1 ){
    $row=mysql_fetch_row($result);
    //echo "z".$row[0]."z<br>";
    if($number!=$row[0]){
      $act_number=$number;
      sql_q("INSERT INTO actove_reserved VALUES ($act_number, now(),$act_type)");
      break;
    }
    $number++;
  } 
  return $act_number;
}
function format_date($date)
{
  if(!empty($date))
  {
      $date_array = explode("-", $date);
      $result = $date_array[2]."-".$date_array[1]."-".$date_array[0];
  }
  else
  {
      $result = "";
  }
  return $result;
}
/* 
function date_format($date)
{
  return format_date($date);
}
*/
function CheckSessionState($relative_path)
{
  if(empty($_SESSION['username']) || empty($_SESSION['password']))
  {
      echo "alabala";
      $script = "<script language = 'javascript'>";
      $script .= "url = location.href;\n";
      $script .= "last_index = url.lastIndexOf('/');\n";
      $script .= "url_redirect = url.substring(0, last_index+1) + '".$relative_path."'+ 'Logout.php'\n";
      $script .= "location.href = url_redirect\n";
      $script .= "</script>";
      echo "".$script;
  }
}

/* CHANGELOG
 * 2005.11.03 - Само при включен DEBUG_SHOW=true функцията show() принтва подаденото й /Martin Lazarov/
 * 2006.07.27 - Добавена е функция CheckSessionState(), която проверява дали случайно сесията на потребителя важи
 Mоже и да няма създадена.
 Тази функция трябва да се ползва във всеки един скрипт файл, в началото,
 веднага след включването директивата "include(../inc/conf.php)". /Росен Захариев/
 *
 *
 */
 
 function ip_info($username){
		
	
    $ip=REMOTE_IP; 
    $query_id = "SELECT id FROM users WHERE username = '" . $_SESSION['username'] . "'";
    $result_id = mysql_query($query_id);
	$row_id = mysql_fetch_array($result_id);
	$id=$row_id['id'];
	
	$query = "SELECT user_id FROM ip_info WHERE user_id='" .$id . "'";
    $result = mysql_query($query);
	$row = mysql_fetch_array($result);
		if (mysql_num_rows($result) > 0)
			{
				$update = "UPDATE ip_info SET ip='" .$ip . "', timestamp= now() WHERE user_id='" .$id . "'";
    			$result = mysql_query($update);

			}
		else 
			{
				$insert = "INSERT INTO ip_info (user_id,ip) VALUES ('$id','$ip') ";
				$results = mysql_query($insert);
			}
	}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//Иван Иванов 10-08-2007
//При зададени падежна дата, работна дата и месечно задължение, функцията изчислява дължимата лихва.
//Лихвата се изчислява от падежната дата до деня, предхождащ работната дата. 
//Параметъра $array_interest_rate представлява асоциативен масив с лихвените проценти на БНБ. 
//Параметъра $points е стойността на увеличаването на лихвените проценти.
//Ако параметъра $flag<>1 дължимата лихва се визуализира в табличен вид, посредством историята на нейното образуване. 
////////////////////////////////////////////////////////////////////////////////////////////////////////////////  
function GetInterest($date_begin,$date_end, $month_balance ,$array_interest_rate, $points,$flag)
{
  if ($flag==1){	
  $date1 = split('-',$date_begin);
  $date2 = split('-',$date_end);
  if (!checkdate($date1[1],$date1[0],$date1[2])){return 'Невалидна начална дата!';break;}
  if (!checkdate($date2[1],$date2[0],$date2[2])){return 'Невалидна крайна дата !';break;}
  $YearsDifference = $date2[2] - $date1[2];
  if ($YearsDifference == 0) 
  { 
    if (($date2[1]-$date1[1]) >= 0) {$NumberOfMonths = $date2[1]- $date1[1] + 1;}
    else {return 0.00;break;}
    if ((($date2[0]-$date1[0]) < 0)and(($date2[1]-$date1[1]) == 0)){return 0.00;break;}
  }
  else if ($YearsDifference > 0){$NumberOfMonths = $YearsDifference*12 + $date2[1]- $date1[1] + 1;}
  else {return 0.00;break;}
  $intervals[1] = $date_begin;
  $intervals[2] = LastDayOfMonth($date1[1], $date1[2]).'-'.$date1[1].'-'.$date1[2];
  for ($i=3; $i<=$NumberOfMonths; $i++)
  {
    $bufer=split('-',$intervals[$i-1]);
    $bufer1= split('-',date('d-m-Y',strtotime('05-'.$bufer[1].'-'.$bufer[2].'+1 month')));
    $intervals[$i]= date('d-m-Y',strtotime(LastDayOfMonth($bufer1[1], $bufer1[2]).'-'.$bufer1[1].'-'.$bufer1[2]));
  }
  $intervals[$NumberOfMonths+1]=$date_end;
  $count_intervals=count($intervals);
  for ($i=2;$i<=$count_intervals;$i++){$split=split('-',$intervals[$i]); $yearmonth[$i-1]= $split[2].$split[1];}
  reset($array_interest_rate);
  while (list($key, $val) = each($array_interest_rate)){$key_array_interest_rate[$i]=$key;$i++;}
  for ($i=1;$i<=($count_intervals-1);$i++){if (!in_array($yearmonth[$i],$key_array_interest_rate))
                                           {$text = $text.'Въведете Основния лихвен процент за '.$yearmonth[$i].'<br>';}}
  if (!empty($text)){return $text;break;}
  $bufer1 = split('-',$intervals[1]);
  $bufer2 = split('-',$intervals[2]);
  if ($count_intervals>2){
    $bufer3 = split('-',$intervals[$count_intervals]);  
    $as_intervals = array( $bufer1[2].$bufer1[1] => $bufer2[0]-$bufer1[0]+1);
    for ($i=2;$i<=$count_intervals-1;$i++){$bufer = split('-',$intervals[$i+1]);$as_intervals[$bufer[2].$bufer[1]]= $bufer[0];}
    $as_intervals[$bufer3[2].$bufer3[1]] = $bufer3[0]-1;
  } 
  else{$as_intervals = array( $bufer1[2].$bufer1[1] => $bufer2[0]-$bufer1[0]);}
  reset($as_intervals);
  reset($array_interest_rate);
  while (list($key, $val) = each($as_intervals)){
     while (list($key1, $val1) = each($array_interest_rate))
        {if ($key==$key1){$as_intervals[$key]='('.$val1.'+'.$points.')/36000*'.$month_balance.'*'.$val.' = '
	                                       .round(($val1+$points)/36000*$val*$month_balance,4);}}
  reset($array_interest_rate);}
  reset($as_intervals);
  while (list($key, $val) = each($as_intervals)){$split=split(' = ',$as_intervals[$key]);$as_intervals[$key]=$split[1];}
  return array_sum($as_intervals);
  }
  else{// Флаг != 1 представя функцията с HTML-таблица
  $date1 = split('-',$date_begin);
  $date2 = split('-',$date_end);
  if (!checkdate($date1[1],$date1[0],$date1[2])){echo 'Невалидна падежна дата!';return 'Невалидна падежна дата!';}
  if (!checkdate($date2[1],$date2[0],$date2[2])){echo 'Невалидна работна дата!';return 'Невалидна работна дата !';}
  $YearsDifference = $date2[2] - $date1[2];
  if ($YearsDifference == 0) 
  { 
    if (($date2[1]-$date1[1]) >= 0) {$NumberOfMonths = $date2[1]- $date1[1] + 1;}
    else 
	{
	  echo '<br><b><font color="blue">Падежната дата все още не е достигната => Дължимата лихвата  е :
	        <font color="red">0.0000</font> лв. !</font></b><br>';
	  return 0.00;
	}
    if ((($date2[0]-$date1[0]) < 0)and(($date2[1]-$date1[1]) == 0))
	{
	  echo '<br><b><font color="blue">Падежната дата все още не е достигната => Дължимата лихвата  е :
	        <font color="red">0.0000</font> лв. !</font></b><br>';
	  return 0.00;
	}
  }
  else if ($YearsDifference > 0){$NumberOfMonths = $YearsDifference*12 + $date2[1]- $date1[1] + 1;}
  else 
  {
	echo '<br><b><font color="blue">Падежната дата все още не е достигната => Дължимата лихвата  е :
	      <font color="red">0.0000</font> лв. !</font></b><br>';
	return 0.00;
  }
  $intervals[1] = $date_begin;
  $intervals[2] = LastDayOfMonth($date1[1], $date1[2]).'-'.$date1[1].'-'.$date1[2];
  for ($i=3; $i<=$NumberOfMonths; $i++)
  {
    $bufer=split('-',$intervals[$i-1]);
    $bufer1= split('-',date('d-m-Y',strtotime('05-'.$bufer[1].'-'.$bufer[2].'+1 month')));
    $intervals[$i]= date('d-m-Y',strtotime(LastDayOfMonth($bufer1[1], $bufer1[2]).'-'.$bufer1[1].'-'.$bufer1[2]));
  }
  $intervals[$NumberOfMonths+1]=$date_end;
  $count_intervals=count($intervals);
  for ($i=2;$i<=$count_intervals;$i++){$split=split('-',$intervals[$i]); $yearmonth[$i-1]= $split[2].$split[1];}
  reset($array_interest_rate);
  while (list($key, $val) = each($array_interest_rate)){$key_array_interest_rate[$i]=$key;$i++;}
  for ($i=1;$i<=($count_intervals-1);$i++)
  {
    if (!in_array($yearmonth[$i],$key_array_interest_rate))
    {
	  $text = $text.'<b><font color="red">Липсва Основния лихвен процент на БНБ за месец 
	                <font color="blue">'.NameOfMonth(substr($yearmonth[$i],4)).' '.substr($yearmonth[$i],0,4).'
					</font> година !</font></b><br>';
	}
  }
  if (!empty($text)){echo $text;return $text;}
  $bufer1 = split('-',$intervals[1]);
  $bufer2 = split('-',$intervals[2]);
  if ($count_intervals>2){
    $bufer3 = split('-',$intervals[$count_intervals]);  
    $as_intervals = array( $bufer1[2].$bufer1[1] => $bufer2[0]-$bufer1[0]+1);
    for ($i=2;$i<=$count_intervals-1;$i++){$bufer = split('-',$intervals[$i+1]);$as_intervals[$bufer[2].$bufer[1]]= $bufer[0];}
    $as_intervals[$bufer3[2].$bufer3[1]] = $bufer3[0]-1;
  } 
  else{$as_intervals = array( $bufer1[2].$bufer1[1] => $bufer2[0]-$bufer1[0]);}
  ?><table border="1" cellpadding="0" cellspacing="0" bgcolor="#eeeeee" align = 'center' bordercolor="DarkSeaGreen">
      <tr>
        <th width="120" bgcolor="DarkSeaGreen"><font color="white">Година</font></th>
        <th width="120" bgcolor="DarkSeaGreen"><font color="white">Месец</font></th>
        <th width="120" bgcolor="DarkSeaGreen"><font color="white">БройДни</font></th>
        <th width="120" bgcolor="DarkSeaGreen"><font color="white">Лихвен %+<?echo $points?></font></th>
        <th width="120" bgcolor="DarkSeaGreen"><font color="white">Гланица</font></th>
        <th width="120" bgcolor="DarkSeaGreen"><font color="white">ЛихваЗаМесеца</font></font></th>
	  </tr>
  <?
  reset($as_intervals);
  reset($array_interest_rate);
  while (list($key, $val) = each($as_intervals)){
     while (list($key1, $val1) = each($array_interest_rate))
        {if ($key==$key1){$as_intervals[$key]='('.$val1.'+'.$points.')/36000*'.$month_balance.'*'.$val.' = '
	                                       .round(($val1+$points)/36000*$val*$month_balance,4);}}
  reset($array_interest_rate);
  }
  reset($as_intervals);
  while (list($key, $val) = each($as_intervals)) 
  {?>
  	<tr>
	  <td align="center"><font color="blue"><?echo substr($key,0,4)?></font></td>
	  <td align="center"><font color="blue"><?echo NameOfMonth(substr($key,4))?></font></td>
	  <td align="center"><?$s=split("[*=]",$val); echo $s[2]?></td>
	  <td align="center"><?$s=split("[+]",$val);echo Add_Fraction_Part((substr($s[0],1)+$points))?></td>
	  <td align="center"><?echo Add_Fraction_Part($month_balance)?></td>
	  <td align="center"><font color="red"><?$s=split("[=]",$val); echo Add_Fraction_Part_4($s[1]);?></font></td>
	</tr>
  <?}//echo substr($key,4).'_'.substr($key,0,4).' => (ОснЛихвПроц+Пункт)/(100*БройДниГод)*МесечнаГлавница*БройДниМес  =>  '.$val.'<br>';
  reset($as_intervals);
  while (list($key, $val) = each($as_intervals)){$split=split(' = ',$as_intervals[$key]);$as_intervals[$key]=$split[1];}
  $interest_debt = Add_Fraction_Part_4(array_sum($as_intervals));
  ?>
    <tr>
    <td colspan="5" align="right" bgcolor="DarkSeaGreen"><font color="white"><b>Лихвата за периода е :<font color="white"><b></td>
    <td align="center" bgcolor="DarkSeaGreen"><font color="red" size="4"><b><?echo $interest_debt;?><font color="white"><b></td>
	</tr>
  </table>
  <?
  return $interest_debt;	  
  }	  
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//Иван Иванов 10-09-2007
//По зададено салдо от базата данни ($year, $month и $contr_id) и работна дата ($date), функцията изчислява дължимата 
//лихва. Функцията взема под внимание платежните документи, отнасящи се за зададеното салдо, за да 
//изчисли коректно дължимата лихва. За целта се използва един или няколко пъти функцията GetInterest. 
//Ако параметъра  $flag <> 1, се визуализира информация за платежните документи, както и таблиците генерирани от 
//функцията GetInterest за всеки от тях.Функцията връща масив:
//$array[0]- Изчислената дължима лихва
//$array[1]- Падежната дата на салдото
//$array[2]- Дължимата лихва в базата (interest_debt)
//$array[3]- Платената лихва в базата (interest_pay)
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function Interest_calc($year, $month, $contr_id, $date, $flag){
if ($flag==1){	
$query=sql_q("select point_interest_percent from municipality");
$row=mysql_fetch_row($query);
$points=$row[0];
$query=sql_q("select * from bnb");
while ($row=mysql_fetch_row($query)){list($key, $val)= $row;$array_interest_rate[$key]=$val;}
$query=sql_q("select month_debt, interest_debt, interest_pay  from balances where contr_id=".$contr_id." and year=".$year." and month= ".$month);
$row=mysql_fetch_array($query);
$month_balance=$row['month_debt'];
$interest_debt=round($row['interest_debt'],2);
$interest_pay=$row['interest_pay'];
$pad_date=GetPadDate($year, $month, $contr_id);
$query=sql_q("select count(i.invoice_id) from invoices as i, month_payments as m 
	      where i.invoice_id=m.invoice_id and doc_id=".$contr_id." and m.year=".$year." and m.month=".$month.
		  " and i.doc_state in (3,7)");
$row=mysql_fetch_row($query);
$count=$row[0];
if ($count!=0){
  $query=sql_q("select i.invoice_id, i.doc_date, m.amount from invoices as i, month_payments as m 
	           where i.invoice_id=m.invoice_id and doc_id=".$contr_id." and m.year=".$year." and m.month=".$month." order by doc_date");
  $row=mysql_fetch_array($query);
  $doc_date= format_date($row['doc_date']);
  $date_begin=$pad_date;
  if ($row['doc_date']>=format_date($date_begin)){
    $intervals[0]=$date_begin.'#'.$doc_date.'#'.$month_balance.'#'.$month_balance.'#0.00';
    $date_begin= $doc_date;
    if (($month_balance - $row['amount'])<0){$month_balance=0.00;} else {$month_balance=$month_balance - $row['amount'];}
  }
  else{
    $intervals[0]=$doc_date.'#'.$date_begin.'#0.00#'.$month_balance.'#'.$row['amount'];
    if (($month_balance - $row['amount'])<0){$month_balance=0.00;} else {$month_balance=$month_balance - $row['amount'];}
  }
  for ($i=1; $i<=$count; $i++){
    if ($i==$count){  
	  $date_end=$date;
	  $intervals[$i]=$date_begin.'#'.$date_end.'#'.$month_balance;
    }
	else {
	  $row=mysql_fetch_array($query);
	  if ($row['doc_date']>=format_date($date_begin)){
	    $doc_date= format_date($row['doc_date']);
	    $intervals[$i]=$date_begin.'#'.$doc_date.'#'.$month_balance.'#'.$month_balance.'#'.$row['amount'];
	    $intervals_bufer[$i+1]=$intervals[$i];
	    $date_begin = $doc_date;
	    if (($month_balance - $row['amount'])<0){$month_balance=0.00;} else {$month_balance=$month_balance - $row['amount'];}
	  }
	  else{
	    $doc_date= format_date($row['doc_date']);
	    $intervals[$i]=$doc_date.'#'.$date_begin.'#0.00#'.$month_balance.'#'.$row['amount'];
	    if (($month_balance - $row['amount'])<0){$month_balance=0.00;} else {$month_balance=$month_balance - $row['amount'];}
          }		  
	}
  }
  $interest=array();
  for ($i=0;$i<=$count;$i++){
	  $split=split('[#]',$intervals[$i]);
	  $split_bufer=split('[#]',$intervals_bufer[$i]);
	  $difference=$split[3]-$split[4];
	  $diff_bufer=$split_bufer[3]-$split_bufer[4];
	  $interest[$i]=GetInterest($split[0],$split[1],$split[2] ,$array_interest_rate, $points,$flag);
	  if (is_string($interest[$i])){$interest=array();break;}
  }
  if (!(empty($interest))){
    $array[0]= array_sum($interest);
    if ($array[0] <= $interest_pay) {$array[0] = $interest_pay;}
  }
}
else {$array[0]=GetInterest($pad_date,$date,$month_balance ,$array_interest_rate, $points,$flag);}
$array[1]=$pad_date;
$array[2]=$interest_debt;
$array[3]=$interest_pay;
return $array;
}
else{// Флаг != 1 представя функцията с визуализиращи редове
$query=sql_q("select point_interest_percent from municipality");
$row=mysql_fetch_row($query);
$points=$row[0];
$query=sql_q("select * from bnb");
while ($row=mysql_fetch_row($query)){list($key, $val)= $row;$array_interest_rate[$key]=$val;}
$query=sql_q("select month_debt, interest_debt, interest_pay  from balances where contr_id=".$contr_id." and year=".$year." and month= ".$month);
$row=mysql_fetch_array($query);
$month_balance=$row['month_debt'];
$interest_debt=round($row['interest_debt'],2);
$interest_pay=$row['interest_pay'];
$pad_date=GetPadDate($year, $month, $contr_id);
$query=sql_q("select count(i.invoice_id) from invoices as i, month_payments as m 
	      where i.invoice_id=m.invoice_id and doc_id=".$contr_id." and m.year=".$year." and m.month=".$month.
		  " and i.doc_state in (3,7)");
$row=mysql_fetch_row($query);
$count=$row[0];
//echo ' Платени фактури за месец '.NameOfMonth($month).' '.$year.' год. : <b>'.$count.'</b><br>----------------------------------------------------------------<br>';
if ($count!=0){
  $query=sql_q("select i.invoice_id, i.doc_date, m.amount from invoices as i, month_payments as m 
	           where i.invoice_id=m.invoice_id and doc_id=".$contr_id." and m.year=".$year." and m.month=".$month." order by doc_date");
  $row=mysql_fetch_array($query);
  $doc_date= format_date($row['doc_date']);
  $date_begin=$pad_date;
  if ($row['doc_date']>=format_date($date_begin)){
    $intervals[0]=$date_begin.'#'.$doc_date.'#'.$month_balance.'#'.$month_balance.'#'.$row['amount'];
    $intervals_bufer[1]=$intervals[0];
    $date_begin= $doc_date;
    if (($month_balance - $row['amount'])<0){$month_balance=0.00;} else {$month_balance=$month_balance - $row['amount'];}
  }
  else{
    $intervals[0]=$doc_date.'#'.$date_begin.'#0.00#'.$month_balance.'#'.$row['amount'];
    if (($month_balance - $row['amount'])<0){$month_balance=0.00;} else {$month_balance=$month_balance - $row['amount'];}
  }
  for ($i=1; $i<=$count; $i++){
    if ($i==$count){  
	  $date_end=$date;
	  $intervals[$i]=$date_begin.'#'.$date_end.'#'.$month_balance;
    }
	else {
	  $row=mysql_fetch_array($query);
	  if ($row['doc_date']>=format_date($date_begin)){
	    $doc_date= format_date($row['doc_date']);
	    $intervals[$i]=$date_begin.'#'.$doc_date.'#'.$month_balance.'#'.$month_balance.'#'.$row['amount'];
	    $intervals_bufer[$i+1]=$intervals[$i];
	    $date_begin = $doc_date;
	    if (($month_balance - $row['amount'])<0){$month_balance=0.00;} else {$month_balance=$month_balance - $row['amount'];}
	  }
	  else{
	    $doc_date= format_date($row['doc_date']);
	    $intervals[$i]=$doc_date.'#'.$date_begin.'#0.00#'.$month_balance.'#'.$row['amount'];
	    if (($month_balance - $row['amount'])<0){$month_balance=0.00;} else {$month_balance=$month_balance - $row['amount'];}
          }		  
	}
  }
  $interest=array();
  $j=0;
  for ($i=0;$i<=$count;$i++)
  {
    $split=split('[#]',$intervals[$i]);
	$split_bufer=split('[#]',$intervals_bufer[$i]);
	if (($split[3]-$split[4])<0){$difference=0.00;} 
	else {$difference=$split[3]-$split[4];}
	if(($split_bufer[3]-$split_bufer[4])<0){$diff_bufer=0.00;} 
	else {$diff_bufer=$split_bufer[3]-$split_bufer[4];}
    if ((format_date($split[0])==format_date($pad_date)) && ($j==0))
	{
	  echo '<b><font color="DarkSeaGreen" size="4">Падежна дата : </font><font color="red" size="4">'.$split[0].'</font></b> ';
	  $j++;
	}
	else if((format_date($split[0])==format_date($pad_date)) && ($j!=0))
	{
	  echo 'Фактура от дата  &nbsp;: <font color="red" size="4">&nbsp;<b>'.$split[0].'</b></font> Начално салдо : <b>'.Add_Fraction_Part($split_bufer[3]).
	       '</b> лв. Плащане : <b>'.$split_bufer[4].'</b> лв.  Крайно салдо : <b>'.Add_Fraction_Part($diff_bufer).'</b> лв.<br>';
	}
	else if(format_date($split[0])<format_date($pad_date))
	{
	  echo 'Фактура от дата  &nbsp;: <font color="red" size="4" >&nbsp;<b>'.$split[0].'</b></font> Начално салдо : <b>'.Add_Fraction_Part($split[3]).
	       '</b> лв. Плащане : <b>'.$split[4].'</b> лв.  Крайно салдо : <b>'.Add_Fraction_Part($difference).'</b> лв.<br>';
	}
	else 
	{
	  echo 'Фактура от дата  &nbsp;: <font color="red" size="4">&nbsp;<b>'.$split[0].'</b></font> Начално салдо : <b>'.Add_Fraction_Part($split_bufer[3]).
	       '</b> лв. Плащане : <b>'.$split_bufer[4].'</b> лв.  Крайно салдо : <b>'.Add_Fraction_Part($diff_bufer).'</b> лв.<br>';
	}
	if(format_date($split[0])>=format_date($pad_date))
	{  
	  $interest[$i]=GetInterest($split[0],$split[1],$split[2] ,$array_interest_rate, $points, $flag);
	}
	//if (is_string($interest[$i])){$interest=array();break;}
  }
  echo '<b><font color="DarkSeaGreen" size="4"> Работна дата  : </font><font color="red" size="4">'.$date.'</font><br></b>';
  if (!(empty($interest)))
  {
    $array[0]= Add_Fraction_Part_4(array_sum($interest));
    if ($array[0] < $interest_pay) 
	{ 
	  echo 'Тъй като изчислената лихва: <b>'.$array[0].'</b>  е по-малка от платената посредством
            платежни документи лихва: <b>'.$interest_pay.'</b>, то функцията връща стойността на платената лихва !!!
			<br>';
			$array[0] = $interest_pay;
	}
  }
}
else {
  echo '<b><font color="DarkSeaGreen" size="4">Падежна дата : </font><font color="red" size="4">'.$pad_date.'</font></b>';	
  $array[0]=GetInterest($pad_date,$date,$month_balance ,$array_interest_rate, $points, $flag);++$k;
  echo '<b><font color="DarkSeaGreen" size="4">Работна дата : </font><font color="red" size="4">'.$date.'</font></b><br>';
}
$array[1]=$pad_date;
$array[2]=$interest_debt;
$array[3]=$interest_pay;
?>
<table border="0" cellpadding="0" cellspacing="0" bgcolor="#eeeeee" style="position:relative" style="left:48.8%">
  <tr>
    <td align="right" width="250" bgcolor="DarkSeaGreen"><b><font color="white" size="5"> Изчислената лихва е :</font></b></td>
    <th width="120" bgcolor="DarkSeaGreen"><font color="red" size="5"><?echo $array[0]?></font></th>
  </tr>
<?
return $array;
}
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//Иван Иванов 10-08-2007
//Фунцията връща датата на падеж за конкретно салдо на конкретен договор
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function GetPadDate($year, $month, $contr_id)
{
$query=mysql_query("select pad_date from paddate where contr_id=".$contr_id." and year=".$year." and month=".$month);
$result=mysql_fetch_row($query);
if (mysql_num_rows($query)==1){return format_date($result[0]);}
else {
$month_bufer=$month;
$year_bufer=$year;	
$query=mysql_query("select * from contracts where contr_id=".$contr_id);
$row=mysql_fetch_array($query);
if ($row['pay_time']>0 and $row['pay_time']<10) {$day='0'.$row['pay_time'];}else{$day=$row['pay_time'];}
switch ($row['pay_month']) {
  case 1:if ($month==1){$pad_date=$day.'-12-'.--$year_bufer;} 
         else {$pad_date=$day.'-'.--$month_bufer.'-'.$year;}break;
  case 2:$pad_date=$day.'-'.$month.'-'.$year;break;
  case 3:if ($month==12){$pad_date=$day.'-01-'.++$year_bufer;} 
         else {$pad_date=$day.'-'.++$month_bufer.'-'.$year;}break;
}
$checkdate=split('[-]',$pad_date);
if ($checkdate[1]=='1'){$checkdate[1]='01';} if ($checkdate[1]=='4'){$checkdate[1]='04';} if ($checkdate[1]=='7'){$checkdate[1]='07';}
if ($checkdate[1]=='2'){$checkdate[1]='02';} if ($checkdate[1]=='5'){$checkdate[1]='05';} if ($checkdate[1]=='8'){$checkdate[1]='08';}
if ($checkdate[1]=='3'){$checkdate[1]='03';} if ($checkdate[1]=='6'){$checkdate[1]='06';} if ($checkdate[1]=='9'){$checkdate[1]='09';}
$pad_date = $checkdate[0].'-'.$checkdate[1].'-'.$checkdate[2];
$checkdate=split('[-]',$pad_date);

if (!checkdate($checkdate[1], $checkdate[0],$checkdate[2])){
  $pad_date= LastDayOfMonth($checkdate[1], $checkdate[2]).'-'.$checkdate[1].'-'.$checkdate[2];
  //Ако датата на падеж е невалидна (напр. 30-то число на февруари), тя се насочва към последния ден на текущия месец (28 или 29 февруари)
}
return $pad_date;
}
}	
?>