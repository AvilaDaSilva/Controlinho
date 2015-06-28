<?php
namespace Db;

use Db\AdapterInterface as AdapterInterface;

/**
*
*@author Cezar Junior de Souza <cezar08@unochapeco.edu.br>
*/
class PostgresAdapter implements AdapterInterface
{
	/**
	*
	*@var \PDO
	*/
	protected $db_adapter;

	public function __construct()
	{		
		$this->db_adapter = new \PDO("pgsql:host=localhost port=5432 dbname=controlinho user=postgres");	
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
		 return $this->db_adapter->lastInsertId($table.'_id_seq');
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

    public function fetchAllPosts($table = 'posts', $where = null, $order = null)
    {
        $stmp = $this->db_adapter->prepare("SELECT posts.id, posts.titulo, posts.corpo, usuario.status, usuario.nome, anexos.src, anexos.media FROM $table JOIN usuario ON (posts.usuario = usuario.id) JOIN anexos ON (anexos.post = posts.id)");
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
