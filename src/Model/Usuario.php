<?php

namespace Model;

class Usuario
{

	/**
	*
	*@var string
	*/

	protected $table_name = 'usuario';

	/**
	*@var int
	*
	*/

	protected $id;

	/**
	*@var string
	*
	*/
	
	protected $nome;

	/**
	*@var string
	*
	*/
	
	protected $status;

	/**
	*@var string
	*
	*/

	protected $email;

	/**
	*@var string
	*
	*/

	protected $senha;

	/**
	*@var string
	*/
	protected $avatar;

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































