<?php
  include("../inc/conf.php");

  $user_id = $_GET['user_data'];

  if ($_POST['insert_x']) {
    $group_id = $_POST['groups'];
    $user_id = $_POST['user_id'];

    sql_q("INSERT INTO group_users VALUES('$group_id', '$user_id')");
  } else if ($_POST['delete_x']) {
    $group_id = $_POST['users_group'];
    $user_id = $_POST['user_id'];

    sql_q("DELETE FROM group_users WHERE group_id = '$group_id' AND user_id = '$user_id'");
  } else if ($_POST['exit_x']) {
    echo "<script language='Javascript'>window.close();</script>";
  }
?>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
  <meta http-equiv="Content-Language" content="bg">

  <title>Групи на потребителя</title>

  <script language="JavaScript" src="JFunctions.js"></script>
</head>
<body background="Images/Stone.jpg" onload="fuser_groups.group_users.focus()">
  <form name="fuser_groups" action="UserGroups.php" method="post">
    <fieldset>
      <legend>Групи на потребителя</legend>
      <input type="hidden" name="user_id" value="<?=$user_id?>">
      <table width="100%" height="80%" border="0">
        <tr>
          <td>
            <select name="users_group" size="10" style="width:100%">
            <?
              $result = sql_q("SELECT g.id, g.name FROM group_users gu, groups g
                                     WHERE gu.group_id = g.id AND gu.user_id = '$user_id' ORDER BY g.name");
              while ($row = mysql_fetch_array($result)) {
                echo "<option value='".$row['id']."'>".$row['name']."</option>";
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
          <select name="groups" size="1" style="width:100%">
            <option value=""></option>
          <?
            $result = sql_q("SELECT gu.group_id, g.id, g.name FROM group_users gu RIGHT JOIN groups g ON gu.group_id = g.id
                                   AND gu.user_id = '$user_id' ORDER BY g.name");
            while ($row = mysql_fetch_array($result)) {
              if (empty($row['group_id'])) {
                echo "<option value='".$row['id']."'>".$row['name']."</option>";
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
            onclick="if (groups.value == '') {
                       alert('Изберете група, която желаете да добавите!');
                       return false;
                     }">
          <input type="image" name="delete" src="Images/Delete.gif" border="0"
            onclick="if (users_group.value == '') {
                       alert('Маркирайте група, който желаете да изтриете!');
                       return false;
                     }">
          <input type="image" name="exit" src="Images/Exit.gif" border="0">
        </td>
      </tr>
    </table>
  </form>
</body>
</html>

