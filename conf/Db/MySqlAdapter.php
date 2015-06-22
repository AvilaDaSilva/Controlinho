<?php
namespace Db;

use Db\AdapterInterface as AdapterInterface;

/**
*
*@author Cezar Junior de Souza <cezar08@unochapeco.edu.br>
*/
class MySqlAdapter implements AdapterInterface
{
	/**
	*
	*@var \PDO
	*/
	protected $db_adapter;

	public function __construct()
	{		
		$this->db_adapter = new \PDO("mysql:host=localhost;dbname=test", "userphp");	
	}

	/**
	*
	*@param string $table
	*@param object $object
	*@return integer
	*/
	public function insert($object)
	{	
		$table = $object->table_name;		
		$array = $object->getArrayCopy();
		unset($array['id']);
		unset($array['table_name']);
		$fields = implode(',', array_keys($array));
		$values = ':'.implode(',:', array_keys($array));
		$sql = "INSERT INTO $table ($fields) VALUES ($values)";				
		$stmp = $this->db_adapter->prepare($sql);
		foreach($array as $key => $value){
			$stmp->bindValue(":$key", $value);
		}
		 $stmp->execute();	

		 return $this->db_adapter->lastInsertId();
	}

	public function update($table, $values, $where)
	{

	}
	
	public function fetchAll($table, $where = null, $order = null)
	{
		$stmp = $this->db_adapter->prepare("SELECT * FROM $table");
		$stmp->execute();
		return $stmp->fetchAll();
	}
	
	public function find($table, $id)
	{

	}

	public function delete($table, $id)
	{

	}

	public function close()
	{
		$this->db_adapter = null;
	}

}
