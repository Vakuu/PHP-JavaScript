<?php
  include("../inc/conf.php");

  $current_date = date("d-m-Y");
?>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
  <meta http-equiv="Content-Language" content="bg">

  <title>����� �� ��������</title>

  <script language="JavaScript" src="JFunctions.js"></script>
</head>
<body background="Images/Stone.jpg" onload="fsearch_delete_period.from_date.focus()">
  <form name="fsearch_delete_period" action="DocumentsDelete.php" target="main_window" method="post" onsubmit="window.close()">
    <center><font size="4" color="blue">����� �� �������� �� �������</font></center>
    <table width="100%" height="94%">
      <tr valign="top">
        <td height="90%">
          <table align="center" width="100%" border="1">
            <tr>
              <td width="34%">������:</td>
              <td width="64%">
                �� <input type="text" name="from_date" style="width:37%" value="<?=$current_date?>">&nbsp;
                �� <input type="text" name="to_date" style="width:37%" value="<?=$current_date?>">
              </td>
            </tr>
          </table>
        </td>
      </tr>
      <tr valign="bottom">
        <td height="10%" align="right">
          <input type="submit" name="search" value="�������" onclick="return VerifyValidData('fsearch_delete_period')">
          <input type="button" name="exit" value="�����" onclick="window.close()">
        </td>
      </tr>
    </table>
  </form>
</body>
</html>

