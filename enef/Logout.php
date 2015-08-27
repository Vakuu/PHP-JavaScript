<?php
include('inc/conf.php');
include("Login.php");
echo "<html>";
?>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<meta http-equiv="Content-Language" content="bg">
  <?
echo "<body background='Images/Stone.jpg'>";

if (!$logged_in) {
    logit("logout ERR:01");
    echo "<h2>Грешка!</h2>\n";
    echo "Веднъж излезли от програмата трябва да се идентифицирате. За повторно влизане натиснете <b><a href=\"Index.php\">Идентификация</a></b>";
  } else {
      logit("logout");
      unset($_SESSION['username']);
      unset($_SESSION['password']);
      $_SESSION = array();
      session_destroy();

      echo "<h2><font color='#0E8130'><center>Вие работихте със система \"Регистър на сдружения на собственици в режим на етажна собственост\"<br> на Столична община.</center></font></h2>\n";
      echo "<center>Излизането Ви от програмата беше успешно. За да влезнете отново натиснете <b><a href=\"Index.php\">Идентификация</a></b></center>";
  }

mysql_close($connect);

echo "</body></html>";
?>
