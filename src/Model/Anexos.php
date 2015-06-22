<?php

namespace Model;

class Anexos
{

	/**
	*
	*@var string
	*/

	protected $table_name = 'anexos';

	/**
	*@var int
	*
	*/

	protected $id;

	/**
	*@var string
	*
	*/
	
	protected $src;

	/**
	*@var bytea
	*
	*/
	
	protected $media;

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