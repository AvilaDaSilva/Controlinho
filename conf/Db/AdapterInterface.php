<?php 
namespace Db;

interface AdapterInterface
{
	
	public function insert($object);

	public function update($object, $values, $where);
	
	public function fetchAll($table, $where = null, $order = null);
	
	public function find($table, $id);

	public function delete($table, $id);

	public function close();

} 
