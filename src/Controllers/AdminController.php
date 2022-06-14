<?php

namespace App\Controllers;

use App\Model\Comment;
use App\Model\Mailing;
use App\Model\Page;
use App\View\View;
use App\Model\User;
use App\Model\Post;
use App\Model\Setting;
use App\Validate;

class AdminController extends AbstractController
{

    public $validate;
    public $data = [];

    public function __construct()
    {
        $this->validate = new Validate();

        //наследуем конструктор абстрактного класса        
        parent::__construct(true);
    }

    public function usersManagement($page = null, $countSelect = null)
    {
        if (!$this->isAdmin()) {
            $this->redirect('/auth');
        }
          
        //если нет параметра количества записей
        if ($countSelect == null) {
            //призваиваем значение по умолчанию
            $countSelect = COUNT_RECORDS;
        }

        //если есть параметр страницы
        if ($page != null) {
            //зписываем номер начальной позиции
            $start = ($page - 1) * $countSelect;
        //иначе
        } else {
            $start = 0;
            $page = 1;
        }
        
        //всего записей
        $count = User::count();
        
        //записи на одной странице
        $users = User::getUsersForAdminPaginator($start, $countSelect);
        
        //всего страниц
        $pages = ceil($count / $countSelect); 

         //если в url есть гет параметры, помещаем их в массив
        if (!empty($_SERVER['QUERY_STRING'])) {
            parse_str(($_SERVER['QUERY_STRING']), $get);
        };
        //получаем гет параметры из url
        if (isset($get['count'])) {
            $countRecords = $get['count'];
        } else {
            $countRecords = COUNT_RECORDS;
        }

        return new View('admin.users', [
            'title' => 'Пользователи', 
            'user' => $this->user,
            'users' => $users,
            'count' => $count, 
            'start' => $start, 
            'pages' => $pages, 
            'page' => $page,
            'countRecords' => $countRecords,
            'listStaticPages' => Page::select('id', 'title', 'slug')->get()->toArray(),
        ]);  
    }

    public function postsManagement($page = null, $countSelect = null)
    {
        if (!$this->isManager()) {
            $this->redirect('/auth');
        }

        //если нет параметра количества записей
        if ($countSelect == null) {
            //призваиваем значение по умолчанию
            $countSelect = COUNT_RECORDS;
        }

        //если есть параметр страницы
        if ($page != null) {
            //зписываем номер начальной позиции
            $start = ($page - 1) * $countSelect;
        //иначе
        } else {
            $start = 0;
            $page = 1;
        }
        
        //всего записей
        $count = Post::count();
        
        //записи на одной странице
        $posts = Post::getPostsForAdminPaginator($start, $countSelect);
        
        //всего страниц
        $pages = ceil($count / $countSelect); 

        //если в url есть гет параметры, помещаем их в массив
        if (!empty($_SERVER['QUERY_STRING'])) {
            parse_str(($_SERVER['QUERY_STRING']), $get);
        };
        //получаем гет параметры из url
        if (isset($get['count'])) {
            $countRecords = $get['count'];
        } else {
            $countRecords = COUNT_RECORDS;
        }

        return new View('admin.posts', [
            'title' => 'Статьи', 
            'user' => $this->user,
            'posts' => $posts,
            'count' => $count,
            'start' => $start, 
            'pages' => $pages, 
            'page' => $page,
            'countRecords' => $countRecords,
            'listStaticPages' => Page::select('id', 'title', 'slug')->get()->toArray(),
        ]);  
    }
    
    public function subscriptionsManagement($page1 = null, $countSelect1 = null, $page2 = null, $countSelect2 = null)
    {
        if (!$this->isAdmin()) {
            $this->redirect('/auth');
        }

         //если нет параметра количества записей
         if ($countSelect1 == null) {
            //призваиваем значение по умолчанию
            $countSelect1 = COUNT_RECORDS;
        }
        if ($countSelect2 == null) {
            //призваиваем значение по умолчанию
            $countSelect2 = COUNT_RECORDS;
        }

        //если есть параметр страницы
        if ($page1 != null) {
            //записываем номер начальной позиции
            $start1 = ($page1 - 1) * $countSelect1;
        //иначе
        } else {
            $start1 = 0;
            $page1 = 1;
        }
        
        if ($page2 != null) {
            //записываем номер начальной позиции
            $start2 = ($page2 - 1) * $countSelect2;
        //иначе
        } else {
            $start2 = 0;
            $page2 = 1;
        }

        //всего записей
        $countNoAuth = Mailing::count();
        $countAuth = User::where('subscription', 1)->count();
        
        //всего страниц
        $pagesNoAuth = ceil($countNoAuth / $countSelect1); 
        $pagesAuth = ceil($countAuth / $countSelect2); 

        //если в url есть гет параметры, помещаем их в массив
        if (!empty($_SERVER['QUERY_STRING'])) {
            parse_str(($_SERVER['QUERY_STRING']), $get);
        }
        //получаем гет параметры из url
        if (isset($get['countNoAuth'])) {
            $countRecordsNoAuth = $get['countNoAuth'];
        } else {
            $countRecordsNoAuth = COUNT_RECORDS;
        }
        if (isset($get['pageNoAuth'])) {
            $pageNoAuth = $get['pageNoAuth'];
        } else {
            $pageNoAuth = 1;
        }
        if (isset($get['countAuth'])) {
            $countRecordsAuth = $get['countAuth'];
        } else {
            $countRecordsAuth = COUNT_RECORDS;
        }
        if (isset($get['pageAuth'])) {
            $pageAuth = $get['pageAuth'];
        } else {
            $pageAuth = 1;
        }

        return new View('admin.subscriptions', [
            'title' => 'Подписки', 
            'user' => $this->user,
            'titleNoAuth' => 'Подписки неавторизированых пользователей',
            'titleAuth' => 'Подписки авторизированых пользователей',
            'usersNoAuth' => Mailing::getSubsrcForAdminPaginator($start1, $countSelect1),
            'usersAuth' => User::where('subscription', 1)->orderBy('id', 'desc')->skip($start2)->take($countSelect2)->get(),
            'countNoAuth' => $countNoAuth,
            'countAuth' => $countAuth,
            'startNoAuth' => $start1, 
            'startAuth' => $start2, 
            'pagesNoAuth' => $pagesNoAuth, 
            'pagesAuth' => $pagesAuth, 
            'pageNoAuth' => $page1,
            'pageAuth' => $page2,
            'countRecordsNoAuth' => $countRecordsNoAuth,
            'pageNoAuth' => $pageNoAuth,
            'countRecordsAuth' => $countRecordsAuth,
            'pageAuth' => $pageAuth,
            'listStaticPages' => Page::select('id', 'title', 'slug')->get()->toArray(),
        ]);  
    }

