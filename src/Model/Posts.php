<?php

namespace Model;

class Posts
{

	/**
	*
	*@var string
	*/

	protected $table_name = 'posts';

	/**
	*@var int
	*
	*/

	protected $id;

	/**
	*@var string
	*
	*/
	
	protected $titulo;

	/**
	*@var string
	*
	*/
	
	protected $corpo;

	/**
	*@var integer
	*
	*/

	protected $usuario;

	/**
	*@var date
	*
	*/

	protected $data_post;

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































