<?php
  include("../inc/conf.php");

  $group_id = $_GET['group_data'];

  if ($_POST['add_x']) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $status = $_POST['status'];

    if ($_GET['edit_flag'] == 1) {
      $group_id = $_POST['group_id'];

      sql_q("UPDATE groups SET name = '$name', description = '$description', status = '$status' WHERE id = '$group_id'");
    }
    else {
      sql_q("INSERT INTO groups VALUES('NULL', '$name', '$description', '$status')");
    }
    ?>
      <script language="JavaScript">
        window.close();
        window.opener.location.href="Groups.php";
      </script>
    <?
  }

  $result = sql_q("SELECT name, description, status FROM groups WHERE id = '$group_id'");
  $row = mysql_fetch_array($result);
?>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
  <meta http-equiv="Content-Language" content="bg">

  <title>Групи потребители</title>

  <script language="JavaScript" src="JFunctions.js"></script>
</head>
<body background="Images/Stone.jpg" onload="fgroups_data.name.focus()">
  <form name="fgroups_data" action="GroupsData.php?edit_flag=<?=$_GET['edit_flag']?>" method="post">
    <table width="100%" height="100%">
      <tr valign="top">
        <td height="90%">
          <input type="hidden" name="group_id" value="<?=$group_id?>">
          <fieldset>
            <legend>Данни за група</legend>
            <table width="100%" height="80%" border="1">
              <tr>
                <td width="30%">Наименование:</td>
                <td width="70%">
                  <input type="text" name="name" style="width:100%" maxlength="40" value="<?=htmlspecialchars($row['name'], ENT_QUOTES)?>">
                </td>
              </tr>
              <tr>
                <td valign="top">
                  Описание:<br>
                  <font size=-1>до 150 символа</font>
                </td>
                <td>
                  <textarea name="description" rows="4" cols="35"><? echo $row['description']?></textarea>
                </td>
              </tr>
              <tr>
                <td>Състояние:</td>
                <td>
                  <select name="status" size="1" style="width:44%">
                  <?
                    if (empty($row['status'])) {
                    ?>
                      <option value="0" selected>Неактивна</option>
                      <option value="1">Активна</option>
                    <?
                    } else {
                    ?>
                      <option value="0">Неактивна</option>
                      <option value="1" selected>Активна</option>
                    <?
                    }
                  ?>
                  </select>
                </td>
              </tr>
            </table>
          </fieldset>
        </td>
      </tr>
      <tr valign="bottom">
        <td height="10%" align="right">
          <input type="image" name="add" src="Images/Add.gif" border="0" onclick="return VerifyValidData('fgroups_data')">
          <input type="image" name="exit" src="Images/Exit.gif" border="0" onClick="window.close()">
        </td>
      </tr>
    </table>
  </form>
</body>
</html>

