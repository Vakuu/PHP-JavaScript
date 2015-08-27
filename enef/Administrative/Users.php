<?php
  include("../inc/conf.php");
  $all=$_REQUEST['all'];
  if ($all=='') $all=2;
//echo $all;
  if ($_POST['delete_x']) {
    $user_id = $_POST['data'];

    sql_q("DELETE FROM users WHERE id = '$user_id'");
    sql_q("DELETE FROM group_users WHERE user_id = '$user_id'");
  } else if ($_POST["home_x"]) {
    echo "<script language='JavaScript'> top.main_window.location.href='Index.html'; </script>";
  }
?>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
  <meta http-equiv="Content-Language" content="bg">

  <title>Потребители</title>

  <script language="JavaScript" src="JFunctions.js"></script>
</head>
<body background="Images/Stone.jpg" scroll="no">
  <form name="fusers" action="Users.php?all=<?=$all?>" method="post">
    <table width="100%" height="100%">
      <tr valign="top">
        <td height="90%" align="center">
          <table>
            <tr>
              <td>
                <fieldset>
                  <legend>Потребители</legend>
                  <table width="740px" align="center">
                    <tr>
                      <td width="610px">
                        <input type="hidden" name="data">
                        <table width="100%" border="1">
                          <tr>
                            <td width="92px" align="center">Потребител</td>
                            <td width="150px" align="center">Име</td>
                            <td width="170px" align="center">Е-майл</td>
                            <td width="170px" align="center">Район</td>
                            <td width="80px" align="center">Състояние</td>
                            <td width="14">&nbsp;</td>
                          </tr>
                          <tr>
                            <td colspan="5">
                              <div style="height:280px; overflow-y:scroll;">
                                <table width="100%">
                                <?
                                  $query_main="SELECT * FROM users ";
                                  if ($all==1)
                                  {
									$query_main.=" WHERE status=1";
								  }
								  elseif ($all==0)
								  {
									$query_main.=" WHERE status=0";
								  }
                                  $query_main.= " ORDER BY full_name ";
                                  $result = sql_q($query_main);
                                  $buttons_flag = mysql_num_rows($result);

                                  while ($row = mysql_fetch_array($result)) {
                                  ?>
                                    <tr onMouseOver="LmOverOut('fusers', this, <? echo $row['id']?>, '#33CC00', '66FFFF')"
                                      onMouseOut="LmOverOut('fusers', this, <? echo $row['id']?>, '', '#66FFFF')" onMouseDown="LmDown('fusers', <? echo $row['id']?>, this)">
                                      <td width="90px"><? echo $row['username']?></td>
                                      <td width="150px"><? echo $row['full_name']?></td>
                                      <td width="170px"><? echo $row['email']?></td>
                                      <?php //by Petko Mihailov
                                      if($row['placement']!=''){
                                        $shp="SELECT region_name FROM regions WHERE show_cod='".$row['placement']."'";
                                        //$shp="SELECT cod_name FROM elements WHERE nom_code ='02' AND cod_cod='".$row['placement']."'";
                                        $show_placement = sql_q($shp);
                                        $place = mysql_fetch_array($show_placement);
                                         $nas_m=$place['region_name'];
                                      } //end PM source
                                      ?>
                                      <td width="170px"><? echo $nas_m?></td>
                                      <?
                                        if (empty($row['status'])) {
                                          $status = "Неактивен";
                                        } else {
                                          $status = "Активен";
                                        }
                                      ?>
                                      <td width="82px"><? echo $status?></td>
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
                        <input type="image" src="Images/GroupsUp.gif" onmouseout="this.src='Images/GroupsUp.gif'" onmouseover="this.src='Images/GroupsDown.gif'"
                          onclick="if (fusers.data.value == '') {
                                     alert('Маркирайте потребител и натинете бутона \'Групи\'!');
                                   } else {
                                     OpenWindow('UserGroups.php?user_data=' + data.value, '', 320, 290);
                                   } return false">
                        <br><br>
                        <!--<input type="image" src="Images/RightsUp.gif" onmouseout="this.src='Images/RightsUp.gif'" onmouseover="this.src='Images/RightsDown.gif'" onclick="alert('Правата все още са в процес на разработка!!!'); return false;">-->
                        <br><br><br><br>
                        &nbsp;&nbsp;&nbsp;&nbsp;Покажи:
                        <br><br>
<?
	$sql_active = "SELECT COUNT(status) 
				   FROM users 
				   WHERE status = '1'";
	$sql_unactive = "SELECT COUNT(status) 
					 FROM users 
					 WHERE status = '0'";
	$sql_all = "SELECT COUNT(status) 
				FROM users";
	$res_active = sql_q($sql_active) or die(mysql_error());
	$res_unactive = sql_q($sql_unactive) or die(mysql_error());
	$res_all = sql_q($sql_all) or die(mysql_error());
		$row_active = mysql_fetch_assoc($res_active);
		$row_unactive = mysql_fetch_assoc($res_unactive);
		$row_all = mysql_fetch_assoc($res_all);
?>
                        <input type="radio" name="all" id="active" value="1" <? if ($all==1) echo "checked"?> onclick="fusers.submit();">
							<label for="active">
								Активни 
								<font color="red"><?= $row_active['COUNT(status)']?></font>
							</label>
						<br>
                        <input type="radio" name="all" id="unactive" value="0" <?if ($all==0) echo "checked"?>  onclick="fusers.submit();">
							<label for="unactive">
								Неактивни 
								<font color="red"><?= $row_unactive['COUNT(status)']?></font>
							</label>
						<br>
                        <input type="radio" name="all" id="all" value="2" <?if ($all==2) echo "checked"?>  onclick="fusers.submit();">
							<label for="all">
								Всички 
								<font color="red"><?= $row_all['COUNT(status)']?></font>
							</label>
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
          <input type="image" name="new" src="Images/New.gif" border="0" onclick="OpenWindow('UsersData.php?edit_flag=0', '', 480, 300); return false">
          <?
            if ($buttons_flag > 0) {
            ?>
              <input type="image" name="edit" src="Images/Edit.gif" border="0"
                onclick="if (fusers.data.value) {
                           OpenWindow('UsersData.php?user_data=' + fusers.data.value + '&all=<?=$all?>&edit_flag=1', '', 480, 300)
                         } else {
                           alert('Маркирайте запис, който желаете да редактирате!');
                         }
                         return false;">
              <input type="image" name="delete" src="Images/Delete.gif" border="0"
                onclick="if (fusers.data.value) {
                           if (!(ConfirmAction('Сигурни ли сте, че искате да изтриете маркирания запис?', 'Users.php'))) { return false }
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


