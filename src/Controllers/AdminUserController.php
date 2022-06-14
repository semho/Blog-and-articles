<?php

namespace App\Controllers;

use App\Model\Group;
use App\View\View;
use App\Model\User;
use App\Validate;
use App\Model\Page;

class AdminUserController extends AbstractController
{
    public $validate;
    public $data = [];

    public function __construct()
    {
        $this->validate = new Validate();

        //наследуем конструктор абстрактного класса        
        parent::__construct(true);

        if (!$this->isAdmin()) {
            $this->redirect('/auth');
        }
    }

    /**
     * изменяем конкретный профиль пользователя по его id
     * @param {int} $userId - идентификатор пользователя
     */
    public function changeUser($userId)
    {
        $changeableUser = User::find($userId);
        $groupsDB = Group::all();
        $groups = [];
        
        foreach ($groupsDB as $groupDB) {
            $groups[$groupDB->id]['name'] = $groupDB->name;
        }

        if (empty($_POST)) { 

            return new View('admin.change.user', [
                'title' => 'Измение учетной записи пользователя', 
                'user' => $this->user,
                'changeableUser' => $changeableUser,
                'groups' => $groups,
                'listStaticPages' => Page::select('id', 'title', 'slug')->get()->toArray(),
            ]);  
        }
        
        $nameUser = strip_tags($_POST['name']);
        $emailUser = strip_tags($_POST['email']);
        $selectUser = strip_tags($_POST['adminUserSelect']);
        $descriptionUser = strip_tags($_POST['description']);
        $checkboxUser = 1;

        if ($changeableUser->subscription == 1 && isset($_POST['checkboxNo'])) {
            $checkboxUser = 0;
        }

        if ($changeableUser->subscription == 0 && !isset($_POST['checkboxYes'])) {
            $checkboxUser = 0;
        }
        //проверяем на ошибки
        $resultValidateUser = $this->validate->validateAdminUser($nameUser, $emailUser);
        //если ошибок нет, сохраняем изменения
        if (empty($resultValidateUser['error'])) {
            $changeableUser->full_name = $nameUser;
            $changeableUser->email = $emailUser;
            $changeableUser->group_id = $selectUser;
            $changeableUser->subscription = $checkboxUser;
            $changeableUser->description = $descriptionUser;
            $changeableUser->save();
        }

        return new View('admin.change.user', [
            'title' => 'Измение учетной записи пользователя', 
            'user' => $this->user,
            'changeableUser' => $changeableUser,
            'groups' => $groups,
            'errors' => $resultValidateUser['error'],
            'listStaticPages' => Page::select('id', 'title', 'slug')->get()->toArray(),
        ]);  
    }

    /**
     * удаление пользователя из базы данных с помощью админки
     */
    public function deleteUser()
    {
        //читаем файл в строку полученный из данных тела запроса
        $json = file_get_contents('php://input');
        //декодируем данные json в переменную php
        $userId = json_decode($json, true)['id'];
        //удаляем пользователя по его id
        $user = User::destroy($userId);
        $usersUpdate = User::getUserForAdminPanel();
        //если удаление успешно
        if ($user) {
            $this->data['success'] = true;
            $this->data['successMessage'] = 'Пользователь удален';
            //получаем всех пользователей
            $this->data['body'] = $usersUpdate;
            //назначаем название столбцов таблицы
            $this->data['header'] = ['id', 'Имя', 'Email', 'Группа', 'Подписка', 'Изменить', 'Удалить'];
        } else {
            $this->data['error'] = 'Не удалось удалить пользователя';
        }
         
        return json_encode($this->data);
    }
}
