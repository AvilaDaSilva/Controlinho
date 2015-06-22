<?php  
ini_set('error_reporting', E_ALL);  
ini_set('display_errors',1);
ini_set('display_startup_erros',1);

include 'bootstrap.php';  

use Controller\Usuarios as Usuarios;

$usuarios = new Usuarios;
$uri = $_SERVER['REQUEST_URI'];
if($uri == '/usuarios' || $uri == '/usuarios/retrieve'){
	$usuarios->retrieveAction();
}else if($uri == '/usuarios/save'){
	$id = null;
	if( isset($_GET['id']) )
		$id = $_GET['id'];
	$usuarios->saveAction($id);
}else if($uri == '/usuarios/delete'){
	if( isset($_GET['id']) || (int) $_GET['id'] > 0 ){
		$usuarios->delete($_GET['id']);
	}else{
		require 'view/errors/error.php';
	}	
}else{
	header('Status: 404 Not Found');
	echo "<html><body><h1>Page Not Found</h1></body></html>";
}

