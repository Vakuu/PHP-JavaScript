<?php
  include("../inc/conf.php");

  $user_id = $_GET['user_data'];
  $all= $_REQUEST['all'];

  if ($_POST['add_x']) {
    $username = $_POST['username'];
    $new_password = trim($_POST['new_password']);
    $confirm_password = trim($_POST['confirm_password']);
    $full_name = $_POST['full_name'];
    $placement = $_POST['placement'];//Petko Mihailov Dobaveno vuv vruzka na kasieri s naseleni mesta 
    $email = $_POST['email'];
    $status = $_POST['status'];

    $password = md5($new_password);
    if ($_GET['edit_flag'] == 1) {
      $user_id = $_POST['user_id'];

      $query = "UPDATE users SET username = '".$username."'";
      if (!empty($new_password)) { $query .= ", password = '".$password."'"; }
      $query .= ", full_name = '".$full_name."', email = '".$email."',placement='".$placement."', status = '".$status."' WHERE id = '".$user_id."'";
	sql_q($query);	
		//////////////da se deaktiwira avtomati`no kato izpylnitel i rezolira6t/////////////////
		if ($status==0)
		{
			//sql_q("UPDATE executors SET exe_active=2 WHERE user_id= '".$user_id."'");
			//sql_q("UPDATE resolvers SET res_active=2 WHERE user_id= '".$user_id."'");
		}
     // sql_q($query);
    }
    else {
      $user_flag = 0;

      $result = sql_q("SELECT username, password FROM users");
      while ($row = mysql_fetch_array($result)) {
        if ($row['username'] == $username) {
          $user_flag = 1;
          break;
        }
      }

      if (empty($user_flag)) {
        sql_q("INSERT INTO users(`username`,`password`,`full_name`,`placement`,`email`,`status`) VALUES('$username', '$password', '$full_name','$placement', '$email', '$status')");   
      } else {
        echo "<script language='JavaScript'>alert('Такъв потребител вече е бил въведен!')</script>";
      }
    }
    ?>
      <script language="JavaScript">
        window.close();
        window.opener.location.href="Users.php?all=<?=$all?>";
      </script>
    <?
  }

  $result = sql_q("SELECT username, full_name, email, placement, status FROM users WHERE id = '$user_id'");
  $row = mysql_fetch_array($result);
?>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
  <meta http-equiv="Content-Language" content="bg">

  <title>Потребител</title>

  <script language="JavaScript" src="JFunctions.js"></script>
</head>
<body background="Images/Stone.jpg" onload="fusers_data.username.focus()">
  <form name="fusers_data" action="UsersData.php?edit_flag=<?=$_GET['edit_flag']?>" method="post">
    <table width="100%" height="100%">
      <tr valign="top">
        <td height="90%">
          <input type="hidden" name="user_id" value="<?=$user_id?>">
          <input type="hidden" name="get_edit_flag" value="<?=$_GET['edit_flag']?>">
          <input type="hidden" name="all" value="<?=$all?>">
          <fieldset>
            <legend>Данни за потребител</legend>
            <table width="100%" height="80%" border="1">
              <tr>
                <td width="40%">Потребител:</td>
                <td width="60%">
                  <input type="text" name="username" size="19%" maxlength="12" value="<?=htmlspecialchars($row['username'], ENT_QUOTES)?>">
                </td>
              </tr>
              <tr>
                <td>Нова парола:</td>
                <td>
                  <input type="password" name="new_password" size="19%" maxlength="12">
                </td>
              </tr>
              <tr>
                <td>Потвърди паролата:</td>
                <td>
                  <input type="password" name="confirm_password" size="19%" maxlength="12">
                </td>
              </tr>
              <tr>
                <td>Име:</td>
                <td>
                  <input type="text" name="full_name" style="width:100%" maxlength="100" value="<?=$row['full_name']?>">
                </td>
              </tr>
              <tr>
                <td>Е-майл адрес:</td>
                <td>
                  <input type="text" name="email" size="30%" maxlength="25" value="<?=$row['email']?>" onkeypress="ValidateKeyCharNumb(this, 46, 64, 45, 95)">
                </td>
              </tr>
            <tr>
                <td>Район:</td>
                <td>
                  <select name="placement">
                <option value="25"></option>
                <?php $raion = "SELECT show_cod, region_name FROM regions ORDER BY show_cod ASC"; //Petko Mihailov-programist Dobaveno vuv vruzka na kasieri s naseleni mesta
                $get_code_name =sql_q($raion);
                while( $row2=mysql_fetch_array($get_code_name))
                {
                 if($row['placement']==$row2['show_cod']){
                    $selected = ' selected';
                    }else{
                        $selected='';
                    }
                 
                 echo "<option value ='".$row2['show_cod']."' ".$selected.">".$row2['region_name']."</option>";   
                }
                
                //$get_placement = "select placement from users where id='".$user_id."'";
               // $placenemt = sql_q($get_placement);
                
                
                
                
                ?>
                </select>
                </td>
              </tr>
              
              <tr>
                <td>Състояние:</td>
                <td>
                  <select name="status" size="1" style="width:54%">
                  <?
                    if (empty($row['status'])) {
                    ?>
                      <option value="0" selected>Неактивен</option>
                      <option value="1">Активен</option>
                    <?
                    } else {
                    ?>
                      <option value="0">Неактивен</option>
                      <option value="1" selected>Активен</option>
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
          <input type="image" name="add" src="Images/Add.gif" border="0" onclick="return VerifyValidData('fusers_data')">
          <input type="image" name="exit" src="Images/Exit.gif" border="0" onClick="window.close()">
        </td>
      </tr>
    </table>
  </form>
</body>
</html>

