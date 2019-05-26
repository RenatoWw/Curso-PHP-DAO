<?php

class Sql extends PDO {
	private $connection;

	public function __construct(){
		$this->connection = new PDO("mysql:host=localhost;dbname=dbphp7", "root", "");
	}
	public function setParameters($statement, $parameters = array()){
		foreach ($parameters as $key => $value) {
			$this->setParameter($statement, $key, $value);
		}
	}
	public function setParameter($statement, $key, $value){
		$statement->bindParam($key, $value);
	}

	public function query($rawQuery, $parameters = array()){
		$statement = $this->connection->prepare($rawQuery);
		$this->setParameters($statement, $parameters);
		$statement->execute();
		return $statement;
	}
	public function selectData($rawQuery, $parameters = array()):array
	{
		$statement = $this->query($rawQuery, $parameters);
		return $statement->fetchAll(PDO::FETCH_ASSOC);
	}
}
