<?php

namespace Controller;

use \Db\DbAdapter as DbAdapter;
use \Model\Posts as Post;
use Zend\View\Model\ViewModel;

class Posts
{
    public function saveAction()
    {

        if($_POST)
        {
            session_start();
            $adapter = new DbAdapter();
            $file = fopen($_FILES['midia']['tmp_name'],'r');
            $file = fread($file,filesize($_FILES['midia']['tmp_name']));
            $filep = addslashes($file);
            //var_dump($file);
            $files = pg_unescape_bytea($filep);
            //var_dump($file);exit;

            $values['titulo'] = $_POST['titulo'];
            $values['corpo'] = $_POST['corpo'];
            $values['tipoMidia'] = $_POST['tipoMidia'];
            $values['dataPost'] = date('');
            $values['usuario'] = $_SESSION['id'];

            $post = $adapter->insertPost($values, $files);
            header('Location: /#success');
        }
        else
        {
            require '../view/posts/save.phtml';
        }
    }

    public function deleteAction()
    {
        $adapter = new DbAdapter();
        $id = $_POST['id'];
        $post = $adapter->deletePost($id);
        header('Location: /#success');
    }

    public function homeAction()
    {
        $adapter = new DbAdapter();
        $post = $adapter->fetchAllPosts();
        $this->content = $post;
        require '../view/posts/index.phtml';
    }

}
