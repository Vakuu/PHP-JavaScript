<?//;
class systemParameters
{
	/* Get and sets values in table system_parameters
	 * A lot of things to do 
	 */
	private $paramValue='';
	private $paramName=''; 
	private $paramArray = array();

	public function setParamValue($paramValue)
	{
		$this->paramValue = $paramValue;
	}
	
	public function getParamValue($param_name, $condition ,$order_clause, $group_clause, $having_clause)
	{
		//връща единична стойност на променлива от system_parameters 
		//$db = new dbclass();
		//$conn =$db->connector();
		$sql = "SELECT DISTINCT PValue as ".$param_name." FROM system_parameters WHERE PName = '".$param_name."'";

		if ($condition!='') $sql .=' AND '.$condition;
		if ($order_clause!='') $sql .=' ORDER BY '.$order_clause;
		if ($group_clause!='') $sql .=' GROUP BY '.$grouop_clause;
		if ($having_clause!='' )$sql .= ' HAVING '.$having_clause;
	
		$param_res =  mysql_query($sql);
		$param_arr= mysql_fetch_array($param_res);		
		$param = $param_arr[$param_name];
		//mysql_close($conn);
		return $this->paramValue=$param;
	}
	
	public function getParamArray($param_name, $condition ,$order_clause, $group_clause, $having_clause)
	{
		$db = new dbclass();
		$conn =$db->connector();
		$sql = "SELECT DISTINCT PValue as ".$param_name." FROM system_parameters WHERE PName = '".$param_name."';";
		if ($condition!='') $sql .=' AND '.$condition;
		if ($order_clause!='') $sql .=' ORDER BY '.$order_clause;
		if ($group_clause!='') $sql .=' GROUP BY '.$grouop_clause;
		if ($having_clause!='' )$sql .= ' HAVING '.$having_clause;	
		$result = mysql_query($sql);
		while($row=mysql_fetch_array($result))
		{	
			$param_arr[] = $row;	
		}
		mysql_close($conn);
		return $this->paramArray = $param_arr;
		
	}
}


?>