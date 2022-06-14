<?php

namespace App\Controllers;

use App\Model\Mailing;
use App\Model\User;

class AdminSubscrController extends AbstractController
{
    public $validate;
    public $data = [];

    public function __construct()
    {
        //наследуем конструктор абстрактного класса        
        parent::__construct(true);

        if (!$this->isAdmin()) {
            $this->redirect('/auth');
        }
    }

    /**
     * удаление подписки неавторизированного пользователя
     */
    public function deleteSubscrNoAuth()
    {
        //читаем файл в строку полученный из данных тела запроса
        $json = file_get_contents('php://input');
        //декодируем данные json в переменную php
        $userId = json_decode($json, true)['id'];
        //удаляем подписчика по его id
        $mail = Mailing::destroy($userId);
        $mailUpdate = Mailing::getSubsrcForAdminPanel();
        //если удаление успешно
        if ($mail) {
            $this->data['success'] = true;
            $this->data['successMessage'] = 'Подписка удалена';
            //получаем все статьи
            $this->data['body'] = $mailUpdate;
            //назначаем название столбцов таблицы
            $this->data['header'] = ['id', 'Email', 'Удалить'];
        } else {
            $this->data['error'] = 'Не удалось удалить подписку';
        }
         
        return json_encode($this->data);
    }

    /**
     * удаление подписки авторизированного пользователя
     */
    public function deleteSubscrAuth()
    {
        //читаем файл в строку полученный из данных тела запроса
        $json = file_get_contents('php://input');
        //декодируем данные json в переменную php
        $userId = json_decode($json, true)['id'];
        //убираем подписку у авторизованного пользователя
        $user = User::find($userId);
        $user->subscription = 0;
        $user->save();
        if ($user->save()) {
            $this->data['success'] = true;
            $this->data['successMessage'] = 'Подписка удалена';
            //получаем всех подписанных пользователей
            $this->data['body'] = User::getUserMailForAdminPanel();;
            //назначаем название столбцов таблицы
            $this->data['header'] = ['id', 'Email', 'Удалить'];
        } else {
            $this->data['error'] = 'Не удалось удалить подписку';
        }

        return json_encode($this->data);
    }
}
