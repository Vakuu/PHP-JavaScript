<?php
    include("../inc/conf.php");

  $date = split("-", $_POST['from_date']);
  $from_date = $date[2]."-".$date[1]."-".$date[0];
  $date = split("-", $_POST['to_date']);
  $to_date = $date[2]."-".$date[1]."-".$date[0];

  if ($_POST['delete_x']) {
    $from_date = $_POST['from_date'];
    $to_date = $_POST['to_date'];

    $query = "SELECT invoice_id, doc_issue FROM invoices
              WHERE doc_state IN (1, 4)
              AND number = '0' AND date = '0000-00-00'
              AND doc_date BETWEEN '$from_date' AND '$to_date' 
              AND invoice_id NOT IN (SELECT invoice_id FROM rkk WHERE invoice_id>0) 
              ORDER BY invoice_id ASC";

    $result = sql_q($query);
    while ($row = mysql_fetch_array($result)) {
      if ($_POST[$row['invoice_id']] == 'on') {
        $invoice_id = $row['invoice_id'];

        sql_q("DELETE FROM invoices WHERE invoice_id = '$invoice_id'");
        switch ($row['doc_issue']) {
          case 1:
            sql_q("DELETE FROM month_payments WHERE invoice_id = '$invoice_id'");
          break;
          case 4:
          case 5:
          case 6:
          case 7:
          case 8:
            sql_q("DELETE FROM single_payments WHERE invoice_id = '$invoice_id'");
            sql_q("DELETE FROM townsfolk_less WHERE invoice_id = '$invoice_id'");
          break;
        }
      }
    }
  } else if ($_POST['home_x']) {
    echo "<script language='JavaScript'> top.main_window.location.href='Index.html'; </script>";
  }

  $query = "SELECT invoice_id, payee_mode, payee_identify, doc_state,
                   date_format(doc_date, '%d-%m-%Y'), total_amount, pay_mode
            FROM invoices
            WHERE doc_state IN (1, 4)
            AND number = '0' AND date = '0000-00-00'
            AND doc_date BETWEEN '$from_date' AND '$to_date' 
            AND invoice_id NOT IN (SELECT invoice_id FROM rkk WHERE invoice_id>0)
            ORDER BY invoice_id ASC";

  $result = sql_q($query);
?>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
  <meta http-equiv="Content-Language" content="bg">

  <script language="JavaScript" src="JFunctions.js"></script>
</head>
<body background="Images/Stone.jpg">
  <form name="fsingle_invoices" method="post">
    <input type="hidden" name="from_date" value="<?=$from_date?>">
    <input type="hidden" name="to_date" value="<?=$to_date?>">
    <table width="100%" height="100%">
      <tr valign="top">
        <td height="90%">
          <table width="758px" align="center">
            <tr>
              <td>
                <input type="hidden" name="data">
                <fieldset>
                  <legend>Създадени документи</legend>
                  <table width="100%" border="1">
                    <tr>
                      <td width="84px" align="center">Дата на създаване</td>
                      <td width="80px" align="center">Обща сума</td>
                      <td width="80px" align="center">Начин на плащане</td>
                      <td width="80px" align="center">Състояние</td>
                      <td width="314px" align="center">Получател</td>
                      <td width="20px" align="center">ОК</td>
                      <td width="14">&nbsp;</td>
                    </tr>
                    <tr>
                      <td colspan="7">
                        <div style="height:260px; overflow-y:scroll;">
                        <table width="100%">
                        <?
                          $buttons_flag = mysql_num_rows($result);

                          while ($row = mysql_fetch_array($result)) {
                          ?>
                            <tr onMouseOver="LmOverOut('fsingle_invoices', this, <? echo $row['invoice_id'].$row['doc_state']?>, '#33CC00', '66FFFF')"
                              onMouseOut="LmOverOut('fsingle_invoices', this, <? echo $row['invoice_id'].$row['doc_state']?>, '', '#66FFFF')" onMouseDown="LmDown('fsingle_invoices', <? echo $row['invoice_id'].$row['doc_state']?>, this)">
                              <td width="82px" align="right"><? echo $row["date_format(doc_date, '%d-%m-%Y')"] ?> </td>
                              <td width="80px" align="right"><? echo $row['total_amount']?></td>
                              <?
                                if ($row['pay_mode'] == 1) {
                                  $pay_mode = "в брой";
                                } else {
                                  $pay_mode = "по банков път";
                                }
                              ?>
                              <td width="80px" align="left"><? echo $pay_mode?></td>
                              <?
                                $result_elem = sql_q("SELECT * FROM elements WHERE nom_code = '29' ORDER BY cod_name ASC");
                                while ($row_elem = mysql_fetch_array($result_elem)) {
                                  if ($row_elem['cod_cod'] == $row['doc_state']) {
                                  ?><td width="80px" align="right"><? echo $row_elem['cod_name']?></td><?
                                  }
                                }
                                if ($row['payee_mode'] == 1) {
                                  if (empty($row['payee_identify'])) {
                                    $result_data = sql_q("SELECT name FROM townsfolk_less WHERE invoice_id = '$row[invoice_id]'");
                                  } else {
                                    $result_data = sql_q("SELECT name FROM townsfolk WHERE egn = '$row[payee_identify]'");
                                  }
                                } else {
                                  $result_data = sql_q("SELECT name FROM companies WHERE bulstat = '$row[payee_identify]'");
                                }
                                $row_data = mysql_fetch_array($result_data);
                              ?>
                              <td width="310px" align="left"><? echo $row_data['name']?></td>
                              <td width="22px" align="left">
                                <input type="checkbox" name="<?=$row['invoice_id']?>">
                              </td>
                            </tr>
                            <?
                          }
                          ?>
                          </table>
                        </div>
                      </td>
                    </tr>
                  </table>
                </fieldset>
              </td>
            </tr>
          </table>
        </td>
      </tr>
      <tr valign="bottom">
        <td height="10%" align="right">
        <?
          if ($buttons_flag > 0) {
          ?>
            <input type="image" name="delete" src="Images/Delete.gif" border="0"
              onclick="if (fgroups.data.value) {
                         if (!(ConfirmAction('Сигурни ли сте, че искате да изтриете маркирания запис?', 'Groups.php'))) { return false }
                       } else {
                         alert('Маркирайте запис, който желаете да изтриете!');
                         return false;
                       }">
          <?
          } else {
          ?>
            <input type="image" name="delete" src="Images/DeleteDisable.gif" border="0" disabled>
          <?
          }
        ?>
          <input type="image" name="home" src="Images/Home.gif" border="0">
        </td>
      </tr>
    </table>
  </form>
</body>
</html>

