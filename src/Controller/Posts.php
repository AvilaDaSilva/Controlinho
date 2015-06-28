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
            $post = $_POST;
            $adapter = new DbAdapter;
            $post = new Posts();

            if(preg_match('/[a-zA-ZÀ-ú]$/', $post['nome']) == 0){
                return header('Location: http://localhost:8080/posts/save#error-nome');
            }
            elseif(!filter_var($post['email'], FILTER_VALIDATE_EMAIL)){
                return header('Location: http://localhost:8080/posts/save#error-email');
            }

            $post->nome = $post['nome'];
            $post->nome = $post['email'];
            $post->nome = $post['senha'];

            $adapter->insert($post);
        }
        else
        {
            require '../view/posts/save.phtml';
        }
    }

    public function deleteAction()
    {
    }

    public function homeAction()
    {
        $adapter = new DbAdapter();
        $post = $adapter->fetchAllPosts('posts');
        $this->content = $post;
        require '../view/posts/index.phtml';
    }

}
