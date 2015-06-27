<?php
namespace Controller;

use \Db\DbAdapter as DbAdapter;
use \Model\Usuario as Usuario;

class Usuarios
{

	public function retrieveAction()
	{
	}

	public function saveAction()
	{  
            if($_POST)
            {
                $post = $_POST;
                $adapter = new DbAdapter;
                $usuario = new Usuario;
                
                if(preg_match('/[a-zA-ZÀ-ú]$/', $post['nome']) == 0){
                    return header('Location: http://localhost:8080/usuarios/save#error-nome');
                }
                elseif(!filter_var($post['email'], FILTER_VALIDATE_EMAIL)){
                    return header('Location: http://localhost:8080/usuarios/save#error-email');
                }
                
                set $usuario->nome = $post['nome'];
                set $usuario->nome = $post['email'];
                set $usuario->nome = $post['senha'];
                
                $adapter->insert($usuario);
            }
            else
            {    
            require '../view/usuarios/save.phtml';
            }
	}
	
	public function deleteAction()
	{
	}
        
        public function homeAction()
        {
                $adapter = new DbAdapter();
		$usuarios = $adapter->fetchAll('usuarios');		
		require '../view/usuarios/retrieve.php';
            require '../view/usuarios/home.phtml';
        }
	
}
