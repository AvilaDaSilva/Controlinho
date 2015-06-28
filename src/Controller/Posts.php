<?php

namespace Controller;

use \Db\DbAdapter as DbAdapter;
use \Model\Posts as Post;
use Zend\View\Model\ViewModel;

class Posts
{

    public function retrieveAction()
    {
    }

    public function saveAction()
    {
        if($_POST)
        {
            $dados = $_POST;
            $adapter = new DbAdapter;
            $post = new Posts();
            $nome = $_SESSION['nome'];
            $user = $adapter->find('usuario', $nome);
            $dados['data_post'] = date('');
            $post->post = $dados['titulo'];
            $post->post = $dados['corpo'];
            $post->post = $dados['data_post'];
            $post->post = $user['id'];
            $adapter->insert($post);
        }
        else
        {
            require '../view/posts/save.phtml';
        }
    }

    public function deleteAction()
    {
        $id = $this->getEvent()->getRouteMatch()->getParam('id');
    }

    public function homeAction()
    {
        $adapter = new DbAdapter();
        $post = $adapter->fetchAllPosts('posts');
        $this->content = $post;
        require '../view/posts/index.phtml';
    }

}
