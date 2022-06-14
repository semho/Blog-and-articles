<?php

namespace App\Controllers;

use App\View\View;
use App\Model\Post;
use App\Validate;
use App\DFileHelper;
use App\Model\Page;
use App\Notification;

class AdminPostController extends AbstractController
{
    public $validate;
    public $data = [];

    public function __construct()
    {
        $this->validate = new Validate();

        //наследуем конструктор абстрактного класса        
        parent::__construct(true);

        if (!$this->isManager()) {
            $this->redirect('/auth');
        }
    }

    /**
     * изменяем конкретную статью по её id
     * @param {int} $postId - идентификатор статьи
     */
    public function changePost($postId)
    {
        $changeablePost = Post::find($postId);
        
        if (empty($_POST)) { 

            return new View('admin.change.post', [
                'title' => 'Измение данных статьи', 
                'user' => $this->user,
                'changeablePost' => $changeablePost,
                'listStaticPages' => Page::select('id', 'title', 'slug')->get()->toArray(),
            ]);  
        }
        
        $namePost = strip_tags($_POST['name']);
        $descriptionPost = strip_tags($_POST['description']);
        $textPost = strip_tags($_POST['textPost']);
        $dataPhoto = $_FILES['post-photo'];
        
        //проверяем на ошибки
        $resultValidatePost = $this->validate->validateAdminPost($namePost, $descriptionPost, $textPost, $dataPhoto);
        //если ошибок нет, сохраняем изменения
        if (empty($resultValidatePost['error'])) {
            $changeablePost->name = $namePost;
            $changeablePost->description = $descriptionPost;
            $changeablePost->text = $textPost;
            if (!empty($dataPhoto['size'])) {
                $changeablePost->img = $this->saveImgPost($dataPhoto);
            }
            $changeablePost->save();
        }

        return new View('admin.change.post', [
            'title' => 'Измение данных статьи', 
            'user' => $this->user,
            'changeablePost' => $changeablePost,
            'errors' => $resultValidatePost['error'],
            'listStaticPages' => Page::select('id', 'title', 'slug')->get()->toArray(),
        ]);  
    }

    /**
     * сохраняем изображение статьи в директорию под уникальным именем
     * @param {array} $data - массив с данными файла
     */
    public function saveImgPost($data)
    {
        //директория для загрузки
        $uploadPath = $_SERVER['DOCUMENT_ROOT'] . UPLOAD_IMG_POSTS;
        //получаем расширение загружаемого файла
        $endFile =  substr($data['name'], strrpos($data['name'], '.'));
        // Генерируем уникальное имя файла с этим расширением
        $filename = DFileHelper::getRandomFileName($uploadPath, $endFile);
        // Собираем адрес файла назначения
        $target = $uploadPath . $filename . $endFile;
        // Загружаем 
        move_uploaded_file($data['tmp_name'], $target);

        return $filename . $endFile;
    }

    /**
     * добавление новой статьи
     */
    public function addPost()
    {
        if (empty($_POST)) { 

            return new View('admin.add.post', [
                'title' => 'Довление новой статьи', 
                'user' => $this->user,
                'listStaticPages' => Page::select('id', 'title', 'slug')->get()->toArray(),
            ]);  
        }

        $namePost = strip_tags($_POST['name']);
        $descriptionPost = strip_tags($_POST['description']);
        $textPost = strip_tags($_POST['textPost']);
        $dataPhoto = $_FILES['post-photo'];

        //проверяем на ошибки
        $resultValidatePost = $this->validate->validateAdminPost($namePost, $descriptionPost, $textPost, $dataPhoto);
        if (empty($dataPhoto['size'])) {
            $resultValidatePost['error']['size'] = "Вы не загрузили изображение к статье";
        }
        //если ошибок нет, сохраняем изменения
        if (empty($resultValidatePost['error'])) {
            //создаем новый объект
            $post = new Post();
            $post->name = $namePost;
            $post->description = $descriptionPost;
            $post->text = $textPost;
            if (!empty($dataPhoto['size'])) {
                $post->img = $this->saveImgPost($dataPhoto);
            }
            $post->save();
            //отправляем письмо всем подписчикам
            $notify = new Notification;
            $notify->SendTo($post->id);

            $this->redirect('/admin/posts/');
        }

        return new View('admin.add.post', [
            'title' => 'Довление новой статьи', 
            'user' => $this->user,
            'errors' => $resultValidatePost['error'],
            'listStaticPages' => Page::select('id', 'title', 'slug')->get()->toArray(),
        ]);  
    }

    /**
     * удаление статьи из базы данных с помощью админки
     */
    public function deletePost()
    {
        //читаем файл в строку полученный из данных тела запроса
        $json = file_get_contents('php://input');
        //декодируем данные json в переменную php
        $postId = json_decode($json, true)['id'];
        //удаляем статью по его id
        $post = Post::destroy($postId);
        $postsUpdate = Post::getPostForAdminPanel();
        //если удаление успешно
        if ($post) {
            $this->data['success'] = true;
            $this->data['successMessage'] = 'Статья удалена';
            //получаем все статьи
            $this->data['body'] = $postsUpdate;
            //назначаем название столбцов таблицы
            $this->data['header'] = ['id', 'Название статьи', 'Краткое описание', 'Дата', 'Изменить', 'Удалить'];
        } else {
            $this->data['error'] = 'Не удалось удалить статью';
        }
         
        return json_encode($this->data);
    }
}
