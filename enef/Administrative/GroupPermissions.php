<?php
  include("../inc/conf.php");

  $group_id = $_GET['group_data'];
  $module_id = $_POST['module'];

  if ($_POST['add_x']) {
    $max = $_POST['max_function_id'] + 1;
    for ($i = 1; $i < $max; $i++) {
      if ($_POST['function_id'.$i] == 'on') {
        sql_q("INSERT INTO permissions (id, module_id, group_id, function_id, read_access) VALUES('NULL', '$module_id', '$group_id', '$i', 'Y')");
      }
    }

    $max =  $_POST['min_permission_id'];
    $max = $_POST['max_permission_id'] + 1;

    for ($i = $min; $i < $max; $i++) {
      if ($_POST['permission_id'.$i] == 'on') {
        sql_q("DELETE FROM permissions WHERE id = '$i'");
      }
    }
  }

  $functions_id = array();

  $result = sql_q("SELECT f.function_id FROM functions f, permissions p
                         WHERE f.module_id = p.module_id AND f.function_id = p.function_id
                         AND f.status = '1' AND p.group_id = '$group_id' AND f.module_id = '$module_id'");
  while ($row = mysql_fetch_array($result)) {
    array_push($functions_id, $row['function_id']);
  }
?>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
  <meta http-equiv="Content-Language" content="bg">

  <title>Права</title>

  <script language="JavaScript" src="JFunctions.js"></script>
</head>
<body background="Images/Stone.jpg" scroll="yes">
  <form name="fgroup_permissions" action="GroupPermissions.php?group_data=<?=$group_id?>" method="post">
    <table width="100%" height="100%" style="overflow-y:scroll;">
      <tr valign="top">
        <td height="90%">
          <fieldset>
            <legend>Права</legend>
            Модули:
            <select name="module" style="width:87%" size="1" onchange="fgroup_permissions.submit()">
              <option value=""></option>
            <?
              $result = sql_q("SELECT id, name FROM modules WHERE status = '1' AND id <> 1");
              while ($row = mysql_fetch_array($result)) {
                if ($row['id'] == $module_id) {
                ?><option value="<?=$row['id']?>" selected><? echo $row['name']?></option><?
                } else {
                ?><option value="<?=$row['id']?>"><? echo $row['name']?></option><?
                }
              }
            ?>
            </select>
            <br>
            <div align="center">Недостъпни функции:</div>
            <table width="490px" align="center">
              <tr>
                <td>
                  <input type="hidden" name="data">
                  <table width="100%" border="1">
                    <tr>
                      <td width="418px">Наименование</td>
                      <td width="60px" align="center">Добави</td>
                      <td width="14">&nbsp;</td>
                    </tr>
                    <tr>
                      <td colspan="3">
                        <div style="height:200px; overflow-y:scroll;">
                          <table width="100%">
                          <?
                            $result = sql_q("SELECT MAX(function_id) FROM functions WHERE status = '1' AND module_id = '$module_id'");
                            $row = mysql_fetch_row($result);
                            ?><input type="hidden" name="max_function_id" value="<?=$row[0]?>"><?

                            $result = sql_q("SELECT * FROM functions WHERE status = '1' AND module_id = '$module_id'");
                            while ($row = mysql_fetch_array($result)) {
                              if (!in_array($row['function_id'], $functions_id)) {
                              ?>
                                <tr onMouseOver="LmOverOut('fgroup_permissions', this, <?php echo $row['id']?>, '#33CC00', '66FFFF')"
                                  onMouseOut="LmOverOut('fgroup_permissions', this, <?php echo $row['id']?>, '', '#66FFFF')" onMouseDown="LmDown('fgroup_permissions', <?php echo $row['id']?>, this)">
                                  <td width="416px"><?php echo $row['name']?></td>
                                  <td width="60px" align="center">
                                    <input type="checkbox" name="<?php echo 'function_id'.$row['function_id']?>">
                                  </td>
                                </tr>
                              <?
                              }
                            }
                          ?>
                          </table>
                        </div>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
            <div align="center">Достъпни функции:</div>
            <table width="490px" align="center">
              <tr>
                <td>
                  <input type="hidden" name="data">
                  <table width="100%" border="1">
                    <tr>
                      <td width="418px">Наименование</td>
                      <td width="60px" align="center">Изтрий</td>
                      <td width="14">&nbsp;</td>
                    </tr>
                    <tr>
                      <td colspan="3">
                        <div style="height:200px; overflow-y:scroll;">
                          <table width="100%">
                          <?
                            $result = sql_q("SELECT MIN(p.id), MAX(p.id) FROM permissions p, functions f
                                                   WHERE p.function_id = f.function_id AND p.module_id = f.module_id
                                                   AND f.status = '1' AND p.module_id = '$module_id' AND p.group_id = '$group_id'");
                            $row = mysql_fetch_row($result);
                            ?><input type="hidden" name="min_permission_id" value="<?=$row[0]?>"><?
                            ?><input type="hidden" name="max_permission_id" value="<?=$row[1]?>"><?

                            $result = sql_q("SELECT p.id, p.read_access, f.name FROM permissions p, functions f
                                                   WHERE p.function_id = f.function_id AND p.module_id = f.module_id
                                                   AND f.status = '1' AND p.module_id = '$module_id'
                                                   AND p.group_id = '$group_id' ORDER BY p.module_id, p.function_id");
                            while ($row = mysql_fetch_array($result)) {
                            ?>
                              <tr onMouseOver="LmOverOut('fgroup_permissions', this, <?php echo $row['id']?>, '#33CC00', '66FFFF')"
                                onMouseOut="LmOverOut('fgroup_permissions', this, <?php echo $row['id']?>, '', '#66FFFF')" onMouseDown="LmDown('fgroup_permissions', <?php echo $row['id']?>, this)">
                                <td width="416px"><?php echo $row['name']?></td>
                                <td width="60px" align="center">
                                  <input type="checkbox" name="<?php echo 'permission_id'.$row['id']?>">
                                </td>
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
              </tr>
            </table>
          </fieldset>
        </td>
      </tr>
      <tr valign="bottom">
        <td height="10%" align="right">
          <input type="image" name="add" src="Images/Add.gif" border="0">
          <input type="image" name="exit" src="Images/Exit.gif" border="0" onclick="window.close(); return false">
        </td>
      </tr>
    </table>
  </form>
</body>
</html>

