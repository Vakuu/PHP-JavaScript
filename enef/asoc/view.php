<?php
   include ("../inc/conf.php");
   
   function srok($d, $m, $y)
{
	$nachalo=mktime(0,0,0,$m,$d,$y);
	$krai=$nachalo+691200;
	$vidimo_na=date("Y-m-d",$krai);
	return $vidimo_na;
}
?>
<html>
   <head>
   	<style>
table.small
{	line-height: 1.2; font-size: 11pt;
}
</style>
      <title>ДЕТАЙЛЕН ПРЕГЛЕД</title>
      
   </head>
   <body bgcolor="#FFFFFF" text="BLACK" background="templates/images/Stone.jpg">
      <script language="JavaScript" src="templates/script/JFunctions.js"></script>
      <?php
         if ($_GET['edit']) {
            $edit = $_GET['edit'];

         }
         if (!$_GET['edit']) {
            $edit = $_GET['edit'];

         }
         $id = $_GET['id'];
         if ($_POST['save_x'] && $_POST['save_y']) {
         	
         	 	$srok_objalvane_nakazp = mysql_fetch_array(sql_q("SELECT PValue FROM `system_parameters` where PName = 'srok_objalvane_nakazp';"));
  $srok_objalvane_nakazp = $srok_objalvane_nakazp[0];
  $srok_objalvane_nakazp = $srok_objalvane_nakazp+1;   //7 ili 14 dneven srok vklu4itelno zatova se pribawq o6te 1 den pri 7 dneven srok fakti4eski na 8 stava vidimo na kasata
            $act_no = "act_no='".$_POST['act_no']."'";

            $act_date = $_POST['act_date'];
            $day = substr($act_date, 0, 2);
            $month = substr($act_date, 3, 2);
            $year = substr($act_date, 6, 4);

            $act_date_new = $year.''.$month.''.$day;
            $act_date = "act_date='".$act_date_new."'";

            $act_inst = "act_inst='".$_POST['act_inst']."'";

            $act_maker_name = "act_maker_name='".$_POST['act_maker_name']."'";

            $act_maker_position = "act_maker_position='".$_POST['act_maker_position']."'";
            
            $agent = "agent='".$_POST['agent']."'";

            if (empty($_POST['offence_date'])) {
               $offence_date = "offence_date=NULL";
            }
            else {
               $offence_date = "offence_date='".$_POST['offence_date']."'";
            }

            if (empty($_POST['offence'])) {
               $offence = "offence=NULL";
            }
            else {
               $offence = "offence='".htmlspecialchars($_POST['offence'], ENT_QUOTES)."'";
            }

            if (empty($_POST['laws'])) {
               $laws = "laws=NULL";
            }
            else {
               $laws = "laws='".$_POST['laws']."'";
            }

            if (empty($_POST['offender_age'])) {
               $offender_age = "offender_age=NULL";
            }
            else {
               $offender_age = "offender_age='".$_POST['offender_age']."'";
            }

            if (empty($_POST['offender_position'])) {
               $offender_position = "offender_position=NULL";
            }
            else {
               $offender_position = "offender_position='".$_POST['offender_position']."'";
            }

            if (empty($_POST['witness1'])) {
               $witness1 = "witness1=NULL";
            }
            else {
               $witness1 = "witness1='".$_POST['witness1']."'";
            }

            if (empty($_POST['witness2'])) {
               $witness2 = "witness2=NULL";
            }
            else {
               $witness2 = "witness2='".$_POST['witness2']."'";
            }

            if (empty($_POST['witness3'])) {
               $witness3 = "witness3=NULL";
            }
            else {
               $witness3 = "witness3='".$_POST['witness3']."'";
            }

            if (empty($_POST['description'])) {
               $description = "description=NULL";
            }
            else {
               $description = "description='".$_POST['description']."'";
            }

            if (empty($_POST['np_no'])) {
               $np_no = "np_no=NULL";
            }
            else {
               $np_no = "np_no='".$_POST['np_no']."'";
            }

            if (empty($_POST['np_date'])) {
               $np_date = "np_date=NULL";
            }
            else {
               $np_date = $_POST['np_date'];
               $day = substr($np_date, 0, 2);
               $month = substr($np_date, 3, 2);
               $year = substr($np_date, 6, 4);

               $np_date_new = $year.''.$month.''.$day;
               $np_date = "np_date='".$np_date_new."'";
            }

            if (empty($_POST['np_maker_name'])) {
               $np_maker_name = "np_maker_name=NULL";
            }
            else {
               $np_maker_name = "np_maker_name='".$_POST['np_maker_name']."'";
            }

            if (empty($_POST['np_maker_position'])) {
               $np_maker_position = "np_maker_position=NULL";
            }
            else {
               $np_maker_position = "np_maker_position='".$_POST['np_maker_position']."'";
            }

            if ($_POST['punishment_type'] == "1111111") {
               $punishment_type = "punishment_type=NULL";
            }
            else {
               $punishment_type = "punishment_type='".$_POST['punishment_type']."'";
            }

            if (empty($_POST['punishment_degree'])) {
               $punishment_degree = "punishment_degree=NULL";
            }
            else {
               $punishment_degree = "punishment_degree='".$_POST['punishment_degree']."'";
            }

            if (empty($_POST['compensation_amount'])) {
               $compensation_amount = "compensation_amount=NULL";
            }
            else {
               $compensation_amount = "compensation_amount='".$_POST['compensation_amount']."'";
            }

            if (empty($_POST['appeal'])) {
               $appeal = "appeal=NULL";
            }
            else {
               $appeal = "appeal='".$_POST['appeal']."'";
            }

            if (empty($_POST['bill_no'])) {
               $bill_no = "bill_no=NULL";
            }
            else {
               $bill_no = "bill_no='".$_POST['bill_no']."'";
            }

            if (empty($_POST['bill_date'])) {
               $bill_date = "bill_date=NULL";
            }
            else {
               $bill_date = $_POST['bill_date'];
               $day = substr($bill_date, 0, 2);
               $month = substr($bill_date, 3, 2);
               $year = substr($bill_date, 6, 4);

               $bill_date_new = $year.''.$month.''.$day;
               $bill_date = "bill_date='".$bill_date_new."'";
            }

            if (empty($_POST['paid_amount'])) {
               $paid_amount = "paid_amount=NULL";
            }
            else {
               $paid_amount = "paid_amount='".$_POST['paid_amount']."'";
            }

            if (empty($_POST['receipt_date_notification'])) {
               $receipt_date_notification = "receipt_date_notification=NULL";
               $visible_date = "visible_date=NULL";
            }
            else {
               $receipt_date_notification = $_POST['receipt_date_notification'];
               $day_1 = substr($receipt_date_notification, 0, 2);
               $month_1 = substr($receipt_date_notification, 3, 2);
               $year_1 = substr($receipt_date_notification, 6, 4);

               $receipt_date_notification_new = $year_1.''.$month_1.''.$day_1;
               $receipt_date_notification = "receipt_date_notification='".$receipt_date_notification_new."'";
               $visible_date_1=date( "Y-m-d" ,mktime(0, 0, 0, $month_1  , $day_1+$srok_objalvane_nakazp, $year_1));
               $visible_date="visible_date='".$visible_date_1."'";
              
            }

            if (empty($_POST['receipt_date_invitation'])) {
               $receipt_date_invitation = "receipt_date_invitation=NULL";
            }
            else {
               $receipt_date_invitation = $_POST['receipt_date_invitation'];
               $day = substr($receipt_date_invitation, 0, 2);
               $month = substr($receipt_date_invitation, 3, 2);
               $year = substr($receipt_date_invitation, 6, 4);

               $receipt_date_invitation_new = $year.''.$month.''.$day;
               $receipt_date_invitation = "receipt_date_invitation='".$receipt_date_invitation_new."'";
            }

            if (empty($_POST['invitation_letter_date1'])) {
               $invitation_letter_date1 = "invitation_letter_date1=NULL";
            }
            else {
               $invitation_letter_date1 = $_POST['invitation_letter_date1'];
               $day = substr($invitation_letter_date1, 0, 2);
               $month = substr($invitation_letter_date1, 3, 2);
               $year = substr($invitation_letter_date1, 6, 4);

               $invitation_letter_date1_new = $year.''.$month.''.$day;
               $invitation_letter_date1 = "invitation_letter_date1='".$invitation_letter_date1_new."'";
            }

            if (empty($_POST['invitation_letter_date2'])) {
               $invitation_letter_date2 = "invitation_letter_date2=NULL";
            }
            else {
               $invitation_letter_date2 = $_POST['invitation_letter_date2'];
               $day = substr($invitation_letter_date2, 0, 2);
               $month = substr($invitation_letter_date2, 3, 2);
               $year = substr($invitation_letter_date2, 6, 4);

               $invitation_letter_date2_new = $year.''.$month.''.$day;
               $invitation_letter_date2 = "invitation_letter_date2='".$invitation_letter_date2_new."'";
            }

            if ($_POST['giving'] == "1111111") {
               $giving = "giving=NULL";
            }
            else {
               $giving = "giving='".$_POST['giving']."'";
            }

            if (empty($_POST['giving_date'])) {
               $giving_date = "giving_date=NULL";
            }
            else {
               $giving_date = $_POST['giving_date'];
               $day = substr($giving_date, 0, 2);
               $month = substr($giving_date, 3, 2);
               $year = substr($giving_date, 6, 4);

               $giving_date_new = $year.''.$month.''.$day;
               $giving_date = "giving_date='".$giving_date_new."'";
            }

            if ($_POST['end'] == "on") {
               $end = "end='1'";
            }
            else {
               $end = "end=NULL";
            }

            if (empty($_POST['end_date'])) {
               $end_date = "end_date=NULL";
            }
            else {
               $end_date = $_POST['end_date'];
               $day = substr($end_date, 0, 2);
               $month = substr($end_date, 3, 2);
               $year = substr($end_date, 6, 4);

               $end_date_new = $year.''.$month.''.$day;
               $end_date = "end_date='".$end_date_new."'";
            }

            if (empty($_POST['end_cause'])) {
               $end_cause = "end_cause=NULL";
            }
            else {
               $end_cause = "end_cause='".$_POST['end_cause']."'";
            }

            if ($_POST['del'] == "on") {
               $del = "del='1'";
            }
            else {
               $del = "del=NULL";
            }

            if (empty($_POST['del_cause'])) {
               $del_cause = "del_cause=NULL";
            }
            else {
               $del_cause = "del_cause='".$_POST['del_cause']."'";
            }
	    if (empty($_POST['on_grounds'])) {
               $on_grounds = "on_grounds=NULL";
            }
            else {
               $on_grounds = "on_grounds='".$_POST['on_grounds']."'";
            }
	    if (empty($_POST['in_connection'])) {
               $in_connection = "in_connection=NULL";
            }
            else {
               $in_connection = "in_connection='".$_POST['in_connection']."'";
            }
		if ($_POST['visible_status']=="on" && $_POST['del']!="on" && $_POST['end']!="on")
			{
			   $visible_status = "visible_status=1";
			   
			    if($receipt_date_notification=="receipt_date_notification=NULL")
			   {
				$receipt_date_notification= "receipt_date_notification='".$act_date_new."'";
				$visible_date="visible_date='".$act_date_new."'";
			   }	
			}
			else{
			   $visible_status = "visible_status=0";
			}
			if ($_POST['add_punishment']=="on")
			{
			   $add_punishment = "add_punishment=1";	
			}
			else{
			   $add_punishment = "add_punishment=0";
			}



            $update = "UPDATE nakazp SET $act_no, $act_date ,$act_inst, $act_maker_name, $act_maker_position, $offence_date, $offence, $laws, $offender_age, $offender_position, $witness1, $witness2, $witness3, $description, $np_no, $np_date, $np_maker_name, $np_maker_position, $punishment_type, $punishment_degree, $compensation_amount, $appeal, $bill_no, $bill_date, $paid_amount, $receipt_date_notification, $receipt_date_invitation, $invitation_letter_date1, $invitation_letter_date2, $giving, $giving_date, $end, $end_date, $end_cause, $del, $del_cause, $on_grounds, $in_connection,$visible_status, $visible_date, $agent, $add_punishment WHERE id='$id'";
            $result_update = sql_q($update) or die(mysql_error());

         
		if($_POST['add_punishment']=="on") {
			  if ($_POST['p_type_1']!='1111111')
			  {
					//$s=mysql_fetch_assoc(sql_q("SHOW TABLE STATUS LIKE 'nakazp'"));
              	// $id_np=($s['Auto_increment']-1);
				 sql_q("REPLACE INTO `additional_payments_nakazp`(`id_np`,`number`,`p_type`,`sum_degree`,`pay`,`invoice_numb`,`invoice_date`) VALUES ( '".$id."','','".$_POST['p_type_1']."','".$_POST['sum_degree_1']."','".$_POST['pay_1']."', '".$_POST['invoice_numb_1']."', '".$_POST['']."') ");
			  }
			  if ($_POST['p_type_2']!='1111111')
			  {
				//	$s=mysql_fetch_assoc(sql_q("SHOW TABLE STATUS LIKE 'nakazp'"));
              	// $id_np=($s['Auto_increment']-1);
              	 sql_q("REPLACE INTO `additional_payments_nakazp`(`id_np`,`number`,`p_type`,`sum_degree`,`pay`,`invoice_numb`,`invoice_date`) VALUES ( '".$id."','','".$_POST['p_type_2']."','".$_POST['sum_degree_2']."','".$_POST['pay_2']."',  '".$_POST['invoice_numb_2']."', '".$_POST['']."')  ");
				
			  }
			  } 
		 
		 
		 }
         $select_all = "SELECT * FROM nakazp WHERE id='$id';";
         $result_select_all = sql_q($select_all);
         $get_all = mysql_fetch_array($result_select_all);
         
			$select_all_inv = "SELECT number, date, total_amount FROM invoices WHERE (doc_issue=5 or doc_issue=6) and doc_id='$id' and doc_state in (2,3,5,6,7)";
			$result_inv = sql_q($select_all_inv);
			$num_rows_inv = mysql_num_rows($result_inv);
      ?>
            <form action="view.php?edit=<?php echo $edit;?>&id=<?php echo $id;?>" method="post" name="add" lang="bg">

      <table height='100%' width='100%' border='1'>
                              <input type="hidden" name="data" value="<?php echo $id;?>">
                              <tr>
                                 <td width="25%" align="right">
                                    № на акта:
                                 </td>
                                 <td width="25%">
                                    <input name="act_no" type="text" size="11" maxlength="10" value="<?php echo $get_all[act_no];?>" <?php if (!$edit) {echo "disabled";}?> onKeyPress="ValidateKeyCharNumb(this, '45')">
                                 </td>
                                 <td width="25%" align="right">
                                    Дата на акта:
                                 </td>
                                 <td width="25%">
                                    <?php
                                       if (empty($get_all[act_date])) {
                                          $act_date = "";
                                       }
                                       else {
                                          $act_date = $get_all[act_date];
                                          $day = substr($act_date, 8, 2);
                                          $month = substr($act_date, 5, 2);
                                          $year = substr($act_date, 0, 4);
                                          $act_date_new = $day."-".$month."-".$year;
                                          $act_date = $act_date_new;
                                       }
                                    ?>
                                    <input name="act_date" type="text" size="11" maxlength="10" value="<?php echo $act_date;?>" <?php if (!$edit) {echo "disabled";}?> onKeyPress="ValidateKeyNumb(this, '45')">
                                 </td>
                              </tr>
                              <tr>
                                 <td width="25%" align="right">
                                    Институция издала акта:
                                 </td>
                                 <td width="25%">
                                    <select name="act_inst" <?php if (!$edit) {echo "disabled";}?>>
                                       <?php

                                          $ai = "SELECT act_inst FROM nakazp WHERE id='$id'";
                                          $result_ai = sql_q($ai);
                                          $get_ai = mysql_fetch_array($result_ai);
                                          $ai = $get_ai[act_inst];
                                          if (empty($ai)) {
                                             $select_act_inst = "SELECT cod_cod, cod_name FROM elements WHERE nom_code='26'";
                                             $result_act_inst = sql_q($select_act_inst);
                                             echo "<option value=1111111 selected></option>";
                                             while ($get_act_inst = mysql_fetch_array($result_act_inst)) {
                                                echo "<option value=".$get_act_inst[cod_cod].">".$get_act_inst[cod_name]."</option>";
                                             }
                                          }
                                          if (!empty($ai)) {
                                             $select_act_inst = "SELECT cod_cod, cod_name FROM elements WHERE nom_code='26'";
                                             $result_act_inst = sql_q($select_act_inst);
                                             while ($get_act_inst = mysql_fetch_array($result_act_inst)) {
                                                if ($ai == $get_act_inst[cod_cod]) {
                                                   echo "<option value=".$get_act_inst[cod_cod]." selected>".$get_act_inst[cod_name]."</option>";
                                                }
                                                else {
                                                   echo "<option value=".$get_act_inst[cod_cod].">".$get_act_inst[cod_name]."</option>";
                                                }
                                             }
                                          }
                                       ?>
                                    </select>
                                 </td>
                                 <td width="25%" align="right">
                                    Имена на актосъставителя:
                                 </td>
                                 <td width="25%">
                                    <input name="act_maker_name" type="text" size="33"  value="<?php echo $get_all[act_maker_name];?>" <?php if (!$edit) {echo "disabled";}?> onKeyPress="ValidateKeyChar(this, '45', '46')"><?
				    if($edit) {
				    	?>
					    &nbsp;<input type="image" src="templates/images/list.gif" onClick="window.open('verify_dialog_ranges.php?all=0&ranges=37&field=act_maker_name','','height=420,width=410,menubar=no,resizable=no,scrollbars=yes,status=yes,titlebar=no,toolbar=no'); return false;">
					<?
				    }
				    ?>
                                 </td>
                              </tr>
                              <tr>
                                 <td width="25%" align="right">
                                    Длъжност на актосъставителя:
                                 </td>
                                 <td width="25%">
                                    <input name="act_maker_position" type="text" size="29"  value="<?php echo $get_all[act_maker_position];?>" <?php if (!$edit) {echo "disabled";}?> onKeyPress="ValidateKeyChar(this, '44', '45', '46')"><?
				    if($edit) {
				    	?>
					    &nbsp;<input type="image" src="templates/images/list.gif" onClick="window.open('verify_dialog_ranges.php?all=0&ranges=38&field=act_maker_position','','height=420,width=410,menubar=no,resizable=no,scrollbars=yes,status=yes,titlebar=no,toolbar=no'); return false;">
					<?
				    }
				    ?>
                                 </td>
                                 <td width="25%" align="right">
                                    Дата и място на извършване на нарушението:
                                 </td>
                                 <td width="25%">
                                    <textarea name="offence_date" cols="27" rows="2" <?php if (!$edit) {echo "disabled";}?> onKeyPress="ValidateKeyCharNumb(this, '44', '45', '46')"><?php echo $get_all[offence_date];?></textarea>
                                 </td>
                              </tr>
                              <tr>
                                 <td width="25%" align="right">
                                    Нарушение:
                                 </td>
                                 <td width="25%">
                                    <textarea name="offence" cols="27" rows="2" <?php if (!$edit) {echo "disabled";}?> onKeyPress="//ValidateKeyCharNumb(this, '44', '45', '46')"><?php echo $get_all[offence];?></textarea>
                                 </td>
                                 <td width="25%" align="right">
                                    Нарушени закони и разпоредби:
                                 </td>
                                 <td width="25%">
                                    <input type='text' name="laws" size = '33' <?php if (!$edit) {echo "disabled";}?> onKeyPress="ValidateKeyCharNumb(this, '44', '45', '46', '47')" value = '<?php echo $get_all[laws];?>' ><?
				    if($edit) {
				    	?>
					    &nbsp;<input type="image" src="templates/images/list.gif" onClick="window.open('verify_dialog_ranges.php?all=0&ranges=39&field=laws','','height=420,width=410,menubar=no,resizable=no,scrollbars=yes,status=yes,titlebar=no,toolbar=no'); return false;">
					<?
				    }
				    ?>
                                 </td>
                              </tr>
			        <tr>
                                 <td width="25%" align="right">
                                    На основание:
                                 </td>
                                 <td width="25%">
                                    <input name="on_grounds" type="text" size="65"  value="<?php echo $get_all[on_grounds];?>" <?php if (!$edit) {echo "disabled";}?>><?
				    if($edit) {
				    	?>
					    &nbsp;<input type="image" src="templates/images/list.gif" onClick="window.open('verify_dialog_ranges.php?all=0&ranges=40&field=on_grounds','','height=420,width=410,menubar=no,resizable=no,scrollbars=yes,status=yes,titlebar=no,toolbar=no'); return false;">
					<?
				    }
				    ?>
                                 </td>
                                 <td width="25%" align="right">
                                    Във връзка с:
                                 </td>
                                 <td width="25%">
                                    <input type = 'text' name="in_connection" size = '33' value = '<?php echo $get_all[in_connection];?>' <?php if (!$edit) {echo "disabled";}?> onKeyPress="ValidateKeyCharNumb(this, '44', '45', '46', '47')"><?
				    if($edit) {
				    	?>
					    &nbsp;<input type="image" src="templates/images/list.gif" onClick="window.open('verify_dialog_ranges.php?all=0&ranges=41&field=in_connection','','height=420,width=410,menubar=no,resizable=no,scrollbars=yes,status=yes,titlebar=no,toolbar=no'); return false;">
					<?
				    }
				    ?>
                                 </td>
                              </tr>
                              <tr>
                                 <td width="25%" align="right">
                                    Имена и ЕГН/ЛНЧ/БУЛСТАТ на нарушителя:
                                 </td>
                                 <td width="25%">
                                    <?php
                                    if ($get_all[offender_type]==2)
                                    {
										$select_op = "SELECT companies.name, t.name AS tname FROM  nakazp, companies LEFT JOIN townsfolk AS t ON companies.manager_egn=t.egn WHERE companies.bulstat=nakazp.offender_pid AND nakazp.id='$id' ";
										//UNION(SELECT companies.name, p.name AS tname FROM companies ,nakazp, persons_old_delo AS p WHERE companies.bulstat=nakazp.offender_pid  AND nakazp.id='$id' AND companies.manager_egn = p.id )
                                       $result_op = sql_q($select_op);
                                       $get_op = mysql_fetch_array($result_op);
									}
									else
									{
                                       $select_op = "SELECT townsfolk.name FROM townsfolk, nakazp WHERE townsfolk.egn=nakazp.offender_pid AND nakazp.id='$id'";
                                       $result_op = sql_q($select_op);
                                       $get_op = mysql_fetch_array($result_op);
                                       }
                                    ?>
                                    <input name="offender_name" type="text" size="65" value="<?php echo htmlspecialchars($get_op[name]); 
									if ($get_all[offender_type]==2)
                                    {
                                    echo "(упр.";
                                    echo $get_op[tname];
                                    echo ")";
										}
									
									
									?>" disabled>
                                    <input name="offender_pid" type="text" size="10" value="<?php echo $get_all[offender_pid];?>" disabled>
                                    <input type="hidden" name="offender_type" value="<? echo $get_all[offender_type];?>">
								<!--//////////////////////////////////////////////////////////////////////////////////////-->
							
                                       <?php

                                          $ai = "SELECT agent FROM nakazp WHERE id='$id'";
                                          
                                          $result_ai = sql_q($ai);
                                          $get_ai = mysql_fetch_array($result_ai);
                                          $ai = $get_ai[agent];
                                        
                                          if ($ai!=0){
                                        	echo '<select name="agent"'; if(!$edit) {echo "disabled";} 
                                          echo ">";
                                             $query = sql_q("SELECT cod_cod, cod_name FROM elements WHERE nom_code='49' GROUP BY cod_cod");
	    									 while ($row=mysql_fetch_array($query)) {
	    									 	//echo "eeeeeeeeeeee".$row['cod_cod'];
	    									 //	echo "eeeeeeeeeeee".$row['cod_name'];
                                              if ($ai == $row['cod_cod']) {
                                               echo "<option value=".$row[cod_cod]." selected>".$row[cod_name]."</option>";
                                            }
                                               else {
                                             echo "<option value=".$row['cod_cod'].">".$row['cod_name']."</option>";
                                          
                                             }
                                             }
                                          //}
                                        echo "</select>";
                                          }
                                          
                                       ?>
                                    
                                    	<!--//////////////////////////////////////////////////////////////////////////////////////-->
                                 </td>
                                 <td width="25%" align="right">
                                    Възраст на нарушителя:
                                 </td>
                                 <td width="25%">
                                    <input name="offender_age" type="text" size="10" maxlength="3" value="<?php echo $get_all[offender_age];?>" <?php if (!$edit) {echo "disabled";}?> onKeyPress="ValidateKeyNumb(this)">
                                 </td>
                              </tr>
                              <tr>
                                 <td width="25%" align="right">
                                    Месторабота на нарушителя:
                                 </td>
                                 <td width="25%">
                                    <input name="offender_position" type="text" size="35"  value="<?php echo $get_all[offender_position];?>" <?php if (!$edit) {echo "disabled";}?> onKeyPress="ValidateKeyCharNumb(this, '44', '45', '46')">
                                 </td>
                                 <td width="25%" align="right">
                                    Първи свидетел:
                                 </td>
                                 <td width="25%">
                                    <textarea name="witness1" cols="27" rows="2" <?php if (!$edit) {echo "disabled";}?> onKeyPress="ValidateKeyCharNumb(this, '44', '45', '46')"><?php echo $get_all[witness1];?></textarea>
                                 </td>
                              </tr>
                              <tr>
                                 <td width="25%" align="right">
                                    Втори свидетел:
                                 </td>
                                 <td width="25%">
                                    <textarea name="witness2" cols="27" rows="2" <?php if (!$edit) {echo "disabled";}?> onKeyPress="ValidateKeyCharNumb(this, '44', '45', '46')"><?php echo $get_all[witness2];?></textarea>
                                 </td>
                                 <td width="25%" align="right">
                                    Трети свидетел:
                                 </td>
                                 <td width="25%">
                                    <textarea name="witness3" cols="27" rows="2" <?php if (!$edit) {echo "disabled";}?> onKeyPress="ValidateKeyCharNumb(this, '44', '45', '46')"><?php echo $get_all[witness3];?></textarea>
                                 </td>
                              </tr>
                              <tr>
                                 <td width="25%" align="right">
                                    Опис:
                                 </td>
                                 <td width="25%">
                                    <textarea name="description" cols="27" rows="2" <?php if (!$edit) {echo "disabled";}?> onKeyPress="ValidateKeyCharNumb(this, '44', '45', '46')"><?php echo $get_all[description];?></textarea>
                                 </td>
                                 <td width="25%" align="right">
                                    № на НП:
                                 </td>
                                 <td width="25%">
                                    <input name="np_no" type="text" size="11" maxlength="10" value="<?php echo $get_all[np_no];?>" <?php if (!$edit) {echo "disabled";}?> onKeyPress="ValidateKeyCharNumb(this, '45')">
                                 </td>
                              </tr>
                              <tr>
                                 <td width="25%" align="right">
                                    Дата на НП:
                                 </td>
                                 <td width="25%">
                                    <?php
                                       if (empty($get_all[np_date])) {
                                          $np_date = "";
                                       }
                                       else {
                                          $np_date = $get_all[np_date];
                                          $day = substr($np_date, 8, 2);
                                          $month = substr($np_date, 5, 2);
                                          $year = substr($np_date, 0, 4);
                                          $np_date_new = $day."-".$month."-".$year;
                                          $np_date = $np_date_new;
                                       }
                                    ?>
                                    <input name="np_date" type="text" size="11" maxlength="10" value="<?php echo $np_date;?>" <?php if (!$edit) {echo "disabled";}?> onKeyPress="ValidateKeyNumb(this, '45')">
                                 </td>
                                 <td width="25%" align="right">
                                    Имена на съставителя на НП:
                                 </td>
                                 <td width="25%">
                                    <input name="np_maker_name" type="text" size="33"  value="<?php echo $get_all[np_maker_name];?>" <?php if (!$edit) {echo "disabled";}?> onKeyPress="ValidateKeyChar(this, '45', '46')"><?
				    if($edit) {
				    	?>
					    &nbsp;<input type="image" src="templates/images/list.gif" onClick="window.open('verify_dialog_ranges.php?all=0&ranges=42&field=np_maker_name','','height=420,width=410,menubar=no,resizable=no,scrollbars=yes,status=yes,titlebar=no,toolbar=no'); return false;">
					<?
				    }
				    ?>
                                 </td>
                              </tr>
                              <tr>
                                 <td width="25%" align="right">
                                    Длъжност на съставителя на НП:
                                 </td>
                                 <td width="25%">
                                    <input name="np_maker_position" type="text" size="29"  value="<?php echo $get_all[np_maker_position];?>" <?php if (!$edit) {echo "disabled";}?> onKeyPress="ValidateKeyChar(this, '44', '45', '46')"><?
				    if($edit) {
				    	?>
					    &nbsp;<input type="image" src="templates/images/list.gif" onClick="window.open('verify_dialog_ranges.php?all=0&ranges=43&field=np_maker_position','','height=420,width=410,menubar=no,resizable=no,scrollbars=yes,status=yes,titlebar=no,toolbar=no'); return false;">
					<?
				    }
				    ?>
                                 </td>
                                 <td width="25%" align="right">
                                    Вид на наказанието:
                                 </td>
                                 <td width="25%">
                                    <select name="punishment_type" <?php if (!$edit) {echo "disabled";}?>>
                                       <?php

                                          $pt = "SELECT punishment_type FROM nakazp WHERE id='$id'";
                                          $result_pt = sql_q($pt);
                                          $get_pt = mysql_fetch_array($result_pt);
                                          $pt = $get_pt[punishment_type];
                                          if (empty($pt)) {
                                             $select_punishment_type = "SELECT cod_cod, cod_name FROM elements WHERE nom_code='27'";
                                             $result_punishment_type = sql_q($select_punishment_type);
                                             echo "<option value=1111111 selected></option>";
                                             while ($get_punishment_type = mysql_fetch_array($result_punishment_type)) {
                                                echo "<option value=".$get_punishment_type[cod_cod].">".$get_punishment_type[cod_name]."</option>";
                                             }
                                          }
                                          if (!empty($pt)) {
                                             $select_punishment_type = "SELECT cod_cod, cod_name FROM elements WHERE nom_code='27'";
                                             $result_punishment_type = sql_q($select_punishment_type);
                                             while ($get_punishment_type = mysql_fetch_array($result_punishment_type)) {
                                                if ($pt == $get_punishment_type[cod_cod]) {
                                                   echo "<option value=".$get_punishment_type[cod_cod]." selected>".$get_punishment_type[cod_name]."</option>";
                                                }
                                                else {
                                                   echo "<option value=".$get_punishment_type[cod_cod].">".$get_punishment_type[cod_name]."</option>";
                                                }
                                             }
                                          }
                                          /*$conn = mysql_connect("localhost", "root","") or die("NoConn");
                                          mysql_select_db("registers_db") or die("NoSelect");
                                          $select_punishment_type = "SELECT elements.cod_cod, elements.cod_name FROM elements, nakazp WHERE elements.nom_code='26' AND elements.cod_cod=nakazp.punishment_type AND nakazp.id='$id'";
                                          $result_punishment_type = sql_q($select_punishment_type);
                                          while ($get_punishment_type = mysql_fetch_array($result_punishment_type)) {
                                             echo "<option value=".$get_punishment_type[cod_cod].">".$get_punishment_type[cod_name]."</option>";
                                          }
                                          mysql_close($conn);*/
                                       ?>
                                    </select>
                                 </td>
                              </tr>
                              <tr>
                                 <td width="25%" align="right">
                                    Размер на наказанието:
                                 </td>
                                 <td width="25%">
                                    <input name="punishment_degree" type="text" size="34" maxlength="15" value="<?php echo $get_all[punishment_degree];?>" <?php if (!$edit) {echo "disabled";}?> onKeyPress="ValidateKeyCharNumb(this, '44', '45', '46', '47')">
                                 </td>
                                 <td width="25%" align="right">
                                    Размер на обезщетението:
                                 </td>
                                 <td width="25%">
                                    <textarea name="compensation_amount" cols="29" rows="2" <?php if (!$edit) {echo "disabled";}?> onKeyPress="ValidateKeyCharNumb(this, '44', '45', '46', '47')"><?php echo $get_all[compensation_amount];?></textarea>
                                 </td>
                              </tr>
                              <tr>
                                 <td width="25%" align="right">
                                    Обжалване:
                                 </td>
                                 <td width="25%">
                                    <textarea name="appeal" cols="26" rows="2" <?php if (!$edit) {echo "disabled";}?> onKeyPress="ValidateKeyCharNumb(this, '44', '45', '46', '47')"><?php echo $get_all[appeal];?></textarea>
                                 </td>
                                 <td width="25%" align="right">
                                    № и дата на квитанцията (фактурата):
                                 </td>
                                 <td width="25%">
												<?	if ($num_rows_inv > 1)
													{	echo ('
												<table class="small" border=1>
												<tr><td>Номер</td>
													<td>Дата</td>
													<td>Сума</td>
												</tr>');
														while ($all_invoices = mysql_fetch_assoc($result_inv))
														{	echo ('<tr><td>'.
																$all_invoices['number'].'</td><td>'.
																$all_invoices['date'].'</td><td>'.
																$all_invoices['total_amount'].' лв.</td></tr>');
														}echo ('</table>');
													}else
													{
												?>
                                    <input name="bill_no" type="text" size="11" maxlength="10" value="<?php echo $get_all[bill_no];?>" <?php if (!$edit) {echo "disabled";}?> onKeyPress="ValidateKeyCharNumb(this, '45')"><font size="2"> - номер</font>
                                    
                                    <br>
                                    <?php
                                       if (empty($get_all[bill_date])) {
                                          $bill_date = "";
                                       }
                                       else {
                                          $bill_date = $get_all[bill_date];
                                          $day = substr($bill_date, 8, 2);
                                          $month = substr($bill_date, 5, 2);
                                          $year = substr($bill_date, 0, 4);
                                          $bill_date_new = $day."-".$month."-".$year;
                                          $bill_date = $bill_date_new;
                                       }
                                    ?>
                                    <input name="bill_date" type="text" size="11" maxlength="10" value="<?php echo $bill_date;?>" <?php if (!$edit) {echo "disabled";}?> onKeyPress="ValidateKeyNumb(this, '45')"><font size="2"> - дата</font>
                                    <?	}
												?>
                                 </td>
                              </tr>
                              <tr>
                                 <td width="25%" align="right">
                                    Платена сума:
                                 </td>
                                 <td width="25%">
                                    <input name="paid_amount" type="text" size="10" maxlength="13" value="<?php echo $get_all[paid_amount];?>" <?php if (!$edit) {echo "disabled";}?> onKeyPress="ValidateKeyNumb(this, '44', '46')">
                                 </td>
                                 <td width="25%" align="right">
                                    <font color="blue">Дата на връчване на НП(разписка/уведомление):</font>
                                 </td>
                                 <td width="25%">
                                    <?php
                                       if (empty($get_all[receipt_date_notification]) || $get_all[receipt_date_notification]=='0000-00-00') {
                                          $receipt_date_notification = "";
                                       }
                                       else {
                                          $receipt_date_notification = $get_all[receipt_date_notification];
                                          $day = substr($receipt_date_notification, 8, 2);
                                          $month = substr($receipt_date_notification, 5, 2);
                                          $year = substr($receipt_date_notification, 0, 4);
                                          $receipt_date_notification_new = $day."-".$month."-".$year;
                                          $receipt_date_notification = $receipt_date_notification_new;
                                       }
                                    ?>
                                    <input name="receipt_date_notification" type="text" size="11" maxlength="11" value="<?php echo $receipt_date_notification;?>" <?php if (!$edit) {echo "disabled";}?> onKeyPress="ValidateKeyNumb(this, '45')">
    <!-- /////////////////////////////////////////////////  -->                              
									 
									
	<!--//////////////////////////////////////////////////////////////-->
                                 </td>
                              </tr>
                               </tr>
                              <tr><td colspan="4" align="center">Допълнителни санкции по наказателно: Да <input type="checkbox" name="add_punishment" id="add_punishment" onclick="enable_p_type()" <?if ($get_all['add_punishment']==1) echo "checked";?>></td></tr>
                               <?
							   	if ($get_all['add_punishment']==1)
							   	{   $disabled='';
							   	    $i=0;
									$res_add_payments=sql_q("SELECT * FROM additional_payments_nakazp WHERE id_np='$id'");
									while ($row_add_payments = mysql_fetch_array($res_add_payments))
									{ 
										$add_payments[$i++]=array("p_type" => $row_add_payments['p_type'], "sum_degree" => $row_add_payments['sum_degree'], "pay" => $row_add_payments['pay'], "invoice_numb" => $row_add_payments['invoice_numb'], "invoice_date" => $row_add_payments['invoice_date'] );
									}
								}
								else {
									$disabled="disabled";
								}
								
								//print_r($add_payments);
								//tova tuk otnovo da se napravi s cikal za da moje da se napravi universalno za pove4e redove
							   ?>
                              <tr>
                             
                                 <td width="25%" align="right">
                                    Допълнителни санкции по наказателно:
                                 </td>
                                 <td width="25%">
                                    <select name="p_type_1" id="p_type_1" <? echo $disabled;?>>
                                       <option value="1111111">---ИЗБЕРЕТЕ НАКАЗАНИЕ---</option>
                                       <?php
                                          $select_act_inst = "SELECT s.service_code, s.name as name FROM services s , group_services g WHERE g.name='Наказателно постановление' AND g.code=s.group_code AND s.document=13";
                                          $result_act_inst = sql_q($select_act_inst);
                                          while ($get_act_inst = mysql_fetch_array($result_act_inst)) {
                                          	if ($get_act_inst['service_code']==$add_payments[0]['p_type'])
                                          	{
												 echo "<option value=".$get_act_inst['service_code']." selected>".$get_act_inst['name']."</option>";
											}
											else {
                                             echo "<option value=".$get_act_inst['service_code'].">".$get_act_inst['name']."</option>";
                                             }
                                          }
                                       ?>
                                    </select>
                                 </td>
                                 <td width="25%" align="right">
                                    Размер на наказанието:
                                 </td>
                                 <td width="25%">
                                    <input name="sum_degree_1" id="sum_degree_1" type="text" size="34" maxlength="15" value="<? echo $add_payments[0]['sum_degree']?>" onKeyPress="ValidateKeyCharNumb(this, '44', '45', '46', '47')" <?echo $disabled;?>>
                                 </td>
                              </tr>
                              <tr>
                                 <td width="25%" align="right">
                                    Допълнителни санкции по наказателно:
                                 </td>
                                 <td width="25%">
                                    <select name="p_type_2" id="p_type_2" <?echo $disabled;?>>
                                       <option value="1111111">---ИЗБЕРЕТЕ НАКАЗАНИЕ---</option>
                                       <?php
                                          $select_act_inst = "SELECT s.service_code, s.name as name FROM services s , group_services g WHERE g.name='Наказателно постановление' AND g.code=s.group_code AND s.document=13";
                                          $result_act_inst = sql_q($select_act_inst);
                                          while ($get_act_inst = mysql_fetch_array($result_act_inst)) {
                                             	if ($get_act_inst['service_code']==$add_payments[1]['p_type'])
                                          	{
												 echo "<option value=".$get_act_inst['service_code']." selected>".$get_act_inst['name']."</option>";
											}
											else {
                                             echo "<option value=".$get_act_inst['service_code'].">".$get_act_inst['name']."</option>";
                                             }
                                          
                                          }
                                       ?>
                                    </select>
                                 </td>
                                 <td width="25%" align="right">
                                    Размер на наказанието:
                                 </td>
                                 <td width="25%">
                                    <input name="sum_degree_2" id="sum_degree_2" type="text" size="34" maxlength="15" value="<? echo $add_payments[1]['sum_degree']?>" onKeyPress="ValidateKeyCharNumb(this, '44', '45', '46', '47')" <?echo $disabled;?>>
                                 </td>
                              </tr>
                              <tr>
                              <td width="25%" align="right">
                                  Платена сума по <? $r=mysql_fetch_row(sql_q("select name from services where service_code='".$add_payments[0]['p_type']."'")); echo $r[0];?> <!--да се взема динамично името на глобата!!!!!!!!!!!!-->
                                 </td>
                                 <td width="25%">
                                 <input name="pay_1" type="text" size="10" maxlength="13" value="<?php echo $add_payments[0]['pay'];?>" <?echo $disabled;?> onKeyPress="ValidateKeyNumb(this, '44', '46')">
								 </td>
                                 <td width="25%" align="right">
                                  Номер/Дата на платежен документ  
                                 </td>
                                 <td width="25%">
								  <input name="invoice_numb_1" type="text" size="11" maxlength="10" value="<?php echo $add_payments[0]['invoice_numb'];?>" <?echo $disabled;?> onKeyPress="ValidateKeyCharNumb(this, '45')"><font size="2"> - номер</font>
                                    
                                    <br>
                                    <?php
                                       if (empty($add_payments[0]['invoice_date'])) {
                                          $invoice_date_1 = "";
                                       }
                                       else {
                                          $invoice_date_1 = $add_payments[0]['invoice_date'];
                                          $day = substr($invoice_date_1, 8, 2);
                                          $month = substr($invoice_date_1, 5, 2);
                                          $year = substr($invoice_date_1, 0, 4);
                                          $invoice_date_1_new = $day."-".$month."-".$year;
                                          $invoice_date_1 = $invoice_date_1_new;
                                       }
                                    ?>
                                    <input name="invoice_date_1" type="text" size="11" maxlength="10" value="<?php echo $invoice_date_1;?>" <?php if (!$edit) {echo "disabled";}?> onKeyPress="ValidateKeyNumb(this, '45')"><font size="2"> - дата</font>
								 </td>
                              <tr>
                              <td width="25%" align="right">
                                  Платена сума по <? $r=mysql_fetch_row(sql_q("select name from services where service_code='".$add_payments[1]['p_type']."'")); echo $r[0];?>   <!--да се взема динамично името на глобата!!!!!!!!!!!!-->
                                 </td>
                                 <td width="25%">
								 <input name="pay_2" type="text" size="10" maxlength="13" value="<?php echo $add_payments[1]['pay'];?>" <?echo $disabled;?> onKeyPress="ValidateKeyNumb(this, '44', '46')">
								 </td>
                                 <td width="25%" align="right">
                                    Номер/Дата на платежен документ 
                                 </td>
                                 <td width="25%">
								  <input name="invoice_numb_2" type="text" size="11" maxlength="10" value="<?php echo $add_payments[1]['invoice_numb'];?>" <?echo $disabled;?> onKeyPress="ValidateKeyCharNumb(this, '45')"><font size="2"> - номер</font>
                                    
                                    <br>
                                    <?php
                                       if (empty($add_payments[1]['invoice_date'])) {
                                          $invoice_date_2 = "";
                                       }
                                       else {
                                          $invoice_date_2 = $add_payments[1]['invoice_date'];
                                          $day = substr($invoice_date_2, 8, 2);
                                          $month = substr($invoice_date_2, 5, 2);
                                          $year = substr($invoice_date_2, 0, 4);
                                          $invoice_date_2_new = $day."-".$month."-".$year;
                                          $invoice_date_2 = $invoice_date_2_new;
                                       }
                                    ?>
                                    <input name="invoice_date_2" type="text" size="11" maxlength="10" value="<?php echo $invoice_date_2;?>" <?php if (!$edit) {echo "disabled";}?> onKeyPress="ValidateKeyNumb(this, '45')"><font size="2"> - дата</font>>
								 </td>
							  </tr>
							  <tr>
							  </tr>
                                 <td width="25%" align="right">
                                    Дата на връчване на разписка/покана:
                                 </td>
                                 <td width="25%">
                                    <?php
                                       if (empty($get_all[receipt_date_invitation])) {
                                          $receipt_date_invitation = "";
                                       }
                                       else {
                                       $receipt_date_invitation = $get_all[receipt_date_invitation];
                                       $day = substr($receipt_date_invitation, 8, 2);
                                       $month = substr($receipt_date_invitation, 5, 2);
                                       $year = substr($receipt_date_invitation, 0, 4);
                                       $receipt_date_invitation_new = $day."-".$month."-".$year;
                                       $receipt_date_invitation = $receipt_date_invitation_new;
                                       }
                                    ?>
                                    <input name="receipt_date_invitation" type="text" size="11" maxlength="11" value="<?php echo $receipt_date_invitation;?>" <?php if (!$edit) {echo "disabled";}?> onKeyPress="ValidateKeyNumb(this, '45')">
                                 </td>
                                 <td width="25%" align="right">
                                    Дата на първото уведомително писмо:
                                 </td>
                                 <td width="25%">
                                    <?php
                                       if (empty($get_all[invitation_letter_date1])) {
                                          $invitation_letter_date1 = "";
                                       }
                                       else {
                                       $invitation_letter_date1 = $get_all[invitation_letter_date1];
                                       $day = substr($invitation_letter_date1, 8, 2);
                                       $month = substr($invitation_letter_date1, 5, 2);
                                       $year = substr($invitation_letter_date1, 0, 4);
                                       $invitation_letter_date1_new = $day."-".$month."-".$year;
                                       $invitation_letter_date1 = $invitation_letter_date1_new;
                                       }
                                    ?>
                                    <input name="invitation_letter_date1" type="text" size="11" maxlength="11" value="<?php echo $invitation_letter_date1;?>" <?php if (!$edit) {echo "disabled";}?> onKeyPress="ValidateKeyNumb(this, '45')">
                                 </td>
                              </tr>
                              <tr>
                                 <td width="25%" align="right">
                                    Дата на второто уведомително писмо:
                                 </td>
                                 <td width="25%">
                                    <?php
                                       if (empty($get_all[invitation_letter_date2])) {
                                          $invitation_letter_date2 = "";
                                       }
                                       else {
                                       $invitation_letter_date2 = $get_all[invitation_letter_date2];
                                       $day = substr($invitation_letter_date2, 8, 2);
                                       $month = substr($invitation_letter_date2, 5, 2);
                                       $year = substr($invitation_letter_date2, 0, 4);
                                       $invitation_letter_date2_new = $day."-".$month."-".$year;
                                       $invitation_letter_date2 = $invitation_letter_date2_new;
                                       }
                                    ?>
                                    <input name="invitation_letter_date2" type="text" size="11" maxlength="11" value="<?php echo $invitation_letter_date2;?>" <?php if (!$edit) {echo "disabled";}?> onKeyPress="ValidateKeyNumb(this, '45')">
                                 </td>
                                 <td width="25%" align="right">
                                    Предадено на:
                                 </td>
                                 <td width="25%">
                                    <select name="giving" <?php if (!$edit) {echo "disabled";}?>>
                                       <?php

                                          $giv = "SELECT giving FROM nakazp WHERE id='$id'";
                                          $result_giv = sql_q($giv);
                                          $get_giv = mysql_fetch_array($result_giv);
                                          $giv = $get_giv[giving];
                                          if (empty($giv)) {
                                             $select_giving = "SELECT cod_cod, cod_name FROM elements WHERE nom_code='28'";
                                             $result_giving = sql_q($select_giving);
                                             echo "<option value=1111111 selected></option>";
                                             while ($get_giving = mysql_fetch_array($result_giving)) {
                                                echo "<option value=".$get_giving[cod_cod].">".$get_giving[cod_name]."</option>";
                                             }
                                          }
                                          if (!empty($giv)) {
                                             $select_giving = "SELECT cod_cod, cod_name FROM elements WHERE nom_code='28'";
                                             $result_giving = sql_q($select_giving);
                                             while ($get_giving = mysql_fetch_array($result_giving)) {
                                                if ($giv == $get_giving[cod_cod]) {
                                                   echo "<option value=".$get_giving[cod_cod]." selected>".$get_giving[cod_name]."</option>";
                                                }
                                                else {
                                                   echo "<option value=".$get_giving[cod_cod].">".$get_giving[cod_name]."</option>";
                                                }
                                             }
                                          }
                                          /*$conn = mysql_connect("localhost", "root","") or die("NoConn");
                                          mysql_select_db("registers_db") or die("NoSelect");
                                          $select_giving = "SELECT elements.cod_cod, elements.cod_name FROM elements, nakazp WHERE elements.nom_code='28' AND elements.cod_cod=nakazp.giving AND nakazp.id='$id'";
                                          $result_giving = sql_q($select_giving);
                                          while ($get_giving = mysql_fetch_array($result_giving)) {
                                             echo "<option value=".$get_giving[cod_cod].">".$get_giving[cod_name]."</option>";
                                          }
                                          mysql_close($conn);*/
                                       ?>
                                    </select>
                                 </td>
                              </tr>
                              <tr>
                                 <td width="25%" align="right">
                                    Дата на предаване:
                                 </td>
                                 <td width="25%">
                                    <?php
                                       if (empty($get_all[giving_date])) {
                                          $giving_date = "";
                                       }
                                       else {
                                       $giving_date = $get_all[giving_date];
                                       $day = substr($giving_date, 8, 2);
                                       $month = substr($giving_date, 5, 2);
                                       $year = substr($giving_date, 0, 4);
                                       $giving_date_new = $day."-".$month."-".$year;
                                       $giving_date = $giving_date_new;
                                       }
                                    ?>
                                    <input name="giving_date" type="text" size="11" maxlength="11" value="<?php echo $giving_date;?>" <?php if (!$edit) {echo "disabled";}?> onKeyPress="ValidateKeyNumb(this, '45')">
                                 </td>
                                 <td width="25%" align="right">
                                    Прекратено:
                                 </td>
                                 <td width="25%">
                                    <?php
                                       if ($get_all[end]) {
                                          if (!$edit) {
                                             echo '<input name="end" type="checkbox" checked disabled>&nbsp;&nbsp;&nbsp;да';
                                          }
                                          if ($edit) {
                                             echo '<input name="end" type="checkbox" checked>&nbsp;&nbsp;&nbsp;да';
                                          }
                                       }
                                       else {
                                          if (!$edit) {
                                             echo '<input name="end" type="checkbox" disabled>&nbsp;&nbsp;&nbsp;да';
                                          }
                                          if ($edit) {
                                             echo '<input name="end" type="checkbox">&nbsp;&nbsp;&nbsp;да';
                                          }
                                       }
                                    ?>
                                 </td>
                              </tr>
                              <tr>
                                 <td width="25%" align="right">
                                    Дата на прекратяване:
                                 </td>
                                 <td width="25%">
                                    <?php
                                       if (empty($get_all[end_date])) {
                                          $end_date = "";
                                       }
                                       else {
                                       $end_date = $get_all[end_date];
                                       $day = substr($end_date, 8, 2);
                                       $month = substr($end_date, 5, 2);
                                       $year = substr($end_date, 0, 4);
                                       $end_date_new = $day."-".$month."-".$year;
                                       $end_date = $end_date_new;
                                       }
                                    ?>
                                    <input name="end_date" type="text" size="11" maxlength="11" value="<?php echo $end_date;?>" <?php if (!$edit) {echo "disabled";}?> onKeyPress="ValidateKeyNumb(this, '45')">
                                 </td>
                                 <td width="25%" align="right">
                                    Причина за прекратяване:
                                 </td>
                                 <td width="25%">
                                    <textarea name="end_cause" cols="26" rows="2" <?php if (!$edit) {echo "disabled";}?> onKeyPress="ValidateKeyCharNumb(this, '44', '45', '46', '47')"><?php echo $get_all[end_cause];?></textarea>
                                 </td>
                              </tr>
                              <tr>
                                 <td width="25%" align="right">
                                    Анулирано:
                                 </td>
                                 <td width="25%">
                                    <?php
                                       if ($get_all[del]) {
                                          if (!$edit) {
                                             echo '<input name="del" type="checkbox" checked disabled>&nbsp;&nbsp;&nbsp;да';
                                          }
                                          if ($edit) {
                                             echo '<input name="del" type="checkbox" checked>&nbsp;&nbsp;&nbsp;да';
                                          }
                                       }
                                       else {
                                          if (!$edit) {
                                             echo '<input name="del" type="checkbox" disabled>&nbsp;&nbsp;&nbsp;да';
                                          }
                                          if ($edit) {
                                             echo '<input name="del" type="checkbox">&nbsp;&nbsp;&nbsp;да';
                                          }
                                       }
                                    ?>
                                 </td>
                                 <td width="25%" align="right">
                                    Причина за анулиране:
                                 </td>
                                 <td width="25%">
                                    <textarea name="del_cause" cols="26" rows="2" <?php if (!$edit) {echo "disabled";}?> onKeyPress="ValidateKeyCharNumb(this, '44', '45', '46', '47')"><?php echo $get_all[del_cause];?></textarea>
                                 </td>
                              </tr>
                              	
                              <tr>
                                 <td width="25%" align="right">
                               <font color="blue"> Активно на каса: </font>
                              	 </td>
                              	 <td width="25%">
                              	 <?php
                                       if ($get_all[visible_status] == 1) {
                                          if (!$edit) {
                                             echo '<input name="visible_status" type="checkbox" checked disabled>&nbsp;&nbsp;&nbsp;да';
                                          }
                                          if ($edit) {
                                             echo '<input name="visible_status" type="checkbox" checked>&nbsp;&nbsp;&nbsp;да';
                                          }
                                       }
                                       else {
                                          if (!$edit) {
                                             echo '<input name="visible_status" type="checkbox" disabled>&nbsp;&nbsp;&nbsp;да';
                                          }
                                          if ($edit) {
                                             echo '<input name="visible_status" type="checkbox" >&nbsp;&nbsp;&nbsp;да';
                                          }
                                       }
                                    ?>
                              	 </td>
                              	 <td width="25%" align="right">
                              	<font color="blue"> Активно на каса на:</font>
                              	 </td>
                              	 <td width="25%" >
                              	<?php
                                       if (empty($get_all[visible_date]) || $get_all[visible_date]=='0000-00-00') {
                                          $visible_date = "";
                                       }
                                       else {
                                       $visible_date = $get_all[visible_date];
                                       $day = substr($visible_date, 8, 2);
                                       $month = substr($visible_date, 5, 2);
                                       $year = substr($visible_date, 0, 4);
                                       $visible_date_new = $day."-".$month."-".$year;
                                       $visible_date = $visible_date_new;
                                       }
                                    ?>
                                    <input name="visible_date" type="text" size="11" maxlength="11" value="<?php echo $visible_date;?>"  disabled onKeyPress="ValidateKeyNumb(this, '45')">
                              	 </td>
                              </tr>
                              <tr>
                              <td>
							  Причина за прехвърляне:
							  </td>
							  <td><??></td>
							  <td>История на прехвърлянето:</td>
							  <td></td>
                              </tr>
         <tr height='5%'>
            <td colspan='4' align='right'>
               <?php
                  if ($edit) {
               ?>
               <input type="image" name="history" src="templates/images/view.gif" onClick="OpenWindow('history_transfer_np.php?id=<?=$id?>', '', 1024, 768);">
               
               &nbsp;&nbsp;&nbsp;
               <input type="image" name="details" src="templates/images/Details.gif" onClick="OpenWindow('details_sum.php?id=<?=$id?>', '', 800, 600);">
               
               &nbsp;&nbsp;&nbsp;
               <input type='image' name='save' src='templates/images/Add.gif' onClick="return VerifyValidData('edit');document.add.submit();">
               &nbsp;&nbsp;&nbsp;
               <?//if ($get_all['globa_fish']==1){?>
              <!-- <input type='image' name='print_np' src='templates/images/print_np.gif' onClick="window.open('letter_setting.php?offender_pid='+document.add.offender_pid.value+'&offender_type='+document.add.offender_type.value +'&id_np=<?//echo $id;?>','','width=400,height=500');return false;">-->
               <?//} else { ?>
			   	<input type='image' name='print_np' src='templates/images/print_np.gif' onClick="window.open('print.php?type=22&id='+document.add.data.value+'');return false;">
			<?//}	?>
				 &nbsp;&nbsp;&nbsp;
			     <input type='image' name='print_up' src='templates/images/print_up.gif' onClick="window.open('letter_setting.php?offender_pid='+document.add.offender_pid.value+'&offender_type='+document.add.offender_type.value +'&id_np=<?echo $id;?>','','width=400,height=500');return false;">
               &nbsp;&nbsp;&nbsp;
               <input type='image' name='close' src='templates/images/Exit.gif' onClick='/*window.opener.history.go(0);*/window.opener.location.reload(true);window.close();'>
               &nbsp;&nbsp;
               <?php
                  }
                  if (!$edit) {
               ?>
               <input type="image" name="history" src="templates/images/view.gif" onClick="OpenWindow('history_transfer_np.php?id=<?=$id?>', '', 1024, 768);">
               
               &nbsp;&nbsp;&nbsp;
               <input type='image' name='print_act' src='templates/images/print_act.gif' onClick="window.open('print.php?type=12&id='+document.add.data.value+'');return false;">
               &nbsp;&nbsp;&nbsp;
               <?//if ($get_all['globa_fish']==1){?>
              <!-- <input type='image' name='print_np' src='templates/images/print_np.gif' onClick="window.open('letter_setting.php?offender_pid='+document.add.offender_pid.value+'&offender_type='+document.add.offender_type.value +'&id_np=<?//echo $id;?>','','width=400,height=500');return false;">-->
               <?//} else { ?>
               <input type='image' name='print_np' src='templates/images/print_np.gif' onClick="window.open('print.php?type=22&id='+document.add.data.value+'');return false;">
               <?//}?>
               &nbsp;&nbsp;&nbsp;
                <input type='image' name='print_up' src='templates/images/print_up.gif' onClick="window.open('letter_setting.php?offender_pid='+document.add.offender_pid.value+'&offender_type='+document.add.offender_type.value +'&id_np=<?echo $id;?>','','width=400,height=500');return false;">
               &nbsp;&nbsp;&nbsp;
               <input type='image' name='close' src='templates/images/Exit.gif' onClick='window.close();'>
               &nbsp;&nbsp;
               <?php
               }
               ?>
            </td>
         </tr>
      </table>
      </form>
   </body>
</html>