<?php

namespace Model;

class Comentarios
{

	/**
	*
	*@var string
	*/

	protected $table_name = 'comentarios';

	/**
	*@var int
	*
	*/

	protected $id;

	/**
	*@var string
	*
	*/
	
	protected $comentario;

	/**
	*@var integer
	*
	*/
	
	protected $usuario;

	/**
	*@var date
	*
	*/

	protected $data_comentario;

	/**
	*@var integer
	*
	*/

	protected $post;

	public function __set($key, $value)
	{
		$this->$key = trim(strip_tags($value));
	}

    public function __get($key)
    {
		return $this->$key;
    }

	public function setData($values)
	{

		foreach($values as $key => $value){
			$this->$key = trim(strip_tags($value));
		}

	}

	public function getArrayCopy()
	{
		return get_object_vars($this);
	}

}































