<?php
  include("../../inc/conf.php");

  $id = $_GET['data'];

  if ($_POST['add_x']) {
    $name = $_POST['name'];
    $date_from1 =explode("-", $_POST['date_from']);
    $date_to1= explode("-", $_POST['date_to']);
    $date_from =$date_from1[2]."-".$date_from1[1]."-".$date_from1[0];
    $date_to=$date_to1[2]."-".$date_to1[1]."-".$date_to1[0];
  
    $password = md5($new_password);
    if ($_GET['edit_flag'] == 1) {
      $id = $_POST['id'];

      $query = "UPDATE mayors SET name='".$name."', date_from='".$date_from."', date_to='".$date_to."'";
     

      sql_q($query);
    }
    else {
     // $user_flag = 0;

      //$result = sql_q("SELECT username, password FROM users");
     // while ($row = mysql_fetch_array($result)) {
      //  if ($row['username'] == $username) {
      //    $user_flag = 1;
      //    break;
      //  }
    //  }

    //  if (empty($user_flag)) {
        sql_q("INSERT INTO mayors VALUES('NULL', '$name', '$date_from', '$date_to')");
    //  } else {
    //    echo "<script language='JavaScript'>alert('Такъв потребител вече е бил въведен!')</script>";
     // }
    }
    ?>
      <script language="JavaScript">
        window.close();
        window.opener.location.href="Mayors.php";
        
      </script>
    <?
  }

  $result = sql_q("SELECT id, name, date_format(date_from , '%d-%m-%Y') AS date_from, date_format(date_to , '%d-%m-%Y') as date_to  FROM mayors WHERE id = '$id'");
  $row = mysql_fetch_array($result);
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

  <title><?=$ifmayor?></title>

  <script language="JavaScript" src="../JFunctions.js"></script>
</head>
<body background="../Images/Stone.jpg" onload="fmayors_data.name.focus()">
  <form name="fmayors_data" action="Mayors_data.php?edit_flag=<?=$_GET['edit_flag']?>" method="post">
    <table width="100%" height="100%">
      <tr valign="top">
        <td height="90%">
          <input type="hidden" name="id" value="<?=$id?>">
          <input type="hidden" name="get_edit_flag" value="<?=$_GET['edit_flag']?>">
          <fieldset>
            <legend>Данни за <?=$ifmayor?></legend>
            <table width="100%" height="80%" border="1">
              <tr>
                <td width="40%">Име:</td>
                <td width="60%">
                  <input type="text" name="name" size="39%" maxlength="100" value="<?=htmlspecialchars($row['name'], ENT_QUOTES)?>">
                </td>
              </tr>
              <tr>
                <td>Начална дата на управление:</td>
                <td>
                  <input type="text" name="date_from" size="19%" maxlength="12" value="<?=htmlspecialchars($row['date_from'], ENT_QUOTES)?>" >
                </td>
              </tr>
              <tr>
                <td>Крайна дата на управление:</td>
                <td>
                  <input type="text" name="date_to" size="19%" maxlength="12" value="<?=htmlspecialchars($row['date_to'], ENT_QUOTES)?>">
                </td>
              </tr>
              
              
              
            </table>
          </fieldset>
        </td>
      </tr>
      <tr valign="bottom">
        <td height="10%" align="right">
          <input type="image" name="add" src="../Images/Add.gif" border="0" onclick="return VerifyValidData('fmayors_data'); return false;">
          <input type="image" name="exit" src="../Images/Exit.gif" border="0" onClick="window.close()">
        </td>
      </tr>
    </table>
  </form>
</body>
</html>

