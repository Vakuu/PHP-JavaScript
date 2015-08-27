<?php
  include("../inc/conf.php");

  if ($_POST['delete_x']) {
    $group_id = $_POST['data'];

    sql_q("DELETE FROM groups WHERE id = '$group_id'");
    sql_q("DELETE FROM group_users WHERE group_id = '$group_id'");
    sql_q("DELETE FROM permissions WHERE group_id = '$group_id'");
  } else if ($_POST["home_x"]) {
    echo "<script language='JavaScript'> top.main_window.location.href='Index.html'; </script>";
  }
?>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
  <meta http-equiv="Content-Language" content="bg">

  <title>Групи</title>

  <script language="JavaScript" src="JFunctions.js"></script>
</head>
<body background="Images/Stone.jpg" scroll="no">
  <form name="fgroups" action="Groups.php" method="post">
    <table width="100%" height="100%" align="center">
      <tr valign="top">
        <td height="90%" align="center">
          <table>
            <tr>
              <td>
                <fieldset>
                  <legend>Групи</legend>
                  <table width="740px" align="center">
                    <tr>
                      <td width="610px">
                        <input type="hidden" name="data">
                        <table width="100%" border="1">
                          <tr>
                            <td width="200px" align="center">Наименование</td>
                            <td width="316px" align="center">Описание</td>
                            <td width="90px" align="center">Състояние</td>
                            <td width="14">&nbsp;</td>
                          </tr>
                          <tr>
                            <td colspan="5">
                              <div style="height:280px; overflow-y:scroll;">
                                <table width="100%">
                                <?
                                  $result = sql_q("SELECT * FROM groups ORDER BY id");
                                  $buttons_flag = mysql_num_rows($result);

                                  while ($row = mysql_fetch_array($result)) {
                                  ?>
                                    <tr onMouseOver="LmOverOut('fgroups', this, <? echo $row['id']?>, '#33CC00', '66FFFF')"
                                      onMouseOut="LmOverOut('fgroups', this, <? echo $row['id']?>, '', '#66FFFF')" onMouseDown="LmDown('fgroups', <? echo $row['id']?>, this)">
                                      <td width="198px"><? echo $row['name']?></td>
                                      <td width="316px"><? echo $row['description']?></td>
                                      <?
                                        if (empty($row['status'])) {
                                          $status = "Неактивна";
                                        } else {
                                          $status = "Активна";
                                        }
                                      ?>
                                      <td width="93px"><? echo $status?></td>
                                    </tr>
                                  <?
                                  }
                                ?>
                                </table>
                              </div>
                            </td>
                          </tr>
                        </table>
                      </td>
                      <td valign="top">
                        <input type="image" src="Images/UsersUp.gif" onmouseout="this.src='Images/UsersUp.gif'" onmouseover="this.src='Images/UsersDown.gif'"
                          onclick="if (fgroups.data.value == '') {
                                     alert('Маркирайте група и натинете бутона \'Потребители\'!');
                                   } else {
                                     OpenWindow('GroupUsers.php?group_data=' + data.value, '', 320, 290);
                                   } return false" />
                        <br><br>
                        <input type="image" src="Images/RightsUp.gif" onmouseout="this.src='Images/RightsUp.gif'" onmouseover="this.src='Images/RightsDown.gif'"
                          onclick="if (fgroups.data.value == '') {
                                     alert('Маркирайте група и натинете бутона \'Права\'!');
                                   } else {
                                     if (fgroups.data.value != '1') {
                                       OpenWindow('GroupPermissions.php?group_data=' + data.value, '', 550, 700);
                                     } else {
                                       alert('Групата на администраторите има неограничени права!');
                                     }
                                   } return false" />
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<?php
	$sqlActive = "SELECT COUNT(name) 
				  FROM groups 
				  WHERE status = '1'";
	$resActive = sql_q($sqlActive) or die(mysql_error());
	$rowActive = mysql_fetch_assoc($resActive);
	//
	$sqlUnActive = "SELECT COUNT(name) 
					FROM groups 
					WHERE status = '0'";
	$resUnActive = sql_q($sqlUnActive) or die(mysql_error());
	$rowUnActive = mysql_fetch_assoc($resUnActive);
	//
	$sqlAll = "SELECT COUNT(name) 
			   FROM groups";
	$resAll = sql_q($sqlAll) or die(mysql_error());
	$rowAll = mysql_fetch_assoc($resAll);
	echo "Активни: <font color='red'>" . $rowActive['COUNT(name)'] . "</font><br/>";
	echo "Неактивни: <font color='red'>" . $rowUnActive['COUNT(name)'] . "</font><br/>";
	echo "Общо: <font color='red'>" . $rowAll['COUNT(name)'] . "</font><br/>";
?>
                      </td>
                    </tr>
                  </table>
                </fieldset>
              </td>
            </tr>
          </table>
        </td>
      </tr>
      <tr valign="bottom">
        <td height="10%" align="right">
          <input type="image" name="new" src="Images/New.gif" border="0" onclick="OpenWindow('GroupsData.php?edit_flag=0', '', 480, 220); return false">
          <?
            if ($buttons_flag > 0) {
            ?>
              <input type="image" name="edit" src="Images/Edit.gif" border="0"
                onclick="if (fgroups.data.value) {
                           OpenWindow('GroupsData.php?group_data=' + fgroups.data.value + '&edit_flag=1', '', 480, 220)
                         } else {
                           alert('Маркирайте запис, който желаете да редактирате!');
                         }
                         return false;">
              <input type="image" name="delete" src="Images/Delete.gif" border="0"
                onclick="if (fgroups.data.value) {
                           if (!(ConfirmAction('Сигурни ли сте, че искате да изтриете маркирания запис?', 'Groups.php'))) { return false }
                         } else {
                           alert('Маркирайте запис, който желаете да изтриете!');
                           return false;
                         }">
            <?
            } else {
            ?>
              <input type="image" name="edit" src="Images/EditDisable.gif" border="0" disabled>
              <input type="image" name="delete" src="Images/DeleteDisable.gif" border="0" disabled>
            <?
            }
          ?>
          <input type="image" name="home" src="Images/Home.gif" border="0">
        </td>
      </tr>
    </table>
  </form>
</body>
</html>