    public function commentsManagement($page = null, $countSelect = null)
    {
        if (!$this->isManager()) {
            $this->redirect('/auth');
        }
        
        //если нет параметра количества записей
        if ($countSelect == null) {
            //призваиваем значение по умолчанию
            $countSelect = COUNT_RECORDS;
        }

        //если есть параметр страницы
        if ($page != null) {
            //зписываем номер начальной позиции
            $start = ($page - 1) * $countSelect;
        //иначе
        } else {
            $start = 0;
            $page = 1;
        }
        
        //всего записей
        $count = Comment::count();
        //записи на одной странице
        $comments = Comment::getCommentsForAdminPaginator($start, $countSelect);
        //всего страниц
        $pages = ceil($count / $countSelect); 

        //если в url есть гет параметры, помещаем их в массив
        if (!empty($_SERVER['QUERY_STRING'])) {
            parse_str(($_SERVER['QUERY_STRING']), $get);
        };
        //получаем гет параметры из url
        if (isset($get['count'])) {
            $countRecords = $get['count'];
        } else {
            $countRecords = COUNT_RECORDS;
        }

        return new View('admin.comments', [
            'title' => 'Комментарии', 
            'user' => $this->user,
            'comments' => $comments,
            'count' => $count, 
            'start' => $start, 
            'pages' => $pages, 
            'page' => $page,
            'countRecords' => $countRecords,
            'listStaticPages' => Page::select('id', 'title', 'slug')->get()->toArray(),
        ]);  
    }

    public function pagesManagement($page = null, $countSelect = null)
    {
        if (!$this->isManager()) {
            $this->redirect('/auth');
        }

         //если нет параметра количества записей
         if ($countSelect == null) {
            //призваиваем значение по умолчанию
            $countSelect = COUNT_RECORDS;
        }

        //если есть параметр страницы
        if ($page != null) {
            //зписываем номер начальной позиции
            $start = ($page - 1) * $countSelect;
        //иначе
        } else {
            $start = 0;
            $page = 1;
        }
        
        //всего записей
        $count = Page::count();
        
        //записи на одной странице
        $pages = Page::getPagesForAdminPaginator($start, $countSelect);
        
        //всего страниц
        $pagesCount = ceil($count / $countSelect); 

        //если в url есть гет параметры, помещаем их в массив
        if (!empty($_SERVER['QUERY_STRING'])) {
            parse_str(($_SERVER['QUERY_STRING']), $get);
        };
        //получаем гет параметры из url
        if (isset($get['count'])) {
            $countRecords = $get['count'];
        } else {
            $countRecords = COUNT_RECORDS;
        }

        return new View('admin.pages', [
            'title' => 'Статические страницы', 
            'user' => $this->user,
            'pages' => $pages,
            'count' => $count,
            'start' => $start, 
            'pagesCount' => $pagesCount, 
            'pageGet' => $page,
            'countRecords' => $countRecords,
            'listStaticPages' => Page::select('id', 'title', 'slug')->get()->toArray(),
        ]);  
    }

    public function settingsManagement()
    {
        if (!$this->isAdmin()) {
            $this->redirect('/auth');
        }

        if (empty($_POST)) {
            return new View('admin.settings', [
                'title' => 'Дополнительные настройки', 
                'user' => $this->user,
                'settings' => Setting::orderBy('id', 'desc')->get(),
                'listStaticPages' => Page::select('id', 'title', 'slug')->get()->toArray(),
            ]);  
        }

        $valuePage = strip_tags($_POST['value']);
        $id = strip_tags($_POST['id']);

        //проверяем на ошибки
        $resultValidateSetting = $this->validate->validateAdminSetting($valuePage);
        
        // если ошибок нет, сохраняем изменения
        if (empty($resultValidateSetting['error'])) {
            $setting = Setting::find($id);
            $setting->value = $valuePage;
            $setting->save();
        }

        return new View('admin.settings', [
            'title' => 'Дополнительные настройки', 
            'user' => $this->user,
            'settings' => Setting::orderBy('id', 'asc')->get(),
            'errors' => $resultValidateSetting['error'],
            'listStaticPages' => Page::select('id', 'title', 'slug')->get()->toArray(),
        ]);  
    }
}
