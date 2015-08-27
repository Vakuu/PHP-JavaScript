<?php
    include("../../inc/conf.php");


    class InvoiceRangeManager
    {
        var $invoice_ranges_array;
        var $params;

        function InvoiceRangeManager($params)
        {
            $this->invoice_ranges_array = array();
            $this->params = array();

            $this->params['doc_type'] = $params['doc_type'];
            $this->params['action'] = $params['action'];

            if($this->params['action'] == 'save')
            {
                $this->params['range_id'] =$params['range_id'];
            }
            else if ($this->params['action'] == 'update' || $this->params['action'] == 'delete')
            {
                $this->params['range_id'] = $params['range_id'];
                $this->params['range_start_num'] = $params['range_start_num'];
                $this->params['range_end_num'] = $params['range_end_num'];
                $this->params['range_doc_type'] = $params['range_doc_type'];
            }
        }

        function getInvoiceRanges()
        {
            $query = "SELECT * FROM invoice_ranges ORDER BY range_doc_type";
            $result = sql_q($query);

            while($row = mysql_fetch_array($result))
            {
                if(empty($this->invoice_ranges_array[$row['range_doc_type']]))
                {
                    $this->invoice_ranges_array[$row['range_doc_type']] = array();
                }
                array_push($this->invoice_ranges_array[$row['range_doc_type']], $row);
            }

            $num_query = "SELECT * FROM pay_documents";
            $num_result = sql_q($num_query);
            while($num_row = mysql_fetch_assoc($num_result))
            {
                $doc_type = $num_row['doc_type'];
                $last_numb = $num_row['last_numb'];
                $name = $num_row['name'];
                $status = $num_row['status'];

                $this->invoice_ranges_array[$doc_type]['last_numb'] = $last_numb;
                $this->invoice_ranges_array[$doc_type]['name'] = $name;
                $this->invoice_ranges_array[$doc_type]['status'] = $status;
            }
        }

        function saveInvoiceRange()
        {
            if($_POST['action'] != "save")
            {
                return;
            }
            if($_POST['new_doc_type'] && $_POST['new_action'])
            {
                $range_doc_type = $_POST['new_doc_type'];
                $new_range_start_num = $_POST['new_range_start_num'];
                $new_range_end_num = $_POST['new_range_end_num'];

                if($new_range_start_num > $new_range_end_num)
                {
                    return array("result" =>false, "reason" => "Крайната стойност е по-малка от началната!");
                }

                $select_query = "SELECT range_start_num, range_end_num FROM invoice_ranges WHERE range_doc_type = '".$range_doc_type."' ORDER BY range_id ASC";
                $select_result = sql_q($select_query);
                while($select_row = mysql_fetch_row($select_result))
                {
                    if(!($select_row[0] > $new_range_end_num || $select_row[1] < $new_range_start_num))
                    {
                        return array("result" => false, "reason" => "Въведеният интервал се застъпва с [".$select_row[0].",".$select_row[1]."]!");
                    }
                }

                $insert_query = "INSERT INTO invoice_ranges (range_start_num, range_end_num, range_doc_type)
                              VALUES('".$new_range_start_num."','".$new_range_end_num."','".$range_doc_type."')";
                $insert_result = sql_q($insert_query);

                return array("result" => true, "reason" => "Записът завърши успешно!");
            }
            else if ($_POST['update_doc_type'] && $_POST['update_action'])
            {
                $range_id = $this->params['range_id'];
                $range_doc_type = $_POST['update_doc_type'];
                $update_range_start_num = $_POST['update_range_start_num'];
                $update_range_end_num = $_POST['update_range_end_num'];

                if($update_range_start_num > $update_range_end_num)
                {
                    return array("result" =>false, "reason" => "Крайната стойност е по-малка от началната!");
                }

                $select_query = "SELECT range_start_num, range_end_num FROM invoice_ranges WHERE range_doc_type = '".$range_doc_type."' AND range_id <> '".$range_id."' ORDER BY range_id ASC";
                $select_result = sql_q($select_query);
                while($select_row = mysql_fetch_row($select_result))
                {
                    if(!($select_row[0] > $update_range_end_num || $select_row[1] < $update_range_start_num))
                    {
                        return array("result" => false, "reason" => "Въведеният интервал се застъпва с [".$select_row[0].",".$select_row[1]."]!");
                    }
                }

                $update_query = "UPDATE invoice_ranges SET range_start_num = '".$update_range_start_num."',
                                                           range_end_num = '".$update_range_end_num."'
                                                       WHERE range_id = '".$range_id."'
                                                           AND range_doc_type = '".$range_doc_type."'";
                $update_result = sql_q($update_query);

                return array("result" => true, "reason" => "Записът завърши успешно!");
            }
        }

        function deleteInvoiceRange()
        {
            $range_id = $this->params['range_id'];
            $range_start_num = $this->params['range_start_num'];
            $range_end_num = $this->params['range_end_num'];
            $range_doc_type = $this->params['range_doc_type'];

            if(empty($range_id) || empty($range_start_num) || empty($range_end_num) || empty($range_doc_type))
            {
                return array("result" => false, "reason" => "Не съществува такъв диапазон!");
            }

            $pay_doc_query = "SELECT last_numb FROM pay_documents WHERE doc_type = '".$range_doc_type."'";
            $pay_doc_result = sql_q($pay_doc_query);
            $pay_doc_row = mysql_fetch_row($pay_doc_result);
            $last_numb = $pay_doc_row[0];

            if($last_numb >= $range_start_num)
            {
                return array("result" => false, "reason" => "Диапазонът не може да бъде изтрит, понеже вече е заклщчен от системата!<BR>(последният зает номер е по-голям от първия номер в посочения диапазон)");
            }

            $delete_query = "DELETE FROM invoice_ranges WHERE range_id = '".$range_id."'
                          AND range_start_num = '".$range_start_num."' AND range_end_num = '".$range_end_num."'
                          AND range_doc_type = '".$range_doc_type."'";
            $delete_result = sql_q($delete_query);
            if(mysql_affected_rows() == 0)
            {
                return array("result" => false, "reason" => "Не съществува такъв диапазон!");    
            }
            return array("result" => true, "reason" => "Изтриването завърши успешно!");
        }

        function displayAddNewForm()
        {
            $content_html = "";

            $content_html .= "<BR><BR>";
            $content_html .= "<span style = 'font-weight:bold; font-size:18px; color:blue;'>Резервиране на нов диапазон:</span>";
            $content_html .= "<input type = 'hidden' name = 'new_doc_type' value = '".$this->params['doc_type']."'>";
            $content_html .= "<input type = 'hidden' name = 'new_action' value = '".$this->params['action']."'>";
            $content_html .= "<table style = 'width:700px; border-style:solid; border-width:1; border-color:DarkSeaGreen;'>";
            $content_html .= "<tr>";
            $content_html .= "<td style = 'border-style:solid; border-width:1; border-color:DarkSeaGreen;' align = 'center'>Начален номер</td>";
            $content_html .= "<td style = 'border-style:solid; border-width:1; border-color:DarkSeaGreen;' align = 'center'>Краен номер</td>";
            $content_html .= "</tr>";
            $content_html .= "<tr>";
            $content_html .= "<td style = 'border-style:solid; border-width:1; border-color:DarkSeaGreen;' align = 'center'>";
            $content_html .= "<input type = 'text' name = 'new_range_start_num' value = '' size = '15' maxlength = '10' onKeyPress = 'ValidateKeyNumb(this);'>";
            $content_html .= "</td>";
            $content_html .= "<td style = 'border-style:solid; border-width:1; border-color:DarkSeaGreen;' align = 'center'>";
            $content_html .= "<input type = 'text' name = 'new_range_end_num' value = '' size = '15' maxlength = '10' onKeyPress = 'ValidateKeyNumb(this);'>";
            $content_html .= "</td>";
            $content_html .= "</tr>";
            $content_html .= "</table>";

            return $content_html;
        }

        function displayUpdateForm()
        {
            $pay_doc_query = "SELECT last_numb, status FROM pay_documents WHERE doc_type = '".$this->params['range_doc_type']."'";
            $pay_doc_result = sql_q($pay_doc_query);
            $pay_doc_row = mysql_fetch_row($pay_doc_result);
            $pay_last_numb = $pay_doc_row[0];
            $pay_status = $pay_doc_row[1];

            if($pay_status == 'inactive')
            {
                $content_html .= "ГРЕШКА! Не можете да редактирате диапазон за неактивен кочан !";
            }
            else if ($pay_last_numb > $this->params['range_end_num'])
            {
                $content_html .= "ГРЕШКА! Не можете да променяте диапазона, понеже последният зает номер от системата е по-голям от този на интервала!";
            }
            else
            {

                $content_html = "";

                $content_html .= "<BR><BR>";
                $content_html .= "<span style = 'font-weight:bold; font-size:18px; color:blue;'>Редактиране на диапазон:</span>";
                $content_html .= "<input type = 'hidden' name = 'update_doc_type' value = '".$this->params['doc_type']."'>";
                $content_html .= "<input type = 'hidden' name = 'update_action' value = '".$this->params['action']."'>";
                $content_html .= "<input type = 'hidden' name = 'range_id' value = '".$this->params['range_id']."'>";
                $content_html .= "<table style = 'width:700px; border-style:solid; border-width:1; border-color:DarkSeaGreen;'>";
                $content_html .= "<tr>";
                $content_html .= "<td style = 'border-style:solid; border-width:1; border-color:DarkSeaGreen;' align = 'center'>Начален номер</td>";
                $content_html .= "<td style = 'border-style:solid; border-width:1; border-color:DarkSeaGreen;' align = 'center'>Краен номер</td>";
                $content_html .= "</tr>";
                $content_html .= "<tr>";
                $content_html .= "<td style = 'border-style:solid; border-width:1; border-color:DarkSeaGreen;' align = 'center'>";
                $content_html .= "<input type = 'text' name = 'update_range_start_num' value = '".$this->params['range_start_num']."' size = '15' maxlength = '10' onKeyPress = 'ValidateKeyNumb(this);'>";
                $content_html .= "</td>";
                $content_html .= "<td style = 'border-style:solid; border-width:1; border-color:DarkSeaGreen;' align = 'center'>";
                $content_html .= "<input type = 'text' name = 'update_range_end_num' value = '".$this->params['range_end_num']."' size = '15' maxlength = '10' onKeyPress = 'ValidateKeyNumb(this);'>";
                $content_html .= "</td>";
                $content_html .= "</tr>";
                $content_html .= "</table>";

            }

            return $content_html;    
        }

        function displayInvoiceRanges()
        {

            if($_POST['action'] == 'save')
            {
                $result = $this->saveInvoiceRange();
            }
            else if($_POST['action'] == 'delete')
            {
                $result = $this->deleteInvoiceRange();
            }

            $this->getInvoiceRanges();

            $content_html = "";
        
            $content_html .= "<HTML>";
            $content_html .= "<HEAD>";
            $content_html .= "<META http-equiv = 'content-type' content = 'text/html; charset:WINDOWS-1251;'>";
            $content_html .= "<TITLE>Запазване на диапазон</TITLE>";
            $content_html .= "</HEAD>";
            $content_html .= "<SCRIPT language = 'JavaScript' src = '../JFunctions.js'></SCRIPT>";
            $content_html .= "<SCRIPT language = 'JavaScript'>";
            $content_html .= "function ShowRanges(object)";
            $content_html .= "{";
            $content_html .= "document.forms[\"finvoice_ranges\"].elements[\"doc_type\"].value = object.value;";
            $content_html .= "document.forms[\"finvoice_ranges\"].elements[\"action\"].value = \"view\";";
            $content_html .= "document.forms[\"finvoice_ranges\"].submit();";
            $content_html .= "}";
            $content_html .= "</SCRIPT>";
            $content_html .= "<BODY background = '../Images/Stone.jpg' onload = 'document.forms[\"finvoice_ranges\"].elements[\"doc_type_select\"].focus();'>";

            $content_html .= "<form name = 'finvoice_ranges' action = 'InvoiceRangeManager.php' method = 'post'>";
            $content_html .= "<input type = 'hidden' name = 'doc_type' value = '".$this->params['doc_type']."'>";
            $content_html .= "<input type = 'hidden' name = 'action' value = '".$this->params['action']."'>";

            $content_html .= "<input type = 'hidden' name = 'range_id' value = '".$this->params['range_id']."'>";
            $content_html .= "<input type = 'hidden' name = 'range_start_num' value = '".$this->params['range_start_num']."'>";
            $content_html .= "<input type = 'hidden' name = 'range_end_num' value = '".$this->params['range_end_num']."'>";
            $content_html .= "<input type = 'hidden' name = 'range_doc_type' value = '".$this->params['range_doc_type']."'>";

            $content_html .= "<table width = '100%' height = '98%' cellpadding = '0' cellspacing = '0' align = 'center'>";

            $content_html .= "<tr><td width = '100%' align = 'center'>";
            $content_html .= "<span style = 'font-weight:bold; font-size:16px; color:blue;'>Запазени номера за  </span>";

            $content_html .= "<select name = 'doc_type_select' style = 'text-align:center;' onChange = 'ShowRanges(this);'>";
            $content_html .= "<option value = '0'>&nbsp;</option>";

            $pay_doc_query = "SELECT * FROM pay_documents";
            $pay_doc_result = sql_q($pay_doc_query);
            while($pay_doc_row = mysql_fetch_assoc($pay_doc_result))
            {
                $pay_name = $pay_doc_row['name'];
                $pay_doc_type = $pay_doc_row['doc_type'];
                $pay_last_numb = $pay_doc_row['last_numb'];
                $pay_status = $pay_doc_row['status'];

                if($pay_status == 'active')
                {
                    $content_html .= "<option value = '".$pay_doc_type."'";
                    if($pay_doc_type == $this->params['doc_type'])
                    {
                        $content_html .= " selected ";
                    }
                    $content_html .= ">".$pay_name."&nbsp;-&nbsp;".$pay_last_numb."</option>";
                }
            }

            $content_html .= "</select>";

            $content_html .= "</td></tr>";
            $content_html .= "<tr><td width = '100%' height = '85%' align = 'center'>";

            $content_html .= "<div style = 'width:700px; height:300px; overflow-y:scroll; border-style:solid; border-width:1; border-color:DarkSeaGreen;'>";

            $content_html .= "<table style = 'width:100%; border-style:solid; border-width:1; border-color:DarkSeaGreen;'>";

            $content_html .= "<tr>";
            $content_html .= "<td style = 'border-style:solid; border-width:1; border-color:DarkSeaGreen; color:red;' align = 'center' color = 'red'>";
            $content_html .= "№";
            $content_html .= "</td>";
            $content_html .= "<td style = 'border-style:solid; border-width:1; border-color:DarkSeaGreen; color:red;' align = 'center' color = 'red'>";
            $content_html .= "Начален номер";
            $content_html .= "</td>";
            $content_html .= "<td style = 'border-style:solid; border-width:1; border-color:DarkSeaGreen; color:red;' align = 'center' color = 'red'>";
            $content_html .= "Краен номер";
            $content_html .= "</td>";
            $content_html .= "<td style = 'border-style:solid; border-width:1; border-color:DarkSeaGreen; color:red;' align = 'center' color = 'red'>";
            $content_html .= "&nbsp;";
            $content_html .= "</td>";
            $content_html .= "</tr>";

            $ranges_array = $this->invoice_ranges_array[$this->params['doc_type']];
            $last_numb = $ranges_array['last_numb'];
            $doc_type_name = $ranges_array['name'];
            $doc_type_status = $ranges_array['status'];
            if(!empty($ranges_array[0]))
            {
                foreach($ranges_array as $key => $value)
                {
                    if(!is_array($value))
                    {
                        continue;
                    }
                    $content_html .= "<tr>";
                    $content_html .= "<td style = 'border-style:solid; border-width:1; border-color:DarkSeaGreen; color:blue;' align = 'center'>";
                    $content_html .= "".$value['range_id'];
                    $content_html .= "</td>";
                    $content_html .= "<td style = 'border-style:solid; border-width:1; border-color:DarkSeaGreen; color:blue;' align = 'center'>";
                    $content_html .= "".$value['range_start_num'];
                    $content_html .= "</td>";
                    $content_html .= "<td style = 'border-style:solid; border-width:1; border-color:DarkSeaGreen; color:blue;' align = 'center'>";
                    $content_html .= "".$value['range_end_num'];
                    $content_html .= "</td>";
                    $content_html .= "<td style = 'border-style:solid; border-width:1; border-color:DarkSeaGreen; color:blue;' align = 'center'>";
                    $content_html .= "<input type = 'radio' name = 'edit_info'
                                  onClick = 'document.forms[\"finvoice_ranges\"].elements[\"range_id\"].value = \"".$value['range_id']."\";
                                            document.forms[\"finvoice_ranges\"].elements[\"range_start_num\"]. value = \"".$value['range_start_num']."\";
                                            document.forms[\"finvoice_ranges\"].elements[\"range_end_num\"].value = \"".$value['range_end_num']."\";
                                            document.forms[\"finvoice_ranges\"].elements[\"range_doc_type\"].value = \"".$value['range_doc_type']."\"'>";
                    $content_html .= "</td>";
                    $content_html .= "</tr>";
                }
            }
            else
            {
                $content_html .= "<tr>";
                $content_html .= "<td colspan = '4' style = 'border-style:solid; border-width:1; border-color:DarkSeaGreen; font-weight:bold; font-size:14px; color:red;' align = 'center'>";
                $content_html .= "Няма резервирани номера за този кочан.";
                $content_html .= "</td>";
                $content_html .= "</tr>";
            }

            $content_html .= "</table>";

            $content_html .= "</div>";

            if(!empty($this->params['doc_type']))
            {
                switch($this->params['action'])
                {
                    case "new":
                         $content_html .= $this->displayAddNewForm();
                         break;
                    case "update":
                         $content_html .= $this->displayUpdateForm();
                         break;
                    case "save":
                    case "delete":
                         if($result['result'] === false)
                         {
                         $content_html .= "<BR><BR>ГРЕШКА! ".$result['reason'];
                         }
                         else if($result['result'] === true)
                         {
                         $content_html .= "<BR><BR>ОК! ".$result['reason'];
                         }
                         break;
                }
            }

            $content_html .= "</td></tr>";

            $content_html .= "<tr><td width = '100%' align = 'right'>";
            switch($this->params['action'])
            {
                case 'view':
                case 'save':
                case 'delete':
                     if($this->params['doc_type'] != 0)
                     {
                         $content_html .= "<img src = '../Images/Insert.gif' style = 'cursor:pointer;' onclick = 'document.forms[\"finvoice_ranges\"].elements[\"action\"].value = \"new\"; document.forms[\"finvoice_ranges\"].submit();'>";
                         $content_html .= "<img src = '../Images/Edit.gif' style = 'cursor:pointer;' onclick = 'document.forms[\"finvoice_ranges\"].elements[\"action\"].value = \"update\"; document.forms[\"finvoice_ranges\"].submit();'>";
                         $content_html .= "<img src = '../Images/Delete.gif' style = 'cursor:pointer;' onclick = 'document.forms[\"finvoice_ranges\"].elements[\"action\"].value = \"delete\"; document.forms[\"finvoice_ranges\"].submit();'>";
                     }
                     break;
                case 'new':
                     $content_html .= "<img src = '../Images/Add.gif' style = 'cursor:pointer;' onclick = 'document.forms[\"finvoice_ranges\"].elements[\"action\"].value = \"save\"; document.forms[\"finvoice_ranges\"].submit();'>";
                     $content_html .= "<img src = '../Images/Edit.gif' style = 'cursor:pointer;' onclick = 'document.forms[\"finvoice_ranges\"].elements[\"action\"].value = \"update\"; document.forms[\"finvoice_ranges\"].submit();'>";
                     $content_html .= "<img src = '../Images/Delete.gif' style = 'cursor:pointer;' onclick = 'document.forms[\"finvoice_ranges\"].elements[\"action\"].value = \"delete\"; document.forms[\"finvoice_ranges\"].submit();'>";
                     break;
                case 'update':
                     $content_html .= "<img src = '../Images/Add.gif' style = 'cursor:pointer;' onclick = 'document.forms[\"finvoice_ranges\"].elements[\"action\"].value = \"save\"; document.forms[\"finvoice_ranges\"].submit();'>";
                     $content_html .= "<img src = '../Images/Insert.gif' style = 'cursor:pointer;' onclick = 'document.forms[\"finvoice_ranges\"].elements[\"action\"].value = \"new\"; document.forms[\"finvoice_ranges\"].submit();'>";
                     $content_html .= "<img src = '../Images/Delete.gif' style = 'cursor:pointer;' onclick = 'document.forms[\"finvoice_ranges\"].elements[\"action\"].value = \"delete\"; document.forms[\"finvoice_ranges\"].submit();'>";
                     break;
            }
            $content_html .= "<img src = '../Images/Home.gif' style = 'cursor:pointer;' onclick = 'window.location.href = \"../Index.html\"'>";
            $content_html .= "</td></tr>";

            $content_html .= "</table>";

            $content_html .= "</form>";
            $content_html .= "</BODY>";
            $content_html .= "</HTML>";

            echo "".$content_html;
        }
    }

    $invoice_ranges_manager = new InvoiceRangeManager($_REQUEST);
    $invoice_ranges_manager->displayInvoiceRanges();
?>