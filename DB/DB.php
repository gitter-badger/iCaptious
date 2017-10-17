<?php
namespace iCaptious;

/**
* 
*/
class Database
{
	public $PDO;
	public $DB_Type = 'mysql';

	private $Host;
	private $Database;
	private $User;
	private $Pass;

	protected $Charset = "utf8mb4";

	public $Data;

	const FETCH_ASSOC = \PDO::FETCH_ASSOC;
	const FETCH_NUM = \PDO::FETCH_NUM;
	const FETCH_BOTH = \PDO::FETCH_BOTH;
	const FETCH_OBJ = \PDO::FETCH_OBJ;
	const FETCH_LAZY = \PDO::FETCH_LAZY;

	static $FETCH_DEFAULT = self::FETCH_ASSOC;

	var $exec;
	
	function __construct()
	{
		
	}

	/*
	* Setting up the database
	*/
	public function Setup($host, $database, $user, $pass) {
		if (isset($host) && isset($database) && isset($user) && isset($pass)) {
			$this->Host = $host;
			$this->Database = $database;
			$this->User = $user;
			$this->Pass = $pass;
			$this->Init();
			return true;
		}
		throw new Exception("Setting up the database failed", 1);	
	}

	public function Init() {
		$this->PDO = new \PDO($this->DB_Type.':host='.$this->Host.';dbname='.$this->Database.';charset='.$this->Charset, $this->User, $this->Pass);
		$this->PDO->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
		$this->PDO->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
	}

	public function Query($query) {
		$this->exec = $this->PDO->query($query);
		return $this;
	} 

	public function Exec($query) {
		$this->exec = $this->PDO->exec($query);
		return $this;
	} 

	public function fetch(){
		return $this->exec->fetchAll(self::$FETCH_DEFAULT);
	}

}