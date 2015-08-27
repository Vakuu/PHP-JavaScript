<?
include('inc/conf.php');
if ($_POST['confirm_x']) {
    switch ($_POST['module']) {
     case 1: header("location: Administrative/Index.html"); break;
     case 2: header("location: DomoUpravitel.php"); break;
     case 3: header("location: Sdrujenie.php"); break;
     case 4: header("location: spravkaDom.php"); break;
     case 5: header("location: spravkaSdr.php"); break;
     case 6: header("location: asoc/index.php"); break;
    }
}


$modules_id = array();
$row = sql_row("SELECT id FROM users WHERE username = '$_SESSION[username]' ");

$result = sql_q("SELECT gu.group_id FROM group_users gu, groups g
                  WHERE gu.group_id = g.id AND gu.user_id = '$row[id]'
                  AND g.status = '1' ORDER BY gu.user_id, gu.group_id");
while ($row = mysql_fetch_array($result)) {
    $result_data = sql_q("SELECT DISTINCT module_id FROM permissions WHERE group_id = '$row[group_id]' ORDER BY module_id");
    while ($row_data = mysql_fetch_array($result_data)) {
        if (!in_array($row_data['module_id'], $modules_id)) {
            array_push($modules_id, $row_data['module_id']);
        }
    }
    mysql_free_result($result_data);
  }
?>
<html>
<head>
 <meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
  <meta http-equiv="Content-Language" content="bg">
<style>
body{
	margin: 0; 
	padding: 0;
}
</style>
</head>
<body background="images/Stone.jpg">
<img  src="images/es.jpg" width="100%" height="40%"/> 
<h3>
	<font color='#0E8130'>
		<center>
			Здравейте <b><?= $_SESSION['username'] ?></b>. 
			Вие работите със система <br>
			"Сдружения в режим на етажна собственост" (РЕГЕС)<br>
			на "Столична община".<br/>
      Разработил: "Брайт Комплекс АТ" ЕООД.
		</center>
	</font>
</h3>
<center>
	Моля, изберете модула, с който желаете да работите.
</center>
  <form action="Modules.php" method="post" target="_top">
    <table width="100%" height="35%" border="0" valign="middle">
      <tr>
        <td>
          <table width="260px" border="1" align="center">
            <th bgcolor="#629C73"><font color="#FFFFFF">Достъпни модули:</font></th>
        <?
$result = sql_q("SELECT id, name FROM modules WHERE status = '1'");
while ($row = mysql_fetch_array($result)) {
   if (in_array($row['id'], $modules_id)) {
        echo "<tr>";
        echo "<td align='left'><input type='radio' name='module' id='" . $row['name'] . "' value='".$row['id']."'><b><label for='" . $row['name'] . "'>".$row['name']."</label></b></td>";
        echo "</tr>";
    }
}
mysql_free_result($result);
mysql_close($connect);
//echo $result;
?>
          </table>
          <br/>
          <div align="center">
            <input type="image" name="confirm" src="Images/ConfirmUp.gif" onmouseout="this.src='Images/ConfirmUp.gif'" onmouseover="this.src='Images/ConfirmDown.gif'">
            <input type="image" src="Images/ExitUp.gif" onmouseout="this.src='Images/ExitUp.gif'" onmouseover="this.src='Images/ExitDown.gif'" onclick="location.href='Logout.php'; return false">
          </div>
        </td>
      </tr>
	  <tr>
		<td>
			<?php include "footer.html"; ?>
		</td>
	  </tr>
    </table>
  </form>
</body>
</html>