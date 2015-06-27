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

    public function __set($atrib, $value){
        $this->$atrib = $value;
    }

    public function __get($atrib){
        return $this->$atrib;
    }
    
    public function getArrayCopy()
    {
            return get_object_vars($this);
    }
}































