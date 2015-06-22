<?php
namespace Controller;

use \Db\DbAdapter as DbAdapter;
use \Model\Usuario as Usuario;

class Usuarios
{

	public function retrieveAction()
	{
		$adapter = new DbAdapter();
		$usuarios = $adapter->fetchAll('usuarios');		
		require '../view/usuarios/retrieve.php';
	}

	public function saveAction($id)
	{
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$usuario = new Usuario();			
			$usuario->nome = $_POST['nome'];
			$usuario->senha = md5($_POST['senha']);
			$usuario->email = $_POST['email'];
			$usuario->perfil = $_POST['perfil'];
			$usuario->data_nasc = $_POST['data_nasc'];
			$adapter = new DbAdapter();
			$return = $adapter->insert($usuario); 	

			if(!$return)
				die('Um erro ocorreu');		

			header('Location: /usuarios');
		}

		require '../view/usuarios/save.phtml';
	}
	
	public function deleteAction($id)
	{
	}
	
}
