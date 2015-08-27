<?
 include("../../inc/conf.php");

 $ranges = $_GET['ranges'];
 $splitter = " ";
 $rangesarr = split($splitter, $_GET['ranges']);
 $counti = count($rangesarr);
?>
<html>
  <head>
    <title>Печат на справка</title>

    <meta http-equiv="content-type" content="text/html; charset=windows-1251">
    <meta name="generator" content="HAPedit 3.0">

    <style type="text/css">
      #table { border-color: black; border-style: dotted; border-width: 1 1 0 1 }

      td { border-width: 0 0 0 0; border-style: dotted; padding: 0px; font-size: 14px }
      td.bottom { border-width: 0 0 1px 0; }
      td.left_bottom { border-width: 0 0 1px 1px; }
      td.left { border-width: 0 0 0 1px; }
    </style>
  </head>
<body bgcolor="#FFFFFF">
  <table width="600px" cellspacing="0" cellpadding="0">
    <tr><td> &nbsp; </td></tr>
    <tr>
    <?
      //$result_data = sql_q("SELECT municipality, ifmuni FROM municipality");
      //$row_data = mysql_fetch_array($result_data);
      //$res_ifmuni = sql_q("SELECT * FROM elements WHERE nom_code = '65' and cod_cod='".$row_data['ifmuni']."'");
			//$row_ifmuni = mysql_fetch_assoc($res_ifmuni);
			//$ifmuni=$row_ifmuni['cod_name'];
    ?>
      <td width="150px"><u><i><?=$ifmuni?>:</i> <?php echo $row_data['municipality']?></u></td>
      <td width="300px" align="center" valign="middle"><font color="blue"><b><i>Справка Номенклатури</i></b></font></td>
      <td width="150px" align="right"><u><i>Дата:</i> <?php echo date('d-m-Y')?></u></td>

    </tr>
    <tr><td> &nbsp; </td></tr>
  </table>
  <table id="table" width="600px" border="0" cellspacing="0" cellpadding="1">
    <tr>
      <td width="50px" align="right">&nbsp;№ &nbsp;</td>
      <td class="left" width=550px>&nbsp;Наименование&nbsp;</td>
    </tr>
  </table>
  <table id="table" width=600px border="0" cellspacing="0" cellpadding="0">
  <?
    for ($i = 0; $i < $counti; $i++) {
    ?>
      <tr>
      <?
        $temp = sql_q("SELECT * FROM ranges WHERE nom_cod=".$rangesarr[$i]) ;
        $rangeout = mysql_fetch_array($temp);
      ?>
        <td class="bottom" colspan="2">
          <font size="3" color="#0000FF"><?echo $rangeout[1]?></font>
        </td>
      </tr>
      <tr>
      <?
        $res = sql_q("SELECT cod_cod, cod_name FROM elements WHERE nom_code=".$rangesarr[$i]);
        for($j = 0; $j < mysql_num_rows($res); $j++) {
          $r = mysql_fetch_array($res);
          ?>
            <td class="bottom" align="right" width="50px"><?echo $r[0];?>  &nbsp;</td>
            <td class="left_bottom" width="550px">&nbsp; <?echo $r[1];?></td>
          </tr>
          <?
        }
    }
  ?>
  </table>
</body>
</html>

