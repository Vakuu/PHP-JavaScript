<?
	include("../inc/conf.php");
	header("Content-type: text/html; charset=windows-1251");
	
function die_err($text){
	die("<br><font color=red><b>".$text."</b></font>\n");
}
	// echo $_POST['data'];
if(isset($_POST)){
	echo "<br><b>Изпълнение на sql заявките:</b><hr>";
	
	set_time_limit("1000");
	$sql = trim($_POST['data']);

	$sql = ereg_replace("#[^\n]*\n", "", $sql);
	$buffer = array();
	$ret = array();
	$in_string = false;

	for($i=0; $i<strlen($sql)-1; $i++){
		if($sql[$i] == ";" && !$in_string){
			$ret[] = substr($sql, 0, $i);
			$sql = substr($sql, $i + 1);
			$i = 0;
		}

		if($in_string && ($sql[$i] == $in_string) && $buffer[0] != "\\"){
			$in_string = false;
		}elseif(!$in_string && ($sql[$i] == "\"" || $sql[$i] == "'")&&(!isset($buffer[0]) || $buffer[0] != "\\")){
			$in_string = $sql[$i];
		}
		
		if(isset($buffer[1])){
			$buffer[0] = $buffer[1];
		}else{
			$buffer[1] = $sql[$i];
		}
	}
  
	if(!empty($sql)){
		$ret[] = $sql;
	}
		if(count($ret)==0){ 
			die_err('Не са подадени заявки за изпълнение');
		}
	
		foreach($ret as $key=>$query){
			$query=trim($query);
			$query=stripslashes($query);
				echo "<b>[".$key."]</b> ".urlencode(htmlspecialchars($query))."<br>";
					logit("admin query: ".$query);
			$result=@sql_q($query);
				if(mysql_error()==false){ 
					logit("admin query ok");
					echo "<font color=blue>OK</font><br>";
				}else{
					logit("admin query err: ".mysql_error());
						echo "<font color=red><i>Грешка: ".mysql_error()."</i></font><br>";
						$sqlerr=true;
				}
			echo "<hr>";
		}
  
	echo "<b>  Изпълнението на заявките приключи ";
		if($sqlerr==true){
			echo "<font color=red> с грешки</font>";
		}else{
			echo " без грешки";
		}
	echo "</b><br>";
}
?>