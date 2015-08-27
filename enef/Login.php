<?
/*
 * Last modified: 2005.12.06 by Martin Lazarov
 *
 */
session_start();
if(empty($_SESSION['home_dir'])) $_SESSION['home_dir']=getcwd();
include("inc/conf.php");
function DisplayLogin(){
  global $logged_in,$js_alert;;  
  if ($logged_in) { 
    Header ("Location: Modules.php"); }
  else{
    ?>
      <html>
	<head>
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
  <meta http-equiv="Content-Language" content="bg">
    <title><?=SCREEN_W;?>x<?=SCREEN_H;?></title></head>
        <body background="Images/Stone.jpg" scroll="no" onload='flogin.username.focus()'>
          <form name="flogin" method="post" action="Index.php">
	
 <? echo $js_alert; ?>
<script>
   document.write("<input type=hidden name=screen_w value="+screen.width+">");
   document.write("<input type=hidden name=screen_h value="+screen.height+">");
</script>
            <table width="100%" height="100%" cellspacing="0" cellpadding="0" border=0>
              <tr height="30%">
                <td align="left">
                  <!--<img src="Images/BHS.gif">-->
                </td>
                <td align="center">
                  <!--<img src="Images/BHS_sign.gif"><br><br>
                  <img src="Images/System_sign.gif">-->
				  <u><b><font size="5" color=gray>Брайт Комплекс АТ </font></font><font size="6" color=gray>БК </font><font size="5" color=gray>Bright Complex AT</font></u></b><br><br>
                  <font size="5" color=gray><i><b><u>Регистър на сдружения на собственици в режим на етажна собственост</u></b></i></font>
                </td>
              </tr>
              <tr height="60%">
                <td valign="middle" colspan=2>
                  <table align="center" border="1" cellspacing="0" cellpadding="3">
                    <tr>
                      <th colspan="2" bgcolor="#629C73"><font color="#FFFFFF">Потребителска идентификация</font></th>
                    </tr>
                    <tr>
                      <td>Потребител:</td>
                      <td><input type="text" name="username" maxlength="30"></td>
                    </tr>
                    <tr>
                      <td>Парола:</td>
                      <td><input type="password" name="password" maxlength="30"></td>
                    </tr>
                    <tr>
                      <td colspan="2" align="right">
                        <input type="image" src="Images/LoginUp.gif" name="login" onmouseout="this.src='Images/LoginUp.gif'" onmouseover="this.src='Images/LoginDown.gif'">
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
              <tr height="10%" valign="bottom">
                <td colspan="2">
					<? include "footer.html";?>
                </td>
              </tr>
            </table>
          </form>
        </body>
      </html>
   <?
  }
}
####################################
if (isset($_POST['login_x'])){
  
  if(is_numeric($_POST['screen_w']) and is_numeric($_POST['screen_h'])){
    $_SESSION['SCREEN_H']=$_POST['screen_h'];
    $_SESSION['SCREEN_W']=$_POST['screen_w'];
  }
  
  if (!$_POST['username'] || !$_POST['password']){
    $js_alert.=js_alert('Полетата \\\'Потребител\\\' и \\\'Парола\\\' са задължителни за попълване!');
  } 
  else {
    $username=trim($_POST['username']);
    $result = ConfirmUser($username, md5($_POST['password']));
    if($result == 1) {
      logit("bad user name: $username");
      $js_alert.=js_alert('Потребителят не съществува в базата!');
    } elseif($result == 2) {
      logit("unactive user: $username");
      $js_alert.=js_alert('Потребителят е с неактивно състояние.\\n Обърнете се към системния администратор!');
    } elseif($result == 3) {
      logit("bad password! username=$username");
      $js_alert.=js_alert('Невалидна парола!');
    }
    $_SESSION['username'] = $username;
    $user_id=mysql_fetch_assoc(sql_q("select id, placement from users where username='$username'"));
    $_SESSION['user_id'] = $user_id['id'];
    $_SESSION['placement'] = $user_id['placement'];
    $_SESSION['password'] = md5($_POST['password']);
  }
  if(empty($js_alert)){
    logit("loged in");
    Header ("Location: Modules.php");
    //////////////////////////////////////////////////////////////
    ip_info($_SESSION['username']);
	///////////////////////////////////////////////////////////////	
    
    exit;
  }
}
$logged_in = checkLogin();

/* CHANGELOG
 * Преместване на всички функции от Login.php към inc/func.php /Martin Lazarov/
 * 2005.12.02 - добавяне на javascript за резолюцията на екрана /Martin Lazarov/
 * 2005.12.06 - добавен е colspan=2 към таблицата за логин, за да излезе в
 * центъра на страницата, а не леко в дясно. js alert-а вече се намира в тялото
 * на документа, а не преди <html> /Martin Lazarov/
 */ 
?>
