<?
  include("../../inc/conf.php");

  $interest_mode = $_GET['interest_mode'];
  $variant = array('1' => 'А', '2' => 'Б', '3' => 'В', '4' => 'Г');

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

  <title>Изчисление на лихва</title>
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
                <legend>Изчисление на лихвата ще се извършва по <b>Вариант <?php echo $variant[$interest_mode];
                switch ($interest_mode)
                {
					case 1:
					echo "(проста лихва)";
					break;
					case 2: 
					echo "(капитализирана лихва)";
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
        <input type="submit" name="submit" value="Потвърждение">
        <input type="button" name="exit" value="Изход" onclick="window.close(); return false">
      </td>
    </tr>
  </table>
  </form>
</body>
</html>

