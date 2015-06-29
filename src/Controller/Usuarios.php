<?php

namespace Controller;

use \Db\DbAdapter as DbAdapter;
use \Model\Usuario as Usuario;

class Usuarios
{

	public function retrieveAction()
	{
            if($_POST)
            {
                $GLOBALS['error_auth'] = null;
                $post = $_POST;
                $adapter = new DbAdapter;
                $usuarios = $adapter->fetchAll('usuario');
                
                foreach ($usuarios as $usuario){
                    if($usuario['email'] == $post['email'])
                    {
                        $logou = $usuario;
                    }
                }
                if(isset($logou))
                {
                    
                    if($logou['status'] != 1){
                        $GLOBALS['error_auth'] = 'usuario_inativo';
                        require '../view/posts/index.phtml';
                        return null;
                    }
                    
                    session_start();
                    $_SESSION['id'] = $logou['id'];
                    $_SESSION['username'] = $logou['nome'];
                    $_SESSION['avatar'] = $logou['avatar'];
                    $_SESSION['email'] = $logou['email'];
                    $_SESSION['senha'] = $logou['senha'];
                    
                    require '../view/posts/index.phtml';
                    return null;
                }
                else
                {
                        $GLOBALS['error_auth'] = 'email_inexistente';
                        require '../view/posts/index.phtml';
                        return null;
                }
            }
            if($_GET){
            if($_GET["act"]=="logout"){
                session_destroy();
                require '../view/posts/index.phtml';
                exit;
            }
            }
	}

	public function saveAction()
	{  
            if($_POST)
            {
                $GLOBALS['error_auth'] = null;
                $post = $_POST;
                $adapter = new DbAdapter;
                $usuario = new Usuario;
                
                $usuarios_cadastrados = $adapter->fetchAll('usuario');
                foreach ($usuarios_cadastrados as $uc){
                    if($uc['email'] == $post['email']){
                        $GLOBALS['error_auth'] = 'email_existente';
                        require '../view/usuarios/save.phtml';
                        return null;
                    }
                }
                
                if(preg_match('/[a-zA-ZÀ-ú]$/', $post['nome']) == 0){
                    $GLOBALS['error_auth'] = 'nome';
                    require '../view/usuarios/save.phtml';
                    return null;
                }
                if(!filter_var($post['email'], FILTER_VALIDATE_EMAIL)){
                    $GLOBALS['error_auth'] = 'email';
                    require '../view/usuarios/save.phtml';
                    return null;
                }
                if($post['senha'] == ''){
                    $GLOBALS['error_auth'] = 'senha';
                    require '../view/usuarios/save.phtml';
                    return null;
                }
                
                $usuario->nome = $post['nome'];
                $usuario->email = $post['email'];
                $usuario->senha = $post['senha'];
                $usuario->status = 1;
                
                try {
                    $adapter->insert($usuario);
                } catch (Exception $ex) {
                    echo $ex;
                }
                require '../view/posts/index.phtml';
            }
            else
            {    
            require '../view/usuarios/save.phtml';
            }
	}
	
	public function deleteAction()
	{
	}
        
        public function indexAction()
        {   
            if($_POST)
            {
                session_start();
                $post = $_POST;
                $values = null;
                
                if($post['tipo'] == 'perfil'){
                    $id = $_SESSION['id'];
                    $GLOBALS['error_auth'] = null;
                    $post = $_POST;
                    $adapter = new DbAdapter;
                    
                    $usuarios_cadastrados = $adapter->fetchAll('usuario');
                    foreach ($usuarios_cadastrados as $uc){
                        if($uc['email'] == $post['email']){
                            $GLOBALS['error_auth'] = 'email_existente';
                            require '../view/usuarios/index.phtml';
                            return null;
                        }
                    }
                    if($post['nome'] != ''){
                    if(preg_match('/[a-zA-ZÀ-ú\s]$/', $post['nome']) == 0){
                        $GLOBALS['error_auth'] = 'nome';
                        require '../view/usuarios/index.phtml';
                        return null;
                    }
                    $values['nome'] = $post['nome'];
                    }
                    if($post['email'] != ''){
                    if(!filter_var($post['email'], FILTER_VALIDATE_EMAIL)){
                        $GLOBALS['error_auth'] = 'email';
                        require '../view/usuarios/index.phtml';
                        return null;
                    }
                    $values['email'] = $post['email'];
                    }
                    if($post['senha'] != ''){
                        $values['senha'] = $post['senha'];
                    }
                    if($_FILES['avatar']['size'] != 0){
                        $filename = $_FILES['avatar']['name'];
                        $file = $_FILES['avatar']['tmp_name'];
                        move_uploaded_file($file, "images/user-avatar/".$filename);
                        
                        $values['avatar'] = $filename;
                    }
                    if(!isset($values)){
                        $GLOBALS['error_auth'] = 'sem_campos';
                        require '../view/usuarios/index.phtml';
                        return null;
                    }
                    try{
                        $adapter->updateUsuario($values, $id);
                        if($post['nome'] != ''){
                            $_SESSION['nome'] = $values['nome'];
                        }
                        if($post['email'] != ''){
                            $_SESSION['email'] = $values['email'];
                        }
                        if($post['senha'] != ''){
                            $_SESSION['senha'] = $values['senha'];
                        }
                        if($_FILES['avatar']['size'] != 0){
                            $_SESSION['avatar'] = $values['avatar'];
                        }
                    } catch (Exception $ex) {
                        echo $ex;
                    }
                    require '../view/usuarios/index.phtml';
                }
            }
            else 
            {
                require '../view/usuarios/index.phtml';   
            }
        }
        
        public function logoutAction()
	{
            session_start();
            session_destroy();
            require '../view/posts/index.phtml';
        }
	
}
