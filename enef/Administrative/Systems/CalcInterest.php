<?
  include("../../inc/conf.php");

  $interest_mode = $_GET['interest_mode'];
  $variant = array('1' => '�', '2' => '�', '3' => '�', '4' => '�');

if (isset($_POST['submit']))
{
	//echo "UPDATE municipality SET interest_mode = '$interest_mode'";
  sql_q("UPDATE municipality SET interest_mode = '$interest_mode'");
  echo "<script language='JavaScript'> window.close(); window.opener.location.reload();</script>";
 
  }
?>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
  <meta http-equiv="Content-Language" content="bg">

  <title>���������� �� �����</title>
</head>
<body background="../Images/Stone.jpg">
<form name="finterest" method="post" action="CalcInterest.php?interest_mode=<?echo $interest_mode?>">
  <table width="100%" height="100%">
    <tr valign="top">
      <td height="90%">
        <table width="100%" border="0">
          <tr>
            <td>
              <fieldset>
                <legend>���������� �� ������� �� �� �������� �� <b>������� <?php echo $variant[$interest_mode];
                switch ($interest_mode)
                {
					case 1:
					echo "(������ �����)";
					break;
					case 2: 
					echo "(�������������� �����)";
					break;
					
				}
				
				
				?></b></legend>
              </fieldset>
            </td>
          </tr>
        </table>
      </td>
    </tr>
    <tr valign="bottom">
      <td height="10%" align="center">
        <input type="submit" name="submit" value="������������">
        <input type="button" name="exit" value="�����" onclick="window.close(); return false">
      </td>
    </tr>
  </table>
  </form>
</body>
</html>

