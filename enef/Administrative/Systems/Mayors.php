<?php
  include("../../inc/conf.php");

  if ($_POST['delete_x']) {
    $id = $_POST['data'];

    sql_q("DELETE FROM mayors WHERE id = '$id'");
   // sql_q("DELETE FROM group_users WHERE user_id = '$user_id'");
  } //else if ($_POST["home_x"]) {
   // echo "<script language='JavaScript'> top.main_window.location.href='.php'; </script>";
 // }
 
$result = sql_q("SELECT ifmayor FROM municipality;");
$row = mysql_fetch_array($result);
$res_ifmayor = sql_q("SELECT * FROM elements WHERE nom_code = '66' and cod_cod='".$row['ifmayor']."'");
$row_ifmayor = mysql_fetch_assoc($res_ifmayor);
$ifmayor=$row_ifmayor['cod_name'];
 
?>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
  <meta http-equiv="Content-Language" content="bg">

  <title>Данни - <?=$ifmayor?></title>

  <script language="JavaScript" src="../JFunctions.js"></script>
</head>
<body background="../Images/Stone.jpg" scroll="no">
  <form name="fmayors" action="Mayors.php" method="post">
    <table width="100%" height="100%">
      <tr valign="top">
        <td height="90%" align="center">
          <table>
            <tr>
              <td>
                <fieldset>
                  <legend><?=$ifmayor?></legend>
                  <table width="740px" align="center">
                    <tr>
                      <td width="610px">
                        <input type="hidden" name="data">
                        <table width="100%" border="1">
                          <tr>
                            <td width="20px" align="center">№</td>
                            <td width="150px" align="center">Име</td>
                            <td width="80px" align="center">От дата</td>
                            <td width="80px" align="center">До дата</td>
                            <td width="14">&nbsp;</td>
                          </tr>
                          <tr>
                            <td colspan="5">
                              <div style="height:280px; overflow-y:scroll;">
                                <table width="100%">
                                <? $i=1;
                                  $result = sql_q("SELECT * FROM mayors ORDER BY date_to DESC");
                                  $buttons_flag = mysql_num_rows($result);

                                  while ($row = mysql_fetch_array($result)) {
                                  ?>
                                    <tr onMouseOver="LmOverOut('fmayors', this, <? echo $row['id']?>, '#33CC00', '66FFFF')"
                                      onMouseOut="LmOverOut('fmayors', this, <? echo $row['id']?>, '', '#66FFFF')" onMouseDown="LmDown('fmayors', <? echo $row['id']?>, this)">
                                      <td width="20px"><? echo $i?></td>
                                      <td width="150px"><? echo $row['name']?></td>
                                      <td width="80px"><? echo $row['date_from']?></td>
                                      <td width="80px"><? echo $row['date_to']?></td>
                                      
                                    </tr>
                                  <?
                                  $i++;
                                  }
                                ?>
                                </table>
                              </div>
                            </td>
                          </tr>
                        </table>
                      </td>
                      <td valign="top">
                        
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
          <input type="image" name="new" src="../Images/New.gif" border="0" onclick="OpenWindow('Mayors_data.php?edit_flag=0', '', 480, 270); return false">
          <?
            if ($buttons_flag > 0) {
            ?>
              <input type="image" name="edit" src="../Images/Edit.gif" border="0"
                onclick="if (fmayors.data.value) {
                           OpenWindow('Mayors_data.php?data=' + data.value+ '&edit_flag=1', '', 480, 270)
                         } else {
                           alert('Маркирайте запис, който желаете да редактирате!');
                         }
                         return false;">
              <input type="image" name="delete" src="../Images/Delete.gif" border="0"
                onclick="if (fmayors.data.value) {
                           if (!(ConfirmAction('Сигурни ли сте, че искате да изтриете маркирания запис?', 'Mayors.php'))) { return false }
                         } else {
                           alert('Маркирайте запис, който желаете да изтриете!');
                           return false;
                         }">
            <?
            } else {
            ?>
              <input type="image" name="edit" src="../Images/EditDisable.gif" border="0" disabled>
              <input type="image" name="delete" src="../Images/DeleteDisable.gif" border="0" disabled>
            <?
            }
          ?>
         <!-- <input type="image" name="home" src="../Images/Home.gif" border="0" onclick = "window.location.href = '../Index.html'">-->
           <img src = '../Images/Home.gif' style = 'cursor:pointer;' onclick = "window.location.href = '../Index.html'">
        </td>
      </tr>
    </table>
  </form>
</body>
</html>


