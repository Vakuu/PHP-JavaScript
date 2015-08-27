<?php
	include_once("../inc/conf.php");
?>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
  <meta http-equiv="Content-Language" content="bg">

  <title>Справка Системна информация за фактури</title>

  <script language="JavaScript" src="JFunctions.js"></script>
  <script language="JavaScript">
    var areAllSelected = 1;

    function changeflag(){
      if (areAllSelected == 0) {
        areAllSelected = 1;
      } else {
        areAllSelected = 0;
      }
    }

    function chooseSel() {
      changeflag();
      if (areAllSelected == 0) {
        selectAll();
      } else{
        deselectAll();
      }
    }

    function changePic(){
      if (areAllSelected == 0){
        document.printForm.img.src = "images/print.jpg"
      } else {
        document.printForm.img.src="images/arrDown.bmp"
      }
    }
  </script>
</head>
<script language = 'JavaScript' src = 'JFunctions.js'></script>
<body background="Images/Stone.jpg">
  <form action="PrintInquire.php?id=<?echo $_GET['id']?>" method=post name="printForm" >
    <fieldset>
      <legend><input type = 'radio' name = 'data_type' value = 'townsfolk' checked>&nbsp;Търсене по гражданин</legend>
      <table width="100%" border="0" >
        <tr>
          <td width = '30%' align = 'right'>ЕГН:&nbsp;</td>
          <td>
            <input type="text" name="egn" value="" mexlength = '10' onKeyPress="ValidateKeyNumb(this);">
          </td>
        </tr>
      </table>
    </fieldset>
    <br />
    <fieldset>
      <legend><input type = 'radio' name = 'data_type' value = 'company'>&nbsp;Търсене по ю. лице</legend>
      <table width="100%" border="0" >
        <tr>
          <tr>
          <td width = '30%' align = 'right'>БУЛСТАТ:&nbsp;</td>
          <td>
            <input type="text" name="bulstat" value="" maxlength = '13' onKeyPress="ValidateKeyNumb(this);">
          </td>
        </tr>
        </tr>
      </table>
    </fieldset>
    <br />
    <fieldset>
      <legend><input type = 'radio' name = 'data_type' value = 'invoice'>&nbsp;Търсене по документ</legend>
      <table width="100%" border="0" >
        <tr>
          <td width = '30%' align = 'right'>Номер:&nbsp;</td>
          <td><input type = 'text' name = 'invoice_number' value = '' maxlength = '10' onKeyPress = "ValidateKeyNumb(this);"></td>
        </tr>
        <tr>
          <td align = 'right'>Дата:&nbsp;</td>  
          <td>
            <input type='text' name='invoice_date' value='' onKeyPress='ValidateKeyNumb(this, "45");'>
          </td>
        </tr>
      </table>
    </fieldset>
    <table width="100%" border="0">
      <tr>
        <td align="right">
          <input type="submit" name="show" value="Покажи">
          <input type="button" name="exit" value="Изход" onclick="window.close();">
        </td>
      </tr>
    </table>
  </form>
</body>
</html>