<?php
    include("../inc/conf.php");
    $id = $_GET['id'];

  switch ($id) {
    case 8:
      $build_identify = $_POST ['build_identifyh'];	
	  $raion = $_POST['raion_sel'];
      $hood = $_POST['hood_sel'];
      $jk = $_POST['jk_sel'];
      $nasel = $_POST['nasel_sel'];
      $build_numb = $_POST['build_numb'];
      $asoc_numb = $_POST['asoc_numbh'];
      $bulstat  = $_POST['bulstath'];
      $asoc_name = $_POST['asoc_name'];
      $status = $_POST['status'];
    break;
	case 9: 
		$ident = $_POST['ident_num'];
		$ident2 = $_POST['ident_num_a'];
        $jk = $_POST['jk_sel'];
        $nasel = $_POST['nasel_sel'];
        $raion_sel = $_POST['raion_sel'];
		$kv = $_POST['hood_sel'];
		$ss1 = $_POST['ss1'];
		$zifp1 = $_POST['zifp1'];
		$zifp2 = $_POST['zifp2'];
		$ss2 = $_POST['ss2'];
	break;
	case 10:
		$raion_sel = $_POST['raion_sel'];
		$kv = $_POST['hood_sel'];
	break;
   
    case 11:
      $build_identify = $_POST ['build_identifyh'];	
	  $raion = $_POST['raion_sel'];
      $hood = $_POST['hood_sel'];
      $jk = $_POST['jk_sel'];
      $nasel = $_POST['nasel_sel'];
      $build_numb = $_POST['build_numb'];
      $asoc_numb = $_POST['asoc_numbh'];
      $bulstat  = $_POST['bulstath'];
      $asoc_name = $_POST['asoc_name'];
      $status = $_POST['status'];
    break;
    }
?>
<html>
<head>
  <title>Печат на справка</title>

  <meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
  <meta http-equiv="Content-Language" content="bg">
<!--  ********** added  ******** -->
<script src="js/table2Excel.js"></script>
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
            case 8:
            ?><iframe name="print_data" src="Inquiries/InquireContracts.php?build_identify=<?=$build_identify?>&raion=<?=$raion?>&hood=<?=$hood?>&nasel=<?=$nasel?>&jk=<?=$jk?>&build_numb=<?=$build_numb?>&asoc_numb=<?=$asoc_numb?>&bulstath=<?=$bulstat?>&asoc_name=<?=$asoc_name?>&status=<?=$status?>" width="100%" height="100%"%" marginwidth="0" marginheight="0" frameborder="no"></iframe><?
            break;
            case 9:
            ?><iframe name="print_data" src="Inquiries/InquireAsoc.php?build_identify=<?=$ident?>&raion=<?=$raion_sel?>&hood=<?=$kv?>&nasel=<?=$nasel?>&jk=<?=$jk?>&asoc_numb=<?=$ident2?>" width="100%" height="100%" marginwidth="0" marginheight="0" frameborder="no"></iframe><?
            break;
			case 10:
            ?><iframe name="print_data" src="Inquiries/InquireMuniDocs.php?sel_rai=<?=$raion_sel?>&kv=<?=$kv?>" width="100%" height="100%" marginwidth="0" marginheight="0" frameborder="no"></iframe><?
            break;
            case 11:
            ?><iframe name="print_data" src="Inquiries/InquireContr.php?build_identify=<?=$build_identify?>&raion=<?=$raion?>&hood=<?=$hood?>&nasel=<?=$nasel?>&jk=<?=$jk?>&build_numb=<?=$build_numb?>&asoc_numb=<?=$asoc_numb?>&bulstath=<?=$bulstat?>&asoc_name=<?=$asoc_name?>&status=<?=$status?>" width="100%" height="100%" marginwidth="0" marginheight="0" frameborder="no"></iframe><?
            break;
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

