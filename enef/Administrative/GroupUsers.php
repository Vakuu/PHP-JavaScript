<?php
  include("../inc/conf.php");

  $group_id = $_GET['group_data'];

  if ($_POST['insert_x']) {
    $group_id = $_POST['group_id'];
    $user_id = $_POST['users'];

    sql_q("INSERT INTO group_users VALUES('$group_id', '$user_id')");
  } else if ($_POST['delete_x']) {
    $group_id = $_POST['group_id'];
    $user_id = $_POST['group_users'];

    sql_q("DELETE FROM group_users WHERE group_id = '$group_id' AND user_id = '$user_id'");
  } else if ($_POST['exit_x']) {
    echo "<script language='Javascript'>window.close();</script>";
  }
?>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
  <meta http-equiv="Content-Language" content="bg">

  <title>Потребители на групата</title>

  <script language="JavaScript" src="JFunctions.js"></script>
</head>
<body background="Images/Stone.jpg" onload="fgroup_users.group_users.focus()">
  <form name="fgroup_users" action="GroupUsers.php" method="post">
    <fieldset>
      <legend>Потребители на групата</legend>
      <input type="hidden" name="group_id" value="<?=$group_id?>">
      <table width="100%" height="80%" border="0">
        <tr>
          <td>
            <select name="group_users" size="10" style="width:100%">
            <?
              $result = sql_q("SELECT u.id, u.username FROM group_users g, users u
                                     WHERE g.user_id = u.id AND g.group_id = '$group_id' ORDER BY u.username");
              while ($row = mysql_fetch_array($result)) {
                echo "<option value='".$row['id']."'>".$row['username']."</option>";
              }
            ?>
            </select>
          </td>
        </tr>
      </table>
    </fieldset>
    <table width="100%">
      <tr>
        <td>
          <select name="users" size="1" style="width:100%">
            <option value=""></option>
          <?
            $result = sql_q("SELECT gu.user_id, u.id, u.username FROM group_users gu RIGHT JOIN users u ON gu.user_id = u.id
                                   AND gu.group_id = '$group_id' ORDER BY u.username");
            while ($row = mysql_fetch_array($result)) {
              if (empty($row['user_id'])) {
                echo "<option value='".$row['id']."'>".$row['username']."</option>";
              }
            }
          ?>
          </select>
        </td>
      </tr>
      <tr>
        <td>
          <br>
          <input type="image" name="insert" src="Images/Insert.gif" border="0"
            onclick="if (users.value == '') {
                       alert('Изберете потребител, който желаете да добавите!');
                       return false;
                     }">
          <input type="image" name="delete" src="Images/Delete.gif" border="0"
            onclick="if (group_users.value == '') {
                       alert('Маркирайте потребител, който желаете да изтриете!');
                       return false;
                     }">
          <input type="image" name="exit" src="Images/Exit.gif" border="0">
        </td>
      </tr>
    </table>
  </form>
</body>
</html>

