<?php

namespace App;

use \PDO;

class Database{

	private $DB_DNS;
	private $DB_USER;
	private $DB_PASSWORD;
	private $pdo;

	public function __construct()
	{
		include "config/database.php";

		$this->DB_DNS = $DB_DNS;
		$this->DB_USER = $DB_USER;
		$this->DB_PASSWORD = $DB_PASSWORD;
	}

	private function getPDO()
	{
		if ($this->pdo === null)
		{
			$pdo = new PDO($this->DB_DNS, $this->DB_USER, $this->DB_PASSWORD);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$pdo->setAttribute( PDO::ATTR_EMULATE_PREPARES, false );
			$this->pdo = $pdo;
		}
		return $this->pdo;
	}

	public function query($statement, $class_name = null, $one = false)
	{
		$req = $this->getPDO()->query($statement);
		if ($class_name === null)
		{
			$req->setFetchMode(PDO::FETCH_OBJ);
		}
		else {
			$req->setFetchMode(PDO::FETCH_CLASS, $class_name);
		}
		if ($one == true){
			$datas = $req->fetch();
		}else{
			$datas = $req->fetchAll();
		}
		return $datas;
	}

	public function insert($statement, $at, $class_name = null, $one = false)
	{
		$req = $this->getPDO()->prepare($statement);
		$req->execute($at);
		return;
	}

	public function prepare($statement, $at, $class_name = null, $one = false)
	{
		$req = $this->getPDO()->prepare($statement);
		$req->execute($at);
		if ($class_name === null)
		{
			$req->setFetchMode(PDO::FETCH_OBJ);
		}
		else {
			$req->setFetchMode(PDO::FETCH_CLASS, $class_name);
		}
		if ($one == true){
			$datas = $req->fetch();
		}else{
			$datas = $req->fetchAll();
		}
		return $datas;
	}

}

?>