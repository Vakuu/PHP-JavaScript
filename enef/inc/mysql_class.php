<?	
//require_once('../../inc/conf.php');
class dbclass
{
	private $db_host = "localhost";
	private $db_user = "root";
	private $db_pass = "";
	private $db_name = "mdtaccess";	
	private $field_value = 0;
	
function connector()
{
		
		$this->db_connect_id = @mysql_connect($this->db_host, $this->db_user, $this->db_pass);
			
		if($this->db_connect_id) {
			  mysql_query("SET NAMES CP1251");
		
			
			if($this->db_name != "") {
				$dbselect = @mysql_select_db($this->db_name);
				if(!$dbselect) {
					@mysql_close($this->db_connect_id);
					$this->db_connect_id = $dbselect;
				}
			}
			
			return $this->db_connect_id;
		} else	{
			
			return false;
		}
}

  function createstatement($tip,$table,$fields,$whereclause) {
     $ret = "";

     $select = "SELECT ";
     $insert = "INSERT INTO ";
     $delete = "DELETE ";
     $update = "UPDATE ";

     $for = " FROM ".$table;
     $where = " WHERE ".$whereclause;
     //var_dump($table);
     if (isset($table)) {
         switch ($tip) {
            case "SEL": if (isset($fields)) {
                            $ret = $select;
                            foreach($fields as $key => $value) {
                            	//var_dump($value);
                                 $ret .= $value;
                                 if ($key < count($fields)-1) $ret .= ",";
                            }
                            $ret .= $for;
                            if (isset($whereclause)) $ret .= $where;
                        }
                        
                        break;

            case "INS": if (isset($fields)) {
                            $ret = $insert.$table." (";
                            $values = " VALUES(";
                            foreach($fields as $key => $value) {
                                 $ret .= $value;
                                 $values .= ":".($key+1);

                                 if ($key < count($fields)-1) {
                                    $ret .= ",";
                                    $values .= ",";
                                 }
                            }
                            $ret .= ")".$values.")";
                        }
                        break;

            case "DEL":
                        $ret = $delete.$for;
                        if (isset($whereclause)) $ret .= $where;
                        break;

            case "UPD": if (isset($fields)) {
                            $ret = $update.$table." SET ";
                            foreach($fields as $key => $value) {
                                 $ret .= $value."= :".($key+1);
                                 if ($key < count($fields)-1) $ret .= ",";
                            }
                            if (isset($whereclause)) $ret .= $where;
                        }
                        break;
         }
     }
    // var_dump($ret);
     return $ret;
  }
public function getFieldValue($field_name, $table_name)
	{
		$conn = $this->connector();
		if ($field_name!="")
		{
		$sql = "SELECT ".$field_name." FROM ".$table_name;
		$id = mysql_fetch_array(mysql_query($sql, $conn));
		//var_dump($id);
		$this->field_value = $id[$field_name];
		}
		else $this->field_value = 0;
		$this->conn_close();
		return  $this->field_value;
	}

public function conn_close()
{
	if($this->db_connect_id) {
			if($this->query_result) {
				@mysql_free_result($this->query_result);
			}
			$result = @mysql_close($this->db_connect_id);
			return $result;
		} else	{
			return false;
		}
}

public function mysqlUpQuery($sql)
{
  $conn = $this->connector();
  $res = mysql_query($sql);
  $this->conn_close();
  if (is_null($res)) return FALSE;
  	else return TRUE;
}

public function mysqlDownQuery($sql)
{
  $conn = $this->connector();
  $res = mysql_query($sql);
  $this->conn_close();
  return $res;
}
}
?>