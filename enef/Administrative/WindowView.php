<?
  session_start();
?>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
  <meta http-equiv="Content-Language" content="bg">

  <title>Администратор</title>
</head>
<body bgcolor="#FFFFFF" text="BLACK" background="Images/Stone.jpg" scroll="no">
  <table width="100%" height="100%">
    <tr height="30%">
      <td>
        <!--<img src="Images/BHS.gif" align="left">-->
      </td>
      <td align="center">
        <img src="Images/Header.gif"><br><br>
        <script src="MenuJScript/xaramenu.js"></script>
        <?require "MenuJScript/CreateMenus.php";?>
      </td>
    </tr>
    <tr height="60%">
      <td valign="center"  width="5%">
        <img src="Images/Arquette.gif"><br>
        <input type="image" src="Images/ModulesUp.gif" onmouseout="this.src='Images/ModulesUp.gif'" onmouseover="this.src='Images/ModulesDown.gif'" onclick="location.href='../Modules.php'"><br>
        <input type="image" src="Images/LogoutUp.gif" onmouseout="this.src='Images/LogoutUp.gif'" onmouseover="this.src='Images/LogoutDown.gif'" onclick="location.href='../Logout.php'"><br>
        <img src="Images/Arquette.gif">
      </td>
      <td align="center">
        <center>
				  <u><b><img src="images/so.gif" width="150" height="175"/></center><font size="5" color=gray>Столична община</font></b><br><br>
            </td>
		</td>
    </tr>
    <tr height="10%" valign="bottom">
		<td colspan="2">
			<?php require_once "../footer.html"; ?>
<!--        <marquee direction="left"><font size="2" color="#0E8130">град София, ж.к."Дървеница" бл.48 (до вход А), е-mail:office@bhsbg.com, Internet адрес: http://www.bhsbg.com</font></marquee> -->
      </td>
    </tr>
  </table>
</body>
</html>