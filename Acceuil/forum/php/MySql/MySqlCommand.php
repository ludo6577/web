<?php

class ParamType
{
    const Integer = "i";
    const Double = "d";
    const String = "s";
    const Bytes = "b";
}

class MySqlCommand 
{	
	private $parametersValues;
	private $parametersTypes;
	private $nbParameters;

	public function __construct(MySqlConnection $connection, $queryText)
	{
		$this->stmt = $connection->prepare($queryText);
		$this->parametersTypes = "";
		$this->parametersValues = array();
		$this->nbParameters = 0;
	}
	
	public function AddParameter($type, $value)
	{
		$this->parametersValues[$this->nbParameters] = $value;
		$this->parametersTypes .= $type; 	
		$this->nbParameters++;
	}	
	
	public function ExecuteQuery() 
	{
		$this->bindParam();
		$this->stmt->execute();
		if($result = $this->stmt->get_result())
		{
			$index=0;
			$Rows = array();
			while ($row = $result->fetch_assoc()) 
			{
				$Rows[$index] = $row;
				$index++;
			}			
			$this->stmt->close();
			$result->free();
			return $Rows;
		}
	}
	
	/*
	 * Please don't look down!
	 * Most akward method to allow multiple parameters
	 */
	private function bindParam()
	{
		if($this->nbParameters == 0)
			return;
		$stmt = $this->stmt;
		call_user_func_array(array($stmt, "bind_param"), $this->refValues(array_merge(array($this->parametersTypes), $this->parametersValues)));
	}
	private function refValues($arr)
	{ 
	    if (strnatcmp(phpversion(),'5.3') >= 0) //Reference is required for PHP 5.3+ ( thx PHP ;) )
	    { 
	        $refs = array(); 
	        foreach($arr as $key => $value) 
	            $refs[$key] = &$arr[$key]; 
	        return $refs; 
	    } 
	    return $arr; 
	} 
	

}