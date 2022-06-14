<?php

namespace App\Controllers;

use App\Model\Comment;
use App\Model\User;
use App\Model\Mailing;

class RequestController
{
    public $data = [];
    
    /**
     * метод оформления подписки
     */
    public function subscription() 
    {

        //получаем id авторизованного пользователя желающего подписаться на рассылку
        if (isset($_POST['userId']) && !empty($_POST['userId'])) {
            $userId = strip_tags($_POST['userId']);
            $this->userIsLogged($userId);
        }
        //получаем email неавторизованного пользователя желающего подписаться на рассылку
        if (isset($_POST['email']) && isset($_POST['noAuth']) && !empty($_POST['email'])) {
            $userEmail = strip_tags($_POST['email']);
            $this->userNotLogged($userEmail);
        }
        
        return json_encode($this->data);
    }
    
    /**
     * метод для подписки неавторизованного пользователя
     * @param {string} $email - email пользователя
     */
    public function userNotLogged($email)
    {
        //проверяем email среди известных пользователей 
        $someUser = User::where('email', $email)->first();
        //если пользователь есть в БД
        if ($someUser) {
            $this->data['error'] = 'Ваш профиль уже есть в БД, авторизуйтесь для подписки';
        } else {
            $mailings = Mailing::where('email', $email)->first();
            //если в рассылке уже есть адресс
            if ($mailings) {
                $this->data['message'] = 'Вы уже являетесь нашим подписчиком';
            } else {
                //подписываем посетителя
                $newMailings = new Mailing();
                $newMailings->email = $email;
                $newMailings->save();
                $this->data['message'] = 'Теперь Вы являетесь нашим подписчиком, спасибо!';
            }
        }
    }
    
    /**
     * метод для подписки авторизованного пользователя
     * @param {int} $userId - идентификатор пользователя
     */
    public function userIsLogged($userId)
    {
        //получаем пользователя по его id
        $currentUser = User::find($userId);
        //если пользователя нет в БД
        if (!$currentUser) {
            $this->data['error'] = 'Такого пользователя нет в БД';
        } else {
            //проверяем подписку
            if ($currentUser->subscription == 1) {
                $this->data['message'] = 'Вы уже являетесь нашим подписчиком';
            } else {
                //подписываем пользователя
                $dataBD = ['email' => $currentUser->email, 'subscription' => 1];
                $updateUser = User::saveUser($currentUser, $dataBD);
                if (!empty($updateUser)) {
                    $this->data['message'] = 'Теперь Вы являетесь нашим подписчиком, спасибо!';
                }
            }
        }
    }
    
    /**
     * метод оставления комментария
     */
    public function comment()
    {
        //читаем файл в строку полученный из данных тела запроса
        $json = file_get_contents('php://input');
        //декодируем данные json в переменную php
        $dataJson = json_decode($json, true);
        //если пользователь отправляет пустое сообщение
        if (empty($dataJson['comment'])) {
            $this->data['message'] = 'Ваш комментарий пуст';
        //иначе сохраняем комментарий
        } else {
            $newComment = new Comment();
            $newComment->text = $dataJson['comment'];
            $newComment->user_id = $dataJson['userId'];
            $newComment->post_id = $dataJson['postId'];
            if ($dataJson['groupId'] == 1 || $dataJson['groupId'] == 2) {
                $newComment->is_check = 1;
            }
            $newComment->save();
            //если сохранение удачно
            if ($newComment->save()) {
                $this->data['success'] = $newComment->save();
                //получаем все комментарии в ассоциативный массив к этому посту
                $this->data['comments'] = Comment::getComments($dataJson['postId'], false, $dataJson['userId']);
            } else {
                $this->data['error'] = 'Не удалось сохранить комментарий';
            }
        }
        
        //отправляем ответ в виде json
        return json_encode($this->data);
    }
    
    /**
     * метод модерации комментария
     */
    public function moderation()
    {
        //читаем файл в строку полученный из данных тела запроса
        $json = file_get_contents('php://input');
        //декодируем данные json в переменную php
        $dataJson = json_decode($json, true);
        //ищем комменарий по его id
        $comment = Comment::find($dataJson['idComment']);
        //если комментария нет
        if (!$comment) {
            $this->data['message'] = 'Комментарий не найден';
        //если нажата кнопка "утвердить"
        } elseif ($dataJson['btn'] == '.approveComment') {
            //утверждаем комментарий
            $comment->is_check = 1;
            //сохраняем изменения в БД
            $comment->save();
            if ($comment->save()) {
                $this->data['success'] = true;
                $this->data['successMessage'] = 'Комментарий утвержден';
                //получаем все комментарии в ассоциативный массив к этому посту
                $this->data['comments'] = Comment::getComments($dataJson['postId'], true);
            } else {
                $this->data['error'] = 'Не удалось утвердить комментарий';
            }        
        //если нажата кнопка "отклонить"
        } else if ($dataJson['btn'] == '.rejectComment') {
            if ($comment->forceDelete()) {
                $this->data['success'] = true;
                $this->data['successMessage'] = 'Комментарий удален';
                //получаем все комментарии в ассоциативный массив к этому посту
                $this->data['comments'] = Comment::getComments($dataJson['postId'], true);
            } else {
                $this->data['error'] = 'Не удалось удалить комментарий';
            }
        }

        //отправляем ответ в виде json
        return json_encode($this->data);
    }

    public function unsubscribe()
    {
        //читаем файл в строку полученный из данных тела запроса
        $json = file_get_contents('php://input');
        //декодируем данные json в переменную php
        $dataJson = json_decode($json, true);
        //ищем подписчика по его email
        $mailing = Mailing::where('email', $dataJson['email'])->get()->first();
        $user = User::where('email', $dataJson['email'])->where('subscription', 1)->get()->first();

        if ($mailing) {
            $mailDelete = Mailing::destroy($mailing->id);
            if ($mailDelete) {
                $this->data['success'] = true;
                $this->data['messageOk'] = 'Email удален из рассылки';
            } else {
                $this->data['error'] = 'Не удалось удалить email';
            }
        } elseif ($user) {
            $user->subscription = 0;
            $user->save();
            if ($user->save()) {
                $this->data['success'] = true;
                $this->data['messageOk'] = 'Email удален из рассылки';
            } else {
                $this->data['error'] = 'Не удалось удалить email';
            }
        } else {
            $this->data['message'] = 'Email не найден';
        }
        
        //отправляем ответ в виде json
        return json_encode($this->data);
    }
}
