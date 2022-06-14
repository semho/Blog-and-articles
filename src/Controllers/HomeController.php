<?php

namespace App\Controllers;

use App\View\View;
use App\Model\Post;
use App\Model\Comment;
use App\Session;
use App\Model\Page;
use App\Model\Setting;

class HomeController extends AbstractController
{
    public $error = [];
    //количество постов на одной странице
    public $countPosts;
    //количество колонок в шаблоне в зависимости от количества заданных постов
    public $countCol;

    public function __construct()
    {
         //наследуем конструктор абстрактного класса        
         parent::__construct(true);
         $this->countPosts = Setting::where('const', 'COUNT_POSTS')->first()->value;   
         $this->countCol = 12 / ceil($this->countPosts / 2);
    }


    public function index()
    {
        $posts = Post::orderBy('date', 'desc')->take($this->countPosts)->get()->toArray();
        $count = Post::count();
        //всего страниц
        $pages = ceil($count / $this->countPosts); 

        $chunkPosts = array_chunk($posts, 2);
       
        return new View('homepage', [
            'title' => 'Список статей', 
            'chunkPosts' => $chunkPosts, 
            'count' => $count, 
            'start' => 0, 
            'pages' => $pages, 
            'page' => 1,
            'user' => $this->user,
            'isManager' => $this->isManager(),
            'listStaticPages' => Page::select('id', 'title', 'slug')->get()->toArray(),
            'countPosts' => $this->countPosts,
            'countCol' => $this->countCol,
        ]);
    }

    public function page($page)
    {
        //номер начальной позиции
        $start = ($page - 1) * $this->countPosts;
        $posts = Post::orderBy('date', 'desc')->skip($start)->take($this->countPosts)->get()->toArray();
        $count = Post::count();

        $chunkPosts = array_chunk($posts, 2);

        //всего страниц
        $pages = ceil($count / $this->countPosts);
       
        return new View('homepage', [
            'title' => 'Список статей', 
            'chunkPosts' => $chunkPosts, 
            'count' => $count, 
            'start' => $start, 
            'pages' => $pages, 
            'page' => $page,
            'user' => $this->user,
            'isManager' =>$this->isManager(),
            'listStaticPages' => Page::select('id', 'title', 'slug')->get()->toArray(),
            'countPosts' => $this->countPosts,
            'countCol' => $this->countCol,
        ]);
    }

    public function post($articleId)
    {
        //получаем утвержденные комментарии к конкретной статье с полной информацией о пользователях
        $fullCommentsIsCheck = Comment::getComments($articleId);
        //получаем абсолюно все комментарии к конкретной статье
        $fullCommentsAll = Comment::getComments($articleId, true);
        //получаем объединение всех комментарии текущего пользователя по его id с утвержденными комментариями
        $commentsIsCheckAndUser = '';
        if (!empty(Session::get('id'))) {
            $commentsIsCheckAndUser = Comment::getComments($articleId, false, Session::get('id'));
        }

        return new View('post', [
            'title' => 'Статья', 
            'post' => Post::find($articleId)->toArray(), 
            'commentsUsers' => $fullCommentsIsCheck, 
            'allCommentsUsers' => $fullCommentsAll,
            'commentsIsCheckAndUser' => $commentsIsCheckAndUser,
            'user' => $this->user,
            'isManager' =>$this->isManager(),
            'isAuthUser' =>$this->isAuthUser(),
            'listStaticPages' => Page::select('id', 'title', 'slug')->get()->toArray(),
        ]);
    }
}
