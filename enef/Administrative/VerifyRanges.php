<?
  include("../inc/conf.php");
?>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
  <meta http-equiv="Content-Language" content="bg">

  <title>Справка Номенклатури</title>

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

    function selectAll() {
    <?
      $result = sql_q("SELECT * FROM ranges");
      while ($row = mysql_fetch_array($result)) {
      ?>document.printForm.<?echo "range".$row[nom_cod]?>.checked="checked";<?
      }
    ?>
    }

    function deselectAll() {
    <?
      $result = sql_q("SELECT * FROM ranges");
      while ($row = mysql_fetch_array($result)) {
      ?> document.printForm.<?echo "range".$row[nom_cod]?>.checked=""; <?
      }
    ?>
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
<body background="Images/Stone.jpg">
  <form action="PrintInquire.php?id=<?echo $_GET['id']?>" method=post name="printForm" >
    <fieldset>
      <legend>Номенклатури</legend>
      <table width="100%" border="1" >
        <tr>
          <td width="12px">№</td>
          <td width="360px">Име на номенклатура</td>
          <td width="12px align='center'">
            <input type="submit" name="img" value=" V " onclick="chooseSel();return false;">
          </td>
          <td width="8px">&nbsp;</td>
        </tr>
      </table>
      <div style="height:300px; overflow-y:scroll;">
        <table width="100%" border="1" height="90%">
        <?
          $result = sql_q("SELECT * FROM ranges");
          while ($row = mysql_fetch_array($result)) {
          ?>
            <tr>
              <td width="10px"><? echo $row['nom_cod']; ?></td>
              <td width="350px">&nbsp; <?echo $row['nom_name']; ?></td>
              <td width="10px align='center'">
                <input type="checkbox" name="<?echo "range".$row[nom_cod]?>">
              </td>
            </tr>
          <?
          }
        ?>
        </table>
      </div>
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




