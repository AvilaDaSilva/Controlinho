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
                    if($logou['status'] == 2){
                        if(!isset($_SESSION)){
                            session_start();
                        }
                        $_SESSION['id'] = $logou['id'];
                        $_SESSION['username'] = $logou['nome'];
                        $_SESSION['avatar'] = $logou['avatar'];
                        $_SESSION['email'] = $logou['email'];
                        $_SESSION['senha'] = $logou['senha'];
                        $_SESSION['status'] = $logou['status'];

                        require '../view/posts/index.phtml';
                        return null;
                    }
                    
                    if($logou['status'] == 0){
                        $GLOBALS['error_auth'] = 'usuario_inativo';
                        require '../view/posts/index.phtml';
                        return null;
                    }
                    
                    if(!isset($_SESSION)){
                        session_start();
                    } 
                    $_SESSION['id'] = $logou['id'];
                    $_SESSION['username'] = $logou['nome'];
                    $_SESSION['avatar'] = $logou['avatar'];
                    $_SESSION['email'] = $logou['email'];
                    $_SESSION['senha'] = $logou['senha'];
                    $_SESSION['status'] = $logou['status'];
                    
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
                    $GLOBALS['succes'] = 'sucess_add';
                } catch (Exception $ex) {
                    echo $ex;exit;
                }
                require '../view/posts/index.phtml';
            }
            else
            {    
            require '../view/usuarios/save.phtml';
            }
	}
        
        public function indexAction()
        {   
            if($_POST)
            {
                if(!isset($_SESSION)){
                    session_start();
                } 
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
                        $GLOBALS['succes'] = 'sucess';
                    } catch (Exception $ex) {
                        echo $ex;
                    }
                    require '../view/usuarios/index.phtml';
                }
            }
            else 
            {
                if(!isset($_SESSION)){
                    session_start();
                } 
                $id = $_SESSION['id'];
                $adapter = new DbAdapter();
                $post = $adapter->fetchAllPostsById($id);
                $GLOBALS['content'] = $post;
                require '../view/usuarios/index.phtml';   
            }
        }
        
        public function logoutAction()
	{
            if(!isset($_SESSION)){
                session_start();
            } 
            session_destroy();
            header('Location: /');
        }
        
        public function adminAction()
	{
            if($_POST)
            {
                if(!isset($_SESSION)){
                    session_start();
                } 
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
                        $GLOBALS['succes'] = 'sucess';
                    } catch (Exception $ex) {
                        echo $ex;
                    }
                    require '../view/usuarios/index.phtml';
                }
            }else{
            if(!isset($_SESSION)){
                session_start();
            }
            $adapter = new DbAdapter();
            $content['usuarios'] = $adapter->fetchAll('usuario');
            $content['post'] = $adapter->fetchAllPosts();
            $GLOBALS['content'] = $content;
            require '../view/admin/index.phtml';
            }
        }
        
        public function banAction()
	{
            if($_POST){
                if(!isset($_SESSION)){
                session_start();
                }
                $adapter = new DbAdapter();
                $usuarios = $adapter->fetchAll('usuario');
                $post = $_POST;
                
                if(isset($post['unban'])){
                    foreach ($usuarios as $usuario){
                        if($usuario['id'] == $post['unban']){
                            try {
                                $adapter->unbanUsuario($post['unban']);
                                $GLOBALS['succes'] = 'unban_sucess';
                            } catch (Exception $ex) {
                                echo $ex;
                            }
                        }
                    }
                }else{
                foreach ($usuarios as $usuario){
                    if($usuario['id'] == $post['ban']){
                        try {
                            $adapter->banUsuario($post['ban']);
                            $GLOBALS['succes'] = 'ban_sucess';
                        } catch (Exception $ex) {
                            echo $ex;
                        }
                    }
                }
                }
            }
            header("Location: /usuarios/admin");
        }
        
        public function deleteAction()
	{
            if(!isset($_SESSION)){
                session_start();
            }
            $adapter = new DbAdapter();
            $sessao = $_SESSION;
            try {
                $adapter->delete('usuario', $sessao['id']);
                $GLOBALS['succes'] = 'sucess';
            } catch (Exception $ex) {
                echo $ex;
            }
            session_destroy();
            header('Location: /');
        }
        
        public function forgotAction()
	{
            $adapter = new DbAdapter;

            if($_POST){
                $post = $_POST;
                $usuarios_cadastrados = $adapter->fetchAll('usuario');
                foreach ($usuarios_cadastrados as $uc){
                    if($uc['email'] == $post['email']){
                        $usuario = $uc;
                    }
                }
                if(isset($usuario)){
                    $nome = $usuario['nome'];
                    $senha = $usuario['senha'];
                    $text = "Olá $nome, você requisitou uma recuperação de senha."
                            . "Este e-mail é automatico,"
                            . "sua senha atual é: $senha!";
                    
                    $email = $post['email'];
                    $headers = "MIME-Version: 1.1\n";
                    $headers .= "Content-type: text/plain; charset=iso-8859-1\n";
                    $envio = mail("$email", "Recuperação de Senha", "$text", $headers, "-r"."suporte@controlinho.com");

                    if($envio){
                        $GLOBALS['sucess_email'] = 'sucess';
                        header('Location: /');
                    }else{
                        $GLOBALS['sucess_email'] = 'error';
                        header('Location: /');
                    }
                }else{
                    $GLOBALS['sucess_email'] = 'error_404';
                        header('Location: /');
                }
            }else{
                require '../view/usuarios/retrieve.phtml';
            }
        }
}
