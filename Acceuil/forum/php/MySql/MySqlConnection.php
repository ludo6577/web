<?php
class MySqlConnection {
	private $host;
	private $user;
	private $pass;
	private $mysqli;
	private $stmt;
	private $conn = false;
	private $persistant = false;
	
	
	public function __construct($host = 'db499579863.db.1and1.com' /*'localhost''sqletud.univ-mlv.fr'*/, $user = 'lfeltz', $pass = 'Wuunoi6q', $db = 'lfeltz_db') 	// connection function
	{
		$this->host = $host;
		$this->user = $user;
		$this->pass = $pass;
		$this->db = $db;
		
		$this->mysqli = new mysqli($host, $user, $pass, $db);
		if (mysqli_connect_errno()) {   /* check connection */
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		}
		$this->conn = true;
	}
	
	public function __destruct ()// close connection
	{
		if (! $this->conn) // check connection
			die ( "Close error, no connection !" );
		
		if ($this->persistant) {
			$this->conn = false;
		} else {
			//mysqli_kill();
			mysqli_close($this->mysqli);
			$this->conn = false;
		}
	}
	
	public function prepare($cmd){
		$stmt = $this->mysqli->prepare($cmd);
		if(!$stmt)
		{
  			throw new ErrorException($this->mysqli->error, $this->mysqli->errno);
		}
		return $stmt;
	}
	
	
	/*public function execute($cmdText, $value)
	{
		if($this->stmt = $this->mysqli->prepare($cmdText)){
			$this->stmt->bind_param("s", $value);
			$this->stmt->execute();
			
    		$index=0;
			$Rows;
			while ($row = $result->fetch_assoc()) 
			{
				$Rows[index] = $row;
			}
			return $Rows;			
		}
	}*/
}

?>