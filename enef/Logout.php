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
    echo "<h2>������!</h2>\n";
    echo "������ ������� �� ���������� ������ �� �� ��������������. �� �������� ������� ��������� <b><a href=\"Index.php\">�������������</a></b>";
  } else {
      logit("logout");
      unset($_SESSION['username']);
      unset($_SESSION['password']);
      $_SESSION = array();
      session_destroy();

      echo "<h2><font color='#0E8130'><center>��� ��������� ��� ������� \"�������� �� ��������� �� ����������� � ����� �� ������ �����������\"<br> �� �������� ������.</center></font></h2>\n";
      echo "<center>���������� �� �� ���������� ���� �������. �� �� �������� ������ ��������� <b><a href=\"Index.php\">�������������</a></b></center>";
  }

mysql_close($connect);

echo "</body></html>";
?>
