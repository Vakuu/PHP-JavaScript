<?php
  include("../inc/conf.php");

   $id_accounts = $_GET['id_accounts'];

  if ($_POST['add_x']) {
    $name_accounts = $_POST['name_accounts'];
    $number = $_POST['number'];
    $iban = $_POST['iban'];
    $bic = $_POST['bic'];
    $bank_name = $_POST['bank_name'];
	$bank_branch = $_POST['bank_branch'];
    $bank_address = $_POST['bank_address'];
    $status = $_POST['status'];
    if ($_POST['main']=="on")
    $main = 1;
    else $main=0;


    if ($_GET['edit_flag'] == 1) {
      $id_accounts = $_POST['id_accounts'];

      sql_q("UPDATE accounts_municipality SET name_accounts = '$name_accounts', number = '$number',iban='$iban',bic='$bic', bank_name='$bank_name', bank_branch='$bank_branch', bank_address = '$bank_address', status = '$status', main='$main' WHERE id_accounts = '$id_accounts'");
    }
    else {
      sql_q("INSERT INTO accounts_municipality (id_accounts, name_accounts, number, iban, bic, bank_name, bank_branch, bank_address, status, main) VALUES('NULL', '$name_accounts', '$number',  '$iban', '$bic', '$bank_name', '$bank_branch', '$bank_address', '$status', '$main')");
    }
    if ($main ==1)
    {
    sql_q("UPDATE accounts_municipality SET main=0 WHERE id_accounts!='$id_accounts'");
    }
    ?>
      <script language="JavaScript">
        window.close();
        window.opener.location.href="Accounts.php";
      </script>
    <?
  }

  $result = sql_q("SELECT * FROM accounts_municipality WHERE id_accounts = '$id_accounts'");
  $row = mysql_fetch_array($result);
?>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
  <meta http-equiv="Content-Language" content="bg">

  <title>Сметки</title>

  <script language="JavaScript" src="JFunctions.js"></script>
</head>
<body background="Images/Stone.jpg" onload="fgroups_data.name.focus()">
  <form name="faccounts_data" action="Accounts_data.php?edit_flag=<?=$_GET['edit_flag']?>" method="post">
    <table width="100%" height="100%">
      <tr valign="top">
        <td height="90%">
          <input type="hidden" name="id_accounts" value="<?=$id_accounts?>">
          <fieldset>
            <legend>Данни за сметка</legend>
           <div style="height:420px; overflow-y:scroll;">
              <table align="center" width="100%" height="80%" border="1">
                
               
                <tr>
                  <td align="right">Наименование на сметка:</td>
                  <td><input type="text" name="name_accounts" size="40%" maxlength="40" value="<?=$row['name_accounts']?>" onKeyPress="ValidateKeyChar(this)"></td>
                </tr>
                
                <tr>
                  <td align="right">Номер(сметкоплан):</td>
                  <td><input type="text" name="number" size="40%" maxlength="25" value="<?=htmlspecialchars($row['number'])?>"></td>
                </tr>
                <tr>
                  <td align="right">Банка:</td>
                  <td><input type="text" name="bank_name" size="40%" maxlength="50" value="<?=htmlspecialchars($row['bank_name'])?>"></td>
                </tr>
                <tr>
                  <td align="right">Банкoв клон:</td>
                  <td><input type="text" name="bank_branch" size="40%" maxlength="30" value="<?=htmlspecialchars($row['bank_branch'])?>"></td>
                </tr>
                <tr>
                  <td align="right">Банкoв адрес:</td>
                  <td><input type="text" name="bank_address" size="40%" maxlength="50" value="<?=htmlspecialchars($row['bank_address'])?>"></td>
                </tr>
                <tr>
                  <td align="right">BIC:</td>
                  <td>
                  <?
                    if (empty($row['bic'])) {
                      $get_bank_code = "";
                    } else {
                      $get_bank_code = $row['bic'];
                    }
                  ?>
                    <input type="text" name="bic" size="40%" maxlength="8" value="<?=$get_bank_code?>">
                  </td>
                </tr>
                <tr>
                  <td align="right">IBAN:</td>
                  <td>
                  <?
                    if (empty($row['iban'])) {
                      $get_bank_account = "";
                    } else {
                      $get_bank_account = $row['iban'];
                    }
                  ?>
                    <input type="text" name="iban" size="40%" maxlength="22" value="<?=$get_bank_account?>">
                  </td>
                </tr>
                 
                <tr>
                <td align="right">Статус:</td>
                <td>
                  <select name="status" size="1" style="width:85%">
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
               <tr>
                  <td align="right">Основна сметка:</td>
                  <? //echo $row['main'];
				  if ($row['main'] == 1) {?>
                  <td><input type="checkbox" name="main" checked >Да</td>
                  <?} else {?>
                  <td><input type="checkbox" name="main" >Да</td>
                  <?}?>
                </tr> 
                
              </table>
            </div>
          </fieldset>
        </td>
      </tr>
      <tr valign="bottom">
        <td height="10%" align="right">
          <input type="image" name="add" src="Images/Add.gif" border="0" onclick="return VerifyValidData('faccounts_data')">
          <input type="image" name="exit" src="Images/Exit.gif" border="0" onClick="window.close()">
        </td>
      </tr>
    </table>
  </form>
</body>
</html>

