<?php

namespace App\Controllers;

use App\View\View;
use App\Model\Comment;
use App\Validate;
use App\Model\Page;

class AdminCommentController extends AbstractController
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
     * изменяем конкретный комментарий пользователя по id комментария
     * @param {int} $commentId - идентификатор комментария
     */
    public function changeComment($commentId)
    {
        $changeableComment = Comment::getCommentForAdmin($commentId);

        if (empty($_POST)) { 

            return new View('admin.change.comment', [
                'title' => 'Измение комментария', 
                'user' => $this->user,
                'changeableComment' => $changeableComment,
                'listStaticPages' => Page::select('id', 'title', 'slug')->get()->toArray(),
            ]);  
        }
        
        $textComment = strip_tags($_POST['textComment']);
        $checkboxUser = 1;

        if ($changeableComment['comment']->is_check == 1 && isset($_POST['checkboxNo'])) {
            $checkboxUser = 0;
        }

        if ($changeableComment['comment']->is_check == 0 && !isset($_POST['checkboxYes'])) {
            $checkboxUser = 0;
        }

        $changeableComment['comment']->text = $textComment;
        $changeableComment['comment']->is_check = $checkboxUser;
        //проверяем на ошибки
        $resultValidateComment = $this->validate->checkingEmptiness($textComment);
        // если ошибок нет, сохраняем изменения
        if (empty($resultValidateComment['error'])) {
            $comment = Comment::find($commentId);
            $comment->text = $textComment;
            $comment->is_check = $checkboxUser;
            $comment->save();
        }

        return new View('admin.change.comment', [
            'title' => 'Измение комментария', 
            'user' => $this->user,
            'changeableComment' => $changeableComment,
            'errors' => $resultValidateComment['error'],
            'listStaticPages' => Page::select('id', 'title', 'slug')->get()->toArray(),
        ]);  
    }

    /**
     * удаление пользователя из базы данных с помощью админки
     */
    public function deleteComment()
    {
        //читаем файл в строку полученный из данных тела запроса
        $json = file_get_contents('php://input');
        //декодируем данные json в переменную php
        $commentId = json_decode($json, true)['id'];
        //удаляем комментарий по его id
        $comment = Comment::destroy($commentId);
        $commentUpdate = Comment::getCommentsForAdmin();
        //если удаление успешно
        if ($comment) {
            $this->data['success'] = true;
            $this->data['successMessage'] = 'Комментарий удален';
            //получаем всех пользователей
            $this->data['body'] = $commentUpdate;
            //назначаем название столбцов таблицы
            $this->data['header'] = ['id', 'Комментарий', 'К статье', 'Email автора', 'Модерация пройдена', 'Изменить', 'Удалить'];
        } else {
            $this->data['error'] = 'Не удалось удалить комментарий';
        }
         
        return json_encode($this->data);
    }
}
