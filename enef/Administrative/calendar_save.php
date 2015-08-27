<?
	include_once "../inc/conf.php";

function reverseDate($value){
	$changeDate = explode('-', $value);
		$d = $changeDate[0];
		$m = $changeDate[1];
		$y = $changeDate[2];
			$arr = array($y, $m, $d);
			$changeDate = implode('-', $arr);
				return mysql_real_escape_string($changeDate);
}
//година
	if(!empty($_GET['year'])){$year1 = $_GET['year'];}
	if(!empty($_GET['year2'])){$year2 = $_GET['year2'];}
	if(!empty($_GET['year3'])){$year3 = $_GET['year3'];}
	if(!empty($_GET['year4'])){$year4 = $_GET['year4'];}
	if(!empty($_GET['year5'])){$year5 = $_GET['year5'];}
//почивен ден
	if(!empty($_GET['rest_day'])){$rest1 = reverseDate($_GET['rest_day']);}
	if(!empty($_GET['rest_day2'])){$rest2 = reverseDate($_GET['rest_day2']);}
	if(!empty($_GET['rest_day3'])){$rest3 = reverseDate($_GET['rest_day3']);}
	if(!empty($_GET['rest_day4'])){$rest4 = reverseDate($_GET['rest_day4']);}
	if(!empty($_GET['rest_day5'])){$rest5 = reverseDate($_GET['rest_day5']);}
//работен ден
	if(!empty($_GET['work_day'])){$work1 = reverseDate($_GET['work_day']);}
	if(!empty($_GET['work_day2'])){$work2 = reverseDate($_GET['work_day2']);}
	if(!empty($_GET['work_day3'])){$work3 = reverseDate($_GET['work_day3']);}
	if(!empty($_GET['work_day4'])){$work4 = reverseDate($_GET['work_day4']);}
	if(!empty($_GET['work_day5'])){$work5 = reverseDate($_GET['work_day5']);}
//основание
	if(!empty($_GET['reason'])){$reason1 = $_GET['reason'];}
	if(!empty($_GET['reason2'])){$reason2 = $_GET['reason2'];}
	if(!empty($_GET['reason3'])){$reason3 = $_GET['reason3'];}
	if(!empty($_GET['reason4'])){$reason4 = $_GET['reason4'];}
	if(!empty($_GET['reason5'])){$reason5 = $_GET['reason5'];}

	$sql = "INSERT INTO calendar(year, extra_work_day, extra_not_work_day, reason)";
	if($_GET['check1'] == 1){$sql .= " VALUES('$year1','$work1','$rest1','" . urldecode($reason1) . "')";}
	if($_GET['check2'] == 2){$sql .= ", ('$year2','$work2','$rest2','" . urldecode($reason2) . "')";}
	if($_GET['check3'] == 3){$sql .= ", ('$year3','$work3','$rest3','" . urldecode($reason3) . "')";}
	if($_GET['check4'] == 4){$sql .= ", ('$year4','$work4','$rest4','" . urldecode($reason4) . "')";}
	if($_GET['check5'] == 5){$sql .= ", ('$year5','$work5','$rest5','" . urldecode($reason5) . "')";}


	$res = sql_q($sql) or die(mysql_error());
		if($res){
			echo "good";
		}else{
			echo "bad";
		}
?>