<?php

namespace App\Controllers;

use App\View\View;
use App\Model\Page;
use App\Validate;
use Illuminate\Support\Str;

class AdminPageController extends AbstractController
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
     * добавление новой страницы
     */
    public function addPage()
    {
        if (empty($_POST)) { 

            return new View('admin.add.page', [
                'title' => 'Довление новой страницы', 
                'user' => $this->user,
                'listStaticPages' => Page::select('id', 'title', 'slug')->get()->toArray(),
            ]);  
        }

        $title = strip_tags($_POST['name']);
        $text = strip_tags($_POST['text']);
        $slug = Str::slug($title, '-');

        //проверяем на ошибки
        $resultValidatePage = $this->validate->validateAdminPage($title, $text, $slug);
     
        //если ошибок нет, сохраняем изменения
        if (empty($resultValidatePage['error'])) {
            //создаем новый объект
            $page = new Page();
            $page->title = $title;
            $page->text = $text;
            $page->slug = $slug;
            $page->save();
            $this->redirect('/admin/pages/');
        }

        return new View('admin.add.page', [
            'title' => 'Довление новой страницы', 
            'user' => $this->user,
            'errors' => $resultValidatePage['error'],
            'listStaticPages' => Page::select('id', 'title', 'slug')->get()->toArray(),
        ]);  
    }

    /**
     * изменяем конкретную страницу по её id
     * @param {int} $postId - идентификатор страницы
     */
    public function changePage($pageId)
    {
        $changeablePage = Page::find($pageId);
        
        if (empty($_POST)) { 

            return new View('admin.change.page', [
                'title' => 'Измение данных страницы', 
                'user' => $this->user,
                'changeablePage' => $changeablePage,
                'listStaticPages' => Page::select('id', 'title', 'slug')->get()->toArray(),
            ]);  
        }
        
        $title = strip_tags($_POST['name']);
        $text = strip_tags($_POST['text']);
        $slug = Str::slug($title, '-');

        //проверяем на ошибки
        $resultValidatePage = $this->validate->validateAdminPage($title, $text, $slug);
    
        //если ошибок нет, сохраняем изменения
        if (empty($resultValidatePage['error'])) {
            $changeablePage->title = $title;
            $changeablePage->text = $text;
            $changeablePage->slug = $slug;
            $changeablePage->save();
        }

        return new View('admin.change.page', [
            'title' => 'Измение данных страницы', 
            'user' => $this->user,
            'changeablePage' => $changeablePage,
            'errors' => $resultValidatePage['error'],
            'listStaticPages' => Page::select('id', 'title', 'slug')->get()->toArray(),
        ]);  
    }


    /**
     * удаление страницы из базы данных с помощью админки
     */
    public function deletePage()
    {
        //читаем файл в строку полученный из данных тела запроса
        $json = file_get_contents('php://input');
        //декодируем данные json в переменную php
        $pageId = json_decode($json, true)['id'];
        //удаляем страницу по её id
        $page = Page::destroy($pageId);
        $pagesUpdate = Page::getPageForAdminPanel();
        //если удаление успешно
        if ($page) {
            $this->data['success'] = true;
            $this->data['successMessage'] = 'Страница удалена';
            //получаем все страницы
            $this->data['body'] = $pagesUpdate;
            //назначаем название столбцов таблицы
            $this->data['header'] = ['id', 'Заголовок', 'ЧПУ', 'Изменить', 'Удалить'];
        } else {
            $this->data['error'] = 'Не удалось удалить страницу';
        }
         
        return json_encode($this->data);
    }
}
