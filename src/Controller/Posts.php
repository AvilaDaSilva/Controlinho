<?php

namespace Controller;

use \Db\DbAdapter as DbAdapter;
use \Model\Posts as Post;
use Zend\View\Model\ViewModel;

class Posts
{
    public function saveAction()
    {
        if(isset($_POST['id']))
        {
            $adapter = new DbAdapter();
            if(isset($_POST['titulo'])){
                $id = $_POST['id'];
                $posts = "titulo = '".$_POST['titulo']."', corpo = '".$_POST['corpo']."', data_post = '".date('Y-m-d')."'";
                if($_FILES['midia']['name'] != ''){
                    $anexos = "src = '".$_POST['tipoMidia']."', media = '".$_FILES['midia']['name']."'";
                } else {
                    $anexos = "src = ".$_POST['tipoMidia']."";
                }

                $result = $adapter->updatePost($id, $posts, $anexos);

                header('Location: /#success');
            } else {
                $id = $_POST['id'];
                $this->content = $adapter->fetchAllPostsById($id);
            }
            require '../view/posts/save.phtml';
        }
        else if(!isset($_POST))
        {
            session_start();
            $adapter = new DbAdapter();
            $filename = $_FILES['midia']['name'];
            $file = $_FILES['midia']['tmp_name'];
            move_uploaded_file($file, "images/user-image/".$filename);

            $values['titulo'] = $_POST['titulo'];
            $values['corpo'] = $_POST['corpo'];
            $values['tipoMidia'] = $_POST['tipoMidia'];
            $values['dataPost'] = date('Y-m-d');
            $values['usuario'] = $_SESSION['id'];

            $post = $adapter->insertPost($values, $filename);

            header('Location: /#success');
        } else {
            require '../view/posts/save.phtml';
        }
    }

    public function comentarioAction()
    {
        session_start();
        $adapter = new DbAdapter();
        $id = $_POST['id'];
        if(isset($_POST['comentario'])){
            $values['comentario'] = $_POST['comentario'];
            if(isset($_SESSION['username'])){
                $values['usuario'] = 0;
            } else {
                $values['usuario'] = $_SESSION['id'];
            }
            $values['data'] = date('Y-m-d');
            $values['post'] = $_POST['id'];
            $return = $adapter->insertComentario($values);
            return header("location: /#sucesso");
        } else {
            $this->post = $adapter->fetchAllPostsById($id);
            $this->comentario = $adapter->fetchAllComentarioById($id);
        }

        require '../view/posts/comentario.phtml';
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
        $this->content = $adapter->fetchAllPosts();
        $this->comentario = $adapter->fetchAllComentario();
        require '../view/posts/index.phtml';
    }

    public function aboutAction()
    {
        require '../view/posts/about.phtml';
    }
}
