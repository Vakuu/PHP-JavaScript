<?
include("../../inc/conf.php");
echo '<html>';
echo '<head>';
echo '</head>';
echo '<body background="../Images/Stone.jpg" scroll="no">';
echo '<form action="Updates.php" method="post">';
echo '<table width="100%" height="100%" align="center">';
echo '<tr valign="top"><td>';
  if ($_POST['flag']){
	$file_string=file_get_contents($_POST['flag']);
	$file_string=substr($file_string,2,-2);
	eval($file_string);
  }  
  $last_up=mysql_fetch_row(sql_q("SELECT MAX(update_numb) FROM updates"));
  $next_up=$last_up[0]+1;
  $next_up_path="../../Updates/update_$next_up";
  if (is_dir($next_up_path)){
	if (is_file($next_up_path."/index.php")){
		$next_up_path.="/index.php";
		echo "<font color='red'><b>UPDATE_$next_up e подготвен за изпълнение : </b></font>";
		echo "<input type='submit' value='Изпълни'>";
		echo "<input type='hidden' name='flag' value='$next_up_path'>";
	}	
  }
  else{
  	  
      echo "<font color='blue'><b>Последната актуализация, която е била извършена успешно, е с номер <font color='red'>$last_up[0]</font>!<br>"; 
	  echo "Актуализация <font color='red'>$next_up</font> не заредена за изпълнение!</b></font>";
  } 
echo '</td></tr>';  
echo '<tr valign="bottom">';
echo "<td align='right'><img src = '../Images/Home.gif' style = 'cursor:pointer;' onclick = 'window.location.href = \"../Index.html\"'></td>";
echo '</tr>';
echo '</table>';
echo '</form>';
echo '</body>';
echo '</html>';
?>
