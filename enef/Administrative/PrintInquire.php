<?php
  switch ($_GET['id']) {
    case 1:
      include("../inc/conf.php");

      $ranges = "";
      $result = sql_q("SELECT * FROM ranges");
      while ($row = mysql_fetch_array($result)) {
        if ($_POST['range'.$row['nom_cod']]) { $ranges.=$row['nom_cod']." "; }
      }

    break;
    case 2:
    	$data_type = $_POST['data_type'];
    	$bulstat = $_POST['bulstat'];
    	$egn = $_POST['egn'];
    	$invoice_number = $_POST['invoice_number'];
    	$invoice_date = $_POST['invoice_date'];
  }
?>
<html>
<head>
  <title>Печат на справка</title>

  <meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
  <meta http-equiv="Content-Language" content="bg">
</head>
<script>
function Position(width, height)
{
    var screen_width = screen.width;
    var screen_height = screen.height;

    parent.top.resizeTo( width, height );
    parent.top.moveTo( ((screen_width-width)/2) , ((screen_height-height)/2) );
}
</script>
<body topmargin="0" leftmargin="0" marginwidth="0" marginheight="0" onload="self.moveTo(0,0); self.resizeTo(screen.availWidth, screen.availHeight);">
  <form name="fprint" method="post">
    <table width="100%" height="100%" border="0">
      <tr>
        <td height="90%">
        <?
          switch ($_GET['id']) {
            case 1:
            	?><iframe name="print_data" src="Inquiries/InquireRanges.php?ranges=<?=$ranges?>" width="100%" height="100%" marginwidth="0" marginheight="0" frameborder="no"></iframe><?
            break;
            case 2:
            	?><iframe name="print_data" src="Inquiries/InquireInvoiceInfo.php?data_type=<?=$data_type?>&bulstat=<?=$bulstat?>&egn=<?=$egn?>&invoice_number=<?=$invoice_number?>&invoice_date=<?=$invoice_date?>" width="100%" height="100%" marginwidth="0" marginheight="0" frameborder="no"></iframe><?
          }
        ?>
        </td>
      </tr>
      <tr>
        <td align="right">
          <hr width="100%">
          <input type="button" name="print" value="Печат" onclick="window.print_data.focus(); window.print(); window.close()">
          <input type="button" name="exit" value="Отказ" onclick="window.close()">
        </td>
      </tr>
    </table>
  </form>
</body>
</html>

