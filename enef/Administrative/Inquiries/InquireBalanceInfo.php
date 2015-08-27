<?php
$user_id=$_GET['clerk_numb'];
$from_date=$_GET['from_date'];
$to_date=$_GET['to_date'];
if ($from_date!='00-00-0000' && $to_date!='00-00-0000'){
$date1 = split("[-]", $_GET['from_date']);
  $from_date = $date1[2]."-".$date1[1]."-".$date1[0];
  $date2 = split("[-]", $_GET['to_date']);
  $to_date = $date2[2]."-".$date2[1]."-".$date2[0];
 $from_date=$from_date." 00:00:00";
 $to_date=$to_date." 23:59:59";
}

function AddFractionPart($sum) {
    $sum_parts = split("[.]", $sum);
    $result = round($sum, 2);

    if (empty($result)) {
      $result = '0.00';
    } else {
      if (isset($sum_parts[1])) {
        if (strlen($sum_parts[1]) < 2) { $result = $sum."0"; } else { $result = $sum; }
      } else {
        $result = $sum.".00";
      }
    }
    return $result;
  } 
  
  include("../../inc/conf.php");

  $var_contr_data = $_GET['var_contr_data'];
  $edit_flag = $_GET['edit_flag'];
  $last=$_GET['last'];
 
    $contr_id = substr($var_contr_data, 6, strlen($var_contr_data) - 6);
    $month = substr($var_contr_data, 4, 2);
    $year = substr($var_contr_data, 0, 4);
  
  
 
  
  //if (!empty($edit_flag)) {
  //  $result = sql_q("SELECT SUM(final_balance) as final_balance FROM balances
                   //        WHERE contr_id = '$contr_id' AND ((year = '$year' AND month < '$month') OR year < '$year')");
  //  $row = mysql_fetch_array($result);

  //  $get_first_balance = $row['final_balance'];

?>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
  <meta http-equiv="Content-Language" content="bg">

  <title>История салдо</title>

  <script language="JavaScript" src="JFunctions.js"></script>
  <style type="text/css">
   
     
     
         body {size: 29.7cm 21cm; margin-left: 0cm; margin-right: 0.cm; margin-top: 0cm; margin-bottom: 0cm; }
      
   
    #table { border-color: black; border-style: dotted; border-width: 1 1 0 1 }

    td { border-width: 0 0 0 0; border-style: dotted; padding: 0px; font-size: 14px }
    td.bottom { border-width: 0 0 1px 0; }
    td.bottom1 { border-width: 0 0 1px 0; border-bottom-style: double;}
    td.left_bottom { border-width: 0 0 1px 1px; }
    td.left_bottom1 { border-width: 0 0 1px 1px; border-bottom-style: double;}
    
    @media screen
  {
  div.bb {visibility: visible;}
  }
@media print
  {
  div.bb {visibility: hidden;}
  }

  </style>
  </head>
<body  scroll="yes" >
 <table width="1120px" cellspacing="0" cellpadding="0"> 
        <tr>
        <?
          $result_data = sql_q("SELECT municipality, ifmuni FROM municipality");
          $row_data = mysql_fetch_array($result_data);
			$res_ifmuni = sql_q("SELECT * FROM elements WHERE nom_code = '65' and cod_cod='".$row_data['ifmuni']."'");
			$row_ifmuni = mysql_fetch_assoc($res_ifmuni);
			$ifmuni=$row_ifmuni['cod_name'];
        ?>
          <td width="650px"><u><i><?=$ifmuni?>:</i> <?php echo $row_data['municipality']?></u></td>
          <td width="170px" align="right"><u><i>Дата:</i> <?php echo date('d-m-Y')?></u></td>
        </tr>
      </table>
      
      <center><font color="blue"><b><i>Справка за извършени редакции на салда </b></i></font></center><br>
					<table border="1">
                    <tr>
                    <td width="80px" rowspan="2" class="bottom1">Потребител изв. редакция</td>
				    <td width="80px" rowspan="2" class="left_bottom">Време на редакция</td>
				    <td width="80px" rowspan="2" class="left_bottom">Причина за редакция</td>
				     <td width="80px" rowspan="2" class="left_bottom">Дог. №/дата</td>
				      <td width="10px" rowspan="2" class="left_bottom">пр./ след</td>
                    <td width="32px" class="left_bottom">&nbsp;</td>
                    <td width="34px" class="left_bottom">&nbsp;</td>
                    <td width="200px" colspan="3" class="left_bottom"><center><b>НАЕМ</b></center></td>
                    <td width="200px" colspan="3" class="left_bottom"><center><b>ЛИХВА</b></center></td>
                    <td width="200px" colspan="3" class="left_bottom"><center><b>НЕУСТОЙКА</b></center></td>
                    <td width="81px" class="left_bottom">&nbsp; </td>
                    <td width="81px" class="left_bottom">&nbsp; </td>
                    
				    </tr>
				    <tr>
				    
				    <td width="32px" align="center" class="left_bottom">Мес.</td>
                      <td width="34px" align="center" class="left_bottom">Год.</td>
                      <td width="81px" align="center" class="left_bottom">нач.</td>
                      <td width="81px" align="center" class="left_bottom">пл.</td>
                      <td width="81px" align="center" class="left_bottom"><font color="blue">дължим</font></td>
                      <td width="81px" align="center" class="left_bottom">нач.</td>
                      <td width="81px" align="center" class="left_bottom">пл.</td>
                      <td width="81px" align="center" class="left_bottom"><font color="blue">дължима</font></td>
                      <td width="81px" align="center" class="left_bottom">нач.</td>
                      <td width="81px" align="center" class="left_bottom">пл.</td>
                      <td width="81px" align="center" class="left_bottom"><font color="blue">дължима</font></td>
                      <td width="81px" align="center" class="left_bottom"><font color="red">Дължима сума за месеца</font></td>
                      <td width="81px" align="center" class="bottom">Надплатена сума</td>
                      
                    </tr>
                    <tr>
                      <td colspan="17">
                    <!--  <div style="height:300px; overflow-y:scroll;"> -->
                      <!--<table width="100%" border="1">-->
                         
                            
                            
                            
                    
<?  $q="SELECT b.*, c.contr_numb, c.contr_date FROM balances_history b , contracts c  WHERE b.contr_id=c.contr_id AND 
b.type_edit=3 ";
     if (!empty($user_id))
     {
		$q.=" AND b.user_id='$user_id'";
	}
	if ($from_date!='00-00-0000' && $to_date!='00-00-0000'){
		
		$q.=" AND b.timestamp>='$from_date' AND b.timestamp<='$to_date'";
		}
		
		
	$q.=" ORDER BY b.contr_id, b.year, b.month, b.timestamp";
//	echo $q;
    $result = sql_q($q);
    while ($row = mysql_fetch_array($result))
    {
    $contr_id=$row['contr_id'];
    $year = $row['year'];
    $month = $row['month'];
    $get_month_debt = $row['month_debt'];
    $get_month_pay = $row['month_pay'];
    $get_interest_debt = round($row['interest_debt'], 2);
    $get_interest_pay = $row['interest_pay'];
    $get_forfeit_debt = $row['forfeit_debt'];
    $get_forfeit_pay = $row['forfeit_pay'];
    $get_final_balance = $row['final_balance'];
    $get_prepay_amount = $row['prepay_amount'];
    $n=$row['invoice_id'];
    $user_id=$row['user_id'];
    $reason=$row['reason'];
    $timestamp=$row['timestamp'];
    $full_name_res=sql_q("SELECT full_name FROM users WHERE id='$user_id'");
    $full_name_row=mysql_fetch_row($full_name_res);
    $full_name=$full_name_row[0];
    
    ?>
    <tr>
    
    <td width="60px" align="center" rowspan="2" class="bottom1"><?php echo $full_name?></td>
    <td width="80px" align="center" rowspan="2" class="left_bottom1"><?php echo $timestamp?></td>
    <td width="80px" align="center" rowspan="2" class="left_bottom1"><?php echo $reason?></td>
    <td width="80px" align="center" rowspan="2" class="left_bottom1"><?php echo  $row['contr_numb']."/<br>". $row['contr_date']?></td>
    <td width="10px" align="center" class="left_bottom"><?php echo "П"?></td>
	<td width="32px" align="center" class="left_bottom"><?php echo $row['month']?></td>
    <td width="34px" align="center" class="left_bottom"><?php echo $row['year']?></td>
	 <td width="81px" align="center" class="left_bottom"><?php echo AddFractionPart(round(($row['month_debt']),2))?></td>
    <td width="81px" align="center" class="left_bottom"><?php echo AddFractionPart(round($row['month_pay'],2))?></td>
    <td width="81px" align="center" class="left_bottom"><font color="blue"><?php echo AddFractionPart(round(($row['month_debt'] - $row['month_pay']),2))?></font></td>
    <td width="81px" align="center" class="left_bottom"><?php echo AddFractionPart(round(($row['interest_debt']),2))?></td>
                                <td width="81px" align="center" class="left_bottom"><?php echo AddFractionPart(round($row['interest_pay'],2))?></td>
    <td width="81px" align="center" class="left_bottom"><font color="blue">
                                <?
                                 // $total_interest += round($row['interest_debt'], 2) - $row['interest_pay'];
                                  echo AddFractionPart(round($row['interest_debt'] - $row['interest_pay'], 2));
                                ?></font></td>
<td width="81px" align="center" class="left_bottom"><?php echo AddFractionPart(round(($row['forfeit_debt']),2))?></td>
<td width="81px" align="center" class="left_bottom"><?php echo AddFractionPart(round($row['forfeit_pay'],2))?></td>
<td width="81px" align="center" class="left_bottom"><font color="blue"><?php echo AddFractionPart(round(($row['forfeit_debt'] - $row['forfeit_pay']) ,2))?></font></td>
                                <td width="81px" align="center" class="left_bottom"><font color="red"><?php echo AddFractionPart(round(($row['final_balance']),2))?></font></td>
                                <td width="81px" align="center" class="left_bottom"><?php echo AddFractionPart(round(($row['prepay_amount']),2))?></td>
                                
                              </tr>
                              
                              
 <?
$res_next=sql_q("SELECT * FROM balances_history WHERE contr_id='$contr_id' AND year='$year' AND month='$month' AND timestamp > '$timestamp' LIMIT 1 ");
if (mysql_numrows($res_next)>0){
$row_next=mysql_fetch_array($res_next);
$year_next=$row_next['year'];
$month_next=$row_next['month'];
$fb_next=$row_next['first_balance'];
$md_next=$row_next['month_debt'];
$mp_next=$row_next['month_pay'];
$id_next=$row_next['interest_debt'];
$ip_next=$row_next['interest_pay'];
$fd_next=$row_next['forfeit_debt'];
$fp_next=$row_next['forfeit_pay'];
$fb_next=$row_next['final_balance'];
$pa_next=$row_next['prepay_amount'];

}
							 
else 
{
$res_next_b=sql_q("SELECT * FROM balances WHERE contr_id='$contr_id' AND year='$year' AND month='$month'  ");
$row_next_b=mysql_fetch_array($res_next_b);
$year_next=$row_next_b['year'];
$month_next=$row_next_b['month'];
$fb_next=$row_next_b['first_balance'];
$md_next=$row_next_b['month_debt'];
$mp_next=$row_next_b['month_pay'];
$id_next=$row_next_b['interest_debt'];
$ip_next=$row_next_b['interest_pay'];
$fd_next=$row_next_b['forfeit_debt'];
$fp_next=$row_next_b['forfeit_pay'];
$fb_next=$row_next_b['final_balance'];
$pa_next=$row_next_b['prepay_amount'];

}							 
							 
?> 
							  <tr>
							  <td width="10px" align="center" class="left_bottom1"><?php echo "С"?></td>
                              <td width="32px" align="center" class="left_bottom1"><?php echo $month_next?></td>
    <td width="34px" align="center" class="left_bottom1"><?php echo $year_next?></td>
	 <td width="81px" align="center" class="left_bottom1"><?php echo AddFractionPart(round(($md_next),2))?></td>
    <td width="81px" align="center" class="left_bottom1"><?php echo AddFractionPart(round($mp_next,2))?></td>
    <td width="81px" align="center" class="left_bottom1"><font color="blue"><?php echo AddFractionPart(round(($md_next - $mp_next),2))?></font></td>
    <td width="81px" align="center" class="left_bottom1"><?php echo AddFractionPart(round(($id_next),2))?></td>
                                <td width="81px" align="center" class="left_bottom1"><?php echo AddFractionPart(round($ip_next,2))?></td>
    <td width="81px" align="center" class="left_bottom1"><font color="blue">
                                <?
                                 // $total_interest += round($row['interest_debt'], 2) - $row['interest_pay'];
                                  echo AddFractionPart(round($id_next - $ip_next, 2));
                                ?></font></td>
<td width="81px" align="center" class="left_bottom1"><?php echo AddFractionPart(round(($fd_next),2))?></td>
<td width="81px" align="center" class="left_bottom1"><?php echo AddFractionPart(round($fp_next,2))?></td>
<td width="81px" align="center" class="left_bottom1"><font color="blue"><?php echo AddFractionPart(round(($fd_next - $fp_next) ,2))?></font></td>
                                <td width="81px" align="center" class="left_bottom1"><font color="red"><?php echo AddFractionPart(round(($fb_next),2))?></font></td>
                                <td width="81px" align="center" class="left_bottom1"><?php echo AddFractionPart(round(($pa_next),2))?></td>
                              </tr>
	
	<?
	}
    ?>
    <!-- </table>-->
                       <!-- </div>-->
                      </td>
                    </tr>
                    </table>

        
      
      
  <font size="-2">Справката е генерирана от система Е-община на фирма "Брайт Комплекс АТ" ЕООД.</font>
  
  <div align="right" class="bb">  <input type="button" onclick="window.print();" value="Печат">&nbsp;&nbsp;&nbsp;<input type="button" onclick="window.close();" value="Изход">  </div>
       
</body>
</html>

