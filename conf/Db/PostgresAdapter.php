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

    public function insertPost($values, $file)
    {
        $sql = "INSERT INTO posts (titulo, corpo, usuario, data_post) VALUES ('".$values['titulo']."', '".$values['corpo']."', '".$values['usuario']."', '".$values['dataPost']."')";
        $stmp = $this->db_adapter->prepare($sql);
        $stmp->execute();
        $sql = "SELECT id FROM posts WHERE titulo = '".$values['titulo']."'";
        $stmp = $this->db_adapter->prepare($sql);
        $stmp->execute();
        $id = $stmp->fetchAll();
        $sql = "INSERT INTO anexos (src, media, post) VALUES ('".$values['tipoMidia']."', '$file', ".$id[0]['id'].")";
        $stmp = $this->db_adapter->prepare($sql);
        $stmp->execute();

        return true;
    }

    public function updatePost($values, $file)
    {
        $sql = "UPDATE posts SET (titulo, corpo, usuario, data_post) VALUES ('".$values['titulo']."', '".$values['corpo']."', '".$values['usuario']."', '".$values['dataPost']."')";
        $stmp = $this->db_adapter->prepare($sql);
        $stmp->execute();
        $sql = "SELECT id FROM posts WHERE titulo = '".$values['titulo']."'";
        $stmp = $this->db_adapter->prepare($sql);
        $stmp->execute();
        $id = $stmp->fetchAll();
        $sql = "UPDATE anexos (src, media, post) VALUES ('".$values['tipoMidia']."', '$file', ".$id[0]['id'].")";
        $stmp = $this->db_adapter->prepare($sql);
        $stmp->execute();

        return true;
    }

	public function update($table, $values, $where)
	{
        $stmp = $this->db_adapter->prepare("UPDATE $table SET $values WHERE $where");
        $stmp->execute();
        return true;
	}
	
	public function fetchAll($table, $where = null, $order = null)
	{
		$stmp = $this->db_adapter->prepare("SELECT * FROM $table");
		$stmp->execute();
		return $stmp->fetchAll();
	}

    public function fetchAllPosts()
    {
        $stmp = $this->db_adapter->prepare("SELECT posts.id, posts.titulo, posts.corpo, usuario.status, usuario.nome, anexos.src, anexos.media FROM posts JOIN usuario ON (posts.usuario = usuario.id) JOIN anexos ON (anexos.post = posts.id)");
        $stmp->execute();
        return $stmp->fetchAll();
    }

    public function fetchAllPostsById($id)
    {
        $stmp = $this->db_adapter->prepare("SELECT posts.id, posts.titulo, posts.corpo, usuario.status, usuario.nome, anexos.src, anexos.media FROM posts JOIN usuario ON (posts.usuario = usuario.id) JOIN anexos ON (anexos.post = posts.id) WHERE posts.id = $id");
        $stmp->execute();
        return $stmp->fetchAll();
    }
	
	public function find($table, $id)
	{
        $stmp = $this->db_adapter->prepare("SELECT * FROM $table WHERE id = $id");
        $stmp->execute();
        return $stmp->fetchAll();
	}

    public function findByName($table, $name)
    {
        $stmp = $this->db_adapter->prepare("SELECT * FROM $table WHERE nome = $name");
        $stmp->execute();
        return $stmp->fetchAll();
    }

	public function delete($table, $id)
	{
        $stmp = $this->db_adapter->prepare("DELETE FROM $table WHERE id = $id");
        var_dump($stmp);exit;
        $stmp->execute();
        return true;
	}

    public function deletePost($id)
    {
        $stmp = $this->db_adapter->prepare("DELETE FROM anexos WHERE post = $id");
        $stmp->execute();
        $stmp = $this->db_adapter->prepare("DELETE FROM comentarios WHERE post = $id");
        $stmp->execute();
        $stmp = $this->db_adapter->prepare("DELETE FROM posts WHERE id = $id");
        $stmp->execute();
        return true;
    }

	public function close()
	{
		$this->db_adapter = null;
	}

}
