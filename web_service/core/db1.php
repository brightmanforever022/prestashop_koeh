<?php

class Database {
	
	private $servername = "localhost";
	private $username = "vipdress_user";
	private $password = "sLLrBBvvK2XjHfw4Zbrs";
	private $dbname = "vipdress_main_shop";

	public $conn;
	
	function connection(){
		// Create connection
		$this->conn = new mysqli($servername, $username, $password, $dbname);
		// Check connection
		if ($this->conn->connect_error) {
			die("Connection failed: " . $this->conn->connect_error);
		} 
		return $this->conn;
	}
}
