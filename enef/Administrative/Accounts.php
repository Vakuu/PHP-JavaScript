<?php

/**
 * @author LulaPresidente
 * @copyright 2010
 */



?><?php
  include("../inc/conf.php");

  if ($_POST['delete_x']) {
    $group_id = $_POST['data'];

    //sql_q("DELETE FROM groups WHERE id = '$group_id'");
   // sql_q("DELETE FROM group_users WHERE group_id = '$group_id'");
   // sql_q("DELETE FROM permissions WHERE group_id = '$group_id'");
  } else if ($_POST["home_x"]) {
    echo "<script language='JavaScript'> top.main_window.location.href='Index.html'; </script>";
  }
?>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
  <meta http-equiv="Content-Language" content="bg">

  <title>Сметки</title>

  <script language="JavaScript" src="JFunctions.js"></script>
</head>
<body background="Images/Stone.jpg" scroll="no">
  <form name="faccounts" action="Accounts.php" method="post">
    <table width="100%" height="100%" align="center">
      <tr valign="top">
        <td height="90%" align="center">
          <table>
            <tr>
              <td>
                <fieldset>
                  <legend>Сметки</legend>
                  <table width="740px" align="center">
                    <tr>
                      <td width="730px">
                        <input type="hidden" name="data">
                        <table width="100%" border="1">
                          <tr>
                          	<td width="20px" align="center">№</td>
                            <td width="250px" align="center">Наименование</td>
                            <td width="116px" align="center">Номер(сметкоплан)</td>
                            <td width="250px" align="center">IBAN</td>
                            <td width="90px" align="center">Състояние</td>
                            <td width="14">&nbsp;</td>
                          </tr>
                          <tr>
                            <td colspan="7">
                              <div style="height:280px; overflow-y:scroll;">
                                <table width="100%">
                                <?$i=0;
                                  $result = sql_q("SELECT * FROM accounts_municipality ORDER BY id_accounts ");
                                  $buttons_flag = mysql_num_rows($result);

                                  while ($row = mysql_fetch_array($result)) {
                                  	$i++;
                                  	//echo $row['id_accounts']
                                  ?>
                                    <tr onMouseOver="LmOverOut('faccounts', this, <? echo $row['id_accounts']?>, '#33CC00', '66FFFF')"
                                      onMouseOut="LmOverOut('faccounts', this, <? echo $row['id_accounts']?>, '', '#66FFFF')" onMouseDown="LmDown('faccounts', <? echo $row['id_accounts']?>, this)">
                                      <td width="18px"><? echo $i?></td>
                                      <td width="256px"><? echo $row['name_accounts']?></td>
                                      <td width="125px"><? echo $row['number']?></td>
                                      <td width="235px"><? echo $row['iban']?></td>
                                      <?
                                        if (empty($row['status'])) {
                                          $status = "Неактивна";
                                        } else {
                                          $status = "Активна";
                                        }
                                      ?>
                                      <td width="90px"><? echo $status?></td>
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
                        &nbsp;
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
          <input type="image" name="new" src="Images/New.gif" border="0" onclick="OpenWindow('Accounts_data.php?edit_flag=0', '', 580, 520); return false">
          <?
            if ($buttons_flag > 0) {
            ?>
              <input type="image" name="edit" src="Images/Edit.gif" border="0"
                onclick="if (faccounts.data.value) {
                           OpenWindow('Accounts_data.php?id_accounts=' + faccounts.data.value + '&edit_flag=1', '', 580, 520)
                         } else {
                           alert('Маркирайте запис, който желаете да редактирате!');
                         }
                         return false;">
              
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


