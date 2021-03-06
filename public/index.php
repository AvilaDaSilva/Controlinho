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
else if($uri == '/usuarios/index')
{
    $usuarios->indexAction();
}
else if($uri == '/usuarios/logout')
{
    $usuarios->logoutAction();
}
else if($uri == '/usuarios/admin')
{
    $usuarios->adminAction();
}
else if($uri == '/usuarios/ban')
{
    $usuarios->banAction();
}
else if($uri == '/usuarios/forgot')
{
    $usuarios->forgotAction();
}

/* POSTS */
else if($uri == '/save')
{
    $posts->saveAction();
}
else if($uri == '/delete')
{
    $posts->deleteAction();
}
else if($uri == '/')
{
    $posts->homeAction();
}
else if($uri == '/comentario')
{
    $posts->comentarioAction();
}
else if($uri == '/about')
{
    $posts->aboutAction();
}
else
{
    header('Status: 404 Not Found');
    echo "<html><body><h1>Page Not Found</h1></body></html>";
}

