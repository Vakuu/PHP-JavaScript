<?php
	include_once("../../inc/conf.php");
	
	function is_date($date_string)
	{
		return true;
	}
	
	$data_type = $_GET['data_type'];
	$bulstat = is_numeric($_GET['bulstat']) ? $_GET['bulstat'] : -1;
	$invoice_number = is_numeric($_GET['invoice_number']) ? $_GET['invoice_number'] : -1;
	$invoice_date = is_date($_GET['invoice_date']) ? format_date($_GET['invoice_date']) : "0000-00-00";
	
	$egn = is_numeric($_GET['egn'])? $_GET['egn'] : -1;
	switch($data_type)
	{
		case "townsfolk":
			$query = "SELECT name FROM townsfolk WHERE egn = '".$egn."'";
			$result = sql_q($query);
			$row = mysql_fetch_row($result);
			$name = $row[0];
			
			$invoices_query = "SELECT invoice_id, number, date, doc_date  FROM invoices WHERE payee_mode = '1' AND payee_identify = '".$egn."'";
			$invoices_result = sql_q($query);
			
			break;
			
		case "company":
			$query = "SELECT name FROM companies WHERE bulstat = '".$bulstat."'";
			$result = sql_q($query);
			$row = mysql_fetch_row($result);
			$name = $row[0];
			
			$invoices_query = "SELECT invoice_id, number, date, doc_date FROM invoices where payee_mode = '2' AND payee_identify = '".$bulstat."'";
			$invoices_result = sql_q($invoices_query);
			break;
			
		case "invoice":
			$query = "SELECT payee_mode, payee_identify FROM invoices WHERE number = '".$invoice_number."' AND date = '".$invoice_date."'";
			$result = sql_q($query);
			$row = mysql_fetch_row($result);
			$payee_mode = $row[0];
			$payee_identify = $row[1];
			
			if($payee_mode == 1)
			{
				$query = "SELECT name FROM townsfolk WHERE egn = '".$payee_identify."'";
				$result = sql_q($query);
				$row = mysql_fetch_row($result);
				$name = $row[0];
			}
			else if($payee_mode == 2)
			{
				$query = "SELECT name FROM companies WHERE bulstat = '".$payee_identify."'";
				$result = sql_q($query);
				$row = mysql_fetch_row($result);
				$name = $row[0];
			}
			
			$invoices_query = "SELECT  invoice_id, number, date, doc_date FROM invoices WHERE number = '".$invoice_number."' AND date = '".$invoice_date."'";
			$invoices_result = sql_q($invoices_query);
			
			break;
		default:
	}
	
	$content_html .= "<html>";
    $content_html .= "<head>";
    $content_html .= "<title>Печат на справка</title>";

    $content_html .= "<meta http-equiv='content-type' content='text/html; charset=windows-1251'>";
    $content_html .= "<meta name='generator' content='HAPedit 3.0'>";

    $content_html .= "<style type='text/css'>";
    $content_html .= "#table { border-color: black; border-style: dotted; border-width: 1 1 0 1 }";

    $content_html .= "td { border-width: 0 0 0 0; border-style: dotted; padding: 0px; font-size: 14px }";
    $content_html .= "td.bottom { border-width: 0 0 1px 0; }";
    $content_html .= "td.left_bottom { border-width: 0 0 1px 1px; }";
    $content_html .= "td.left { border-width: 0 0 0 1px; }";
    $content_html .= "</style>";
    $content_html .= "</head>";
	$content_html .= "<body bgcolor='#FFFFFF'>";
  	$content_html .= "<table width='600px' cellspacing='0' cellpadding='0'>";
    $content_html .= "<tr><td> &nbsp; </td></tr>";
    $content_html .= "<tr>";
      
    $result_data = sql_q("SELECT municipality, ifmuni FROM municipality");
    $row_data = mysql_fetch_array($result_data);
    $res_ifmuni = sql_q("SELECT * FROM elements WHERE nom_code = '65' and cod_cod='".$row_data['ifmuni']."'");
			$row_ifmuni = mysql_fetch_assoc($res_ifmuni);
			$ifmuni=$row_ifmuni['cod_name'];
    
    $content_html .=   "<td width='150px'><u><i><?=$ifmuni?>:</i>".$row_data['municipality']."</u></td>";
    $content_html .=   "<td width='300px' align='center' valign='middle'><font color='blue'><b><i>Справка \"Системни компоненти на фактура\"</i></b></font></td>";
    $content_html .=   "<td width='150px' align='right'><u><i>Дата:</i>".date('d-m-Y')."</u></td>";

    $content_html .= "</tr>";
    $content_html .= "<tr><td>&nbsp;</td></tr>";
  	$content_html .= "</table>";
  	$content_html .= "<table id='table' width='600px' border='0' cellspacing='0' cellpadding='1'>";
    $content_html .= "<tr>";
    $content_html .= "<td class = 'bottom' align='center'>Номер</td>";
    $content_html .= "<td class='left_bottom' align='center'>Дата</td>";
    $content_html .= "<td class='left_bottom' align='center'>Получател</td>";
    $content_html .= "<td class='left_bottom' align='center'>Час на запис в системата</td>";
    $content_html .= "<td class='left_bottom' align='center'>Дата на последна промяна</td>";
    $content_html .= "</tr>";
  	
  	while($row = mysql_fetch_assoc($invoices_result))
  	{
  		$content_html .= "<tr>";
    	$content_html .= "<td class = 'bottom' align='center'>".$row['number']."</td>";
    	$content_html .= "<td class='left_bottom' align='center'>".format_date($row['date'])."</td>";
    	$content_html .= "<td class='left_bottom' align='center'>".(empty($name) ? "&nbsp;" : $name )."</td>";
    	$content_html .= "<td class='left_bottom' align='center'>".date("d.m.Y г. H:i:s ч.", $row['invoice_id'])."</td>";
    	$content_html .= "<td class='left_bottom' align='center'>".format_date($row['doc_date'])."</td>";
    	$content_html .= "</tr>";
  	}
  	
	$content_html .= "</table>";
	$content_html .= "</body>";
	$content_html .= "</html>";
	
	echo $content_html;
?>