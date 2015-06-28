<?php  
ini_set('error_reporting', E_ALL);  
ini_set('display_errors',1);
ini_set('display_startup_erros',1);

include 'bootstrap.php';  

use Controller\Usuarios as Usuarios;
use Controller\Posts as Posts;

$usuarios = new Usuarios();
$posts = new Posts();

$uri = $_SERVER['REQUEST_URI'];

/* USUARIOS */
if($uri == '/usuarios/retrieve')
{
    $usuarios->retrieveAction();
}
else if($uri == '/usuarios/save')
{
    $usuarios->saveAction();
}
else if($uri == '/usuarios/delete')
{
    $usuarios->deleteAction();
}
else if($uri == '/usuarios')
{
    $usuarios->homeAction();
}


/* POSTS */
else if($uri == '/index/retrieve')
{
    $posts->retrieveAction();
}
else if($uri == '/save')
{
    
}
else if($uri == '/delete')
{
    
}
else if($uri == '/')
{
    $posts->homeAction();
}
else
{
    header('Status: 404 Not Found');
    echo "<html><body><h1>Page Not Found</h1></body></html>";
}

