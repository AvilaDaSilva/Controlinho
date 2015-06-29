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

            //var_dump($filename);exit;
            //$file = fopen($_FILES['midia']['tmp_name'],'r');
            //$file = fread($file,filesize($_FILES['midia']['tmp_name']));
            //$file = addslashes($file);
            //var_dump($file);
            //$file = base64_encode($file);
            //var_dump($file);exit;

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

    public function editarAction()
    {

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
