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
            var_dump($_POST);
            var_dump($_FILES);exit;

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
        if ($post == true){
            header('Location: /#success');
            //MENSAGEM DE SUCESSO VER COM O IURI
        } else {
            header('Location: /#error');
            //MENSAGEM DE ERROR VER COM O IURI
        }
    }

    public function homeAction()
    {
        $adapter = new DbAdapter();
        $post = $adapter->fetchAllPosts();
        $this->content = $post;
        require '../view/posts/index.phtml';
    }

}
