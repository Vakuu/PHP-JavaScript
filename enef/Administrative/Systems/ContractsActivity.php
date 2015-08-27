<?php
	include("../../inc/conf.php");

	class ContractsActivityManager
    {
        var $contracts_activity_array;
        var $params;

        function ContractsActivityManager($params)
        {
            $this->contracts_activity_array = array('active' => array(), 'inactive' => array());
            $this->params = array();

            $this->params['contr_mode'] = $params['contr_mode'];
            $this->params['action'] = $params['action'];
        }

		function getFinishedContracts()
		{
			$finished_query = "SELECT distinct(c.contr_id), c.contr_numb, c.contr_date, c.contr_state, c.tenant_mode, c.tenant_identify, c.active_status 
								FROM contracts as c, balances as b 
								WHERE c.contr_id = b.contr_id AND c.contr_state in (3,4,6) AND mode = '".$this->params['contr_mode']."' 
								GROUP BY b.contr_id 
								HAVING sum(b.final_balance) = 0
								ORDER BY ROUND(c.contr_numb)";
			$finished_result = sql_q($finished_query);
			while($finished_row = mysql_fetch_assoc($finished_result))
			{
				if($this->CheckFinishedContract($finished_row['contr_id']) === true)
				{
					$active_status = $finished_row['active_status'];
					
					$contract_info = array(
										"contr_id" => $finished_row['contr_id'],
										"contr_numb" => $finished_row['contr_numb'],
										"contr_date" => $finished_row['contr_date'],
										"contr_state" => $finished_row['contr_state'],
										"tenant_mode" => $finished_row['tenant_mode'],
										"tenant_identify" => $finished_row['tenant_identify']
										);
					if($active_status == 1)
					{
						$this->contracts_activity_array['active'][$finished_row['contr_id']] = $contract_info;
					}
					else if ($active_status == 0)
					{
						$this->contracts_activity_array['inactive'][$finished_row['contr_id']] = $contract_info;
					}
				}
			}
		}
		
		function CheckFinishedContract($contr_id)
		{
			$check_flag = false;
			
			$check_final_query = "SELECT * FROM balances WHERE contr_id = '".$contr_id."' AND final_balance <> 0";
			$check_final_result = sql_q($check_final_query);
			if(mysql_num_rows($check_final_result) == 0)
			{
				$year_query = "SELECT MAX(year) as year FROM balances WHERE contr_id = '".$contr_id."'";
				$year_result = sql_q($year_query);
				$year_row = mysql_fetch_assoc($year_result);
				if($year_row['year'] == 0)
				{
					$check_flag = true;
				}
				else
				{
					$month_query = "SELECT MAX(month) as month FROM balances WHERE contr_id = '".$contr_id."' AND year = '".$year_row['year']."'";
					$month_result = sql_q($month_query);
					$month_row = mysql_fetch_assoc($month_result);
					
					$check_prepay_query = "SELECT prepay_amount FROM balances WHERE contr_id = '".$contr_id."' AND year = '".$year_row['year']."' AND month = '".$month_row['month']."'";
					$check_prepay_result = sql_q($check_prepay_query);
					$check_prepay_row = mysql_fetch_assoc($check_prepay_result);
					
					if($check_prepay_row['prepay_amount'] == 0)
					{
						$check_flag = true;
					}
				}
			}
			return $check_flag;
		}

        function saveContractsActivity()
        {
            if($this->params['action'] == 'save')
			{
				$active_contracts = $_POST['active_contracts'];
				$inactive_contracts = $_POST['inactive_contracts'];
				
				$query_array = array();
				if(count($active_contracts) != 0)
				{
					foreach($active_contracts as $contr_id)
					{
						$query = "UPDATE contracts SET active_status = '0' WHERE contr_id = '".$contr_id."'";
						array_push($query_array, $query);
					}
				}
				
				if(count($inactive_contracts) != 0)
				{
					foreach($inactive_contracts as $contr_id)
					{
						$query = "UPDATE contracts SET active_status = '1' WHERE contr_id = '".$contr_id."'";
						array_push($query_array, $query);
					}
				}
				
				if(count($query_array) != 0)
				{
					foreach($query_array as $query)
					{
						sql_q($query);
					}
				}
			}
        }

        function displayActiveContracts()
        {
            $content_html = "";
			
			$content_html .= "<fieldset style = 'width:80%; height:250px; border:solid 3px DarkSeaGreen;'>";
			$content_html .= "<legend align = 'center'><span style = 'color:blue; font-weight:bold;'>Активни приключени договори</span></legend>";
			$content_html .= "<div style = 'width:100%; height:240px; overflow-y:scroll;'>";
			$content_html .= "<table style = 'width:100%; border:solid 1px DarkSeaGreen'>";
			$content_html .= "<tr>";
			$content_html .= "<td style = 'border:solid 1px DarkSeaGreen; color:red; font-weight:bold; text-align:center; width:5%;'>";
			$content_html .= "<input type = 'checkbox' name = 'active_all' value = '' onclick = 'doCheckAll(this.checked, \"fcontracts_activity\", \"active_contracts[]\");'>";
			$content_html .= "</td>";
			$content_html .= "<td style = 'border:solid 1px DarkSeaGreen; color:red; font-weight:bold; text-align:center; width:15%;'>Номер</td>";
			$content_html .= "<td style = 'border:solid 1px DarkSeaGreen; color:red; font-weight:bold; text-align:center; width:15%;'>Дата</td>";
			$content_html .= "<td style = 'border:solid 1px DarkSeaGreen; color:red; font-weight:bold; text-align:center; width:35%;'>Наемател</td>";
			$content_html .= "<td style = 'border:solid 1px DarkSeaGreen; color:red; font-weight:bold; text-align:center; width:15%;'>ЕГН/БУЛСТАТ</td>";
			$content_html .= "<td style = 'border:solid 1px DarkSeaGreen; color:red; font-weight:bold; text-align:center; width:15%;'>Състояние</td>";
			$content_html .= "</tr>";
			
			
			$contracts_array = $this->contracts_activity_array['active'];
			
			foreach($contracts_array as $contract)
			{
				$content_html .= "<tr>";
				$content_html .= "<td style = 'border:solid 1px DarkSeaGreen; text-align:center;'><input type = 'checkbox' name = 'active_contracts[]' value = '".$contract['contr_id']."'></td>";
				$content_html .= "<td style = 'border:solid 1px DarkSeaGreen;'>".$contract['contr_numb']."</td>";
				$content_html .= "<td style = 'border:solid 1px DarkSeaGreen;'>".format_date($contract['contr_date'])."</td>";
				
				switch($contract['tenant_mode'])
				{
					case 1:
						$townsfolk_query = "SELECT name FROM townsfolk WHERE egn = '".$contract['tenant_identify']."'";
						$townsfolk_result = sql_q($townsfolk_query);
						$townsfolk_row = mysql_fetch_row($townsfolk_result);
						$name = $townsfolk_row[0];
						break;
					case 2:
						$company_query = "SELECT name FROM companies WHERE bulstat = '".$contract['tenant_identify']."'";
						$company_result = sql_q($company_query);
						$company_row = mysql_fetch_row($company_result);
						$name =$company_row[0];
						break;
				}
				
				$content_html .= "<td style = 'border:solid 1px DarkSeaGreen;'>".$name."</td>";
				$content_html .= "<td style = 'border:solid 1px DarkSeaGreen;'>".$contract['tenant_identify']."</td>";
				
				$elem_query = "SELECT * FROM elements WHERE nom_code = '17' AND cod_cod = '".$contract['contr_state']."'";
				$elem_result = sql_q($elem_query);
				$elem_row = mysql_fetch_assoc($elem_result);
				
				$content_html .= "<td style = 'border:solid 1px DarkSeaGreen;'>".$elem_row['cod_name']."</td>";
				$content_html .= "</tr>";
			}
			
			$content_html .= "</table>";
			$content_html .= "</div>";
			$content_html .= "</fieldset>";
			
            return $content_html;
        }
		
		function displayInactiveContracts()
		{
			$content_html = "";
			
			$content_html .= "<fieldset style = 'width:80%; height:250px; border:solid 3px DarkSeaGreen;'>";
			$content_html .= "<legend align = 'center'><span style = 'color:blue; font-weight:bold;'>Неактивни приключени договори</span></legend>";
			$content_html .= "<div style = 'width:100%; height:240px; overflow-y:scroll;'>";
			$content_html .= "<table style = 'width:100%; border:solid 1px DarkSeaGreen'>";
			$content_html .= "<tr>";
			$content_html .= "<td style = 'border:solid 1px DarkSeaGreen; color:red; font-weight:bold; text-align:center; width:5%;'>";
			$content_html .= "<input type = 'checkbox' name = 'inactie_all' value = '' onclick = 'doCheckAll(this.checked, \"fcontracts_activity\", \"inactive_contracts[]\");'>";
			$content_html .= "</td>";
			$content_html .= "<td style = 'border:solid 1px DarkSeaGreen; color:red; font-weight:bold; text-align:center; width:15%;'>Номер</td>";
			$content_html .= "<td style = 'border:solid 1px DarkSeaGreen; color:red; font-weight:bold; text-align:center; width:15%;'>Дата</td>";
			$content_html .= "<td style = 'border:solid 1px DarkSeaGreen; color:red; font-weight:bold; text-align:center; width:35%;'>Наемател</td>";
			$content_html .= "<td style = 'border:solid 1px DarkSeaGreen; color:red; font-weight:bold; text-align:center; width:15%;'>ЕГН/БУЛСТАТ</td>";
			$content_html .= "<td style = 'border:solid 1px DarkSeaGreen; color:red; font-weight:bold; text-align:center; width:15%;'>Състояние</td>";
			$content_html .= "</tr>";
			
			$contracts_array = $this->contracts_activity_array['inactive'];
			
			foreach($contracts_array as $contract)
			{
				$content_html .= "<tr>";
				$content_html .= "<td style = 'border:solid 1px DarkSeaGreen; text-align:center;'><input type = 'checkbox' name = 'inactive_contracts[]' value = '".$contract['contr_id']."'></td>";
				$content_html .= "<td style = 'border:solid 1px DarkSeaGreen;'>".$contract['contr_numb']."</td>";
				$content_html .= "<td style = 'border:solid 1px DarkSeaGreen;'>".format_date($contract['contr_date'])."</td>";
				
				switch($contract['tenant_mode'])
				{
					case 1:
						$townsfolk_query = "SELECT name FROM townsfolk WHERE egn = '".$contract['tenant_identify']."'";
						$townsfolk_result = sql_q($townsfolk_query);
						$townsfolk_row = mysql_fetch_row($townsfolk_result);
						$name = $townsfolk_row[0];
						break;
					case 2:
						$company_query = "SELECT name FROM companies WHERE bulstat = '".$contract['tenant_identify']."'";
						$company_result = sql_q($company_query);
						$company_row = mysql_fetch_row($company_result);
						$name =$company_row[0];
						break;
				}
				
				$content_html .= "<td style = 'border:solid 1px DarkSeaGreen;'>".$name."</td>";
				$content_html .= "<td style = 'border:solid 1px DarkSeaGreen;'>".$contract['tenant_identify']."</td>";
				
				$elem_query = "SELECT * FROM elements WHERE nom_code = '17' AND cod_cod = '".$contract['contr_state']."'";
				$elem_result = sql_q($elem_query);
				$elem_row = mysql_fetch_assoc($elem_result);
				
				$content_html .= "<td style = 'border:solid 1px DarkSeaGreen;'>".$elem_row['cod_name']."</td>";
				$content_html .= "</tr>";
			}
			
			$content_html .= "</table>";
			$content_html .= "</div>";
			$content_html .= "</fieldset>";
			
            return $content_html;
		}

        function displayContractsActivity()
        {

            if($_POST['action'] == 'save')
            {
                $result = $this->saveContractsActivity();
            }
			
			$this->getFinishedContracts();

            $content_html = "";
        
            $content_html .= "<HTML>";
            $content_html .= "<HEAD>";
            $content_html .= "<META http-equiv = 'content-type' content = 'text/html; charset:WINDOWS-1251;'>";
            $content_html .= "<TITLE>Задаване активност на договори</TITLE>";
            $content_html .= "</HEAD>";
            $content_html .= "<SCRIPT language = 'JavaScript' src = '../JFunctions.js'></SCRIPT>";
            $content_html .= "<SCRIPT language = 'JavaScript'>";
            $content_html .= "function ShowContracts(object)";
            $content_html .= "{";
            $content_html .= "document.forms[\"fcontracts_activity\"].elements[\"contr_mode\"].value = object.value;";
            $content_html .= "document.forms[\"fcontracts_activity\"].elements[\"action\"].value = \"view\";";
            $content_html .= "document.forms[\"fcontracts_activity\"].submit();";
            $content_html .= "}";
			$content_html .= "function doCheckAll(check_status, form_name, action_name)";
            $content_html .= "{";
            $content_html .= "elements = document.forms[form_name].elements;";
            $content_html .= "for(i = 0; i < elements.length; i++)";
            $content_html .= "{";
			$content_html .= "if(elements[i].name == action_name && elements[i].disabled == false)";
			$content_html .= "{elements[i].checked = check_status;}";
			$content_html .= "}";
            $content_html .= "}";
            $content_html .= "</SCRIPT>";
            $content_html .= "<BODY background = '../Images/Stone.jpg'>";

            $content_html .= "<form name = 'fcontracts_activity' action = 'ContractsActivity.php' method = 'post'>";
            $content_html .= "<input type = 'hidden' name = 'contr_mode' value = '".$this->params['contr_mode']."'>";
            $content_html .= "<input type = 'hidden' name = 'action' value = '".$this->params['action']."'>";

            $content_html .= "<table width = '100%' height = '98%' cellpadding = '0' cellspacing = '0' align = 'center'>";

            $content_html .= "<tr><td width = '100%' align = 'center'>";
            $content_html .= "<span style = 'font-weight:bold; font-size:16px; color:blue;'>Активност за договори тип </span>";

            $content_html .= "<select name = 'contr_mode_select' style = 'text-align:center;' onChange = 'ShowContracts(this);'>";
            $content_html .= "<option value = '0'>&nbsp;</option>";

            $contr_mode_query = "SELECT * FROM elements where nom_code = '07'";
            $contr_mode_result = sql_q($contr_mode_query);
            while($contr_mode_row = mysql_fetch_assoc($contr_mode_result))
            {
                $contr_mode_cod = $contr_mode_row['cod_cod'];
				$contr_mode_name = $contr_mode_row['cod_name'];

                $content_html .= "<option value = '".$contr_mode_cod."'";
                if($contr_mode_cod == $this->params['contr_mode'])
				{
                    $content_html .= " selected ";
                }
                $content_html .= ">".$contr_mode_name."</option>";
            }

            $content_html .= "</select>";

            $content_html .= "</td></tr>";
            $content_html .= "<tr><td width = '100%' height = '85%' align = 'center'>";

            $content_html .= $this->displayActiveContracts();
			
			$content_html .= "<BR><BR><BR>";
			
			$content_html .= $this->displayInactiveContracts();

            $content_html .= "</td></tr>";

            $content_html .= "<tr><td width = '100%' align = 'right'>";
            $content_html .= "<img src = '../Images/Add.gif' style = 'cursor:pointer;' onclick = 'document.forms[\"fcontracts_activity\"].elements[\"action\"].value = \"save\"; document.forms[\"fcontracts_activity\"].submit();'>";    
            $content_html .= "<img src = '../Images/Home.gif' style = 'cursor:pointer;' onclick = 'window.location.href = \"../Index.html\"'>";
            $content_html .= "</td></tr>";

            $content_html .= "</table>";

            $content_html .= "</form>";
            $content_html .= "</BODY>";
            $content_html .= "</HTML>";

            echo "".$content_html;
        }
    }

    $invoice_ranges_manager = new ContractsActivityManager($_REQUEST);
    $invoice_ranges_manager->displayContractsActivity();

?>