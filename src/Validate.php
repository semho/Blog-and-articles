<?php

namespace App;

use App\ErrorsValidateForm;
use App\Model\Page;
use App\Model\User;
use Error;

class Validate 
{
    /**
     * массив сбора ошибок
     */
    public $arrErrors = [];
    
     /**
     * валидация полей регистрации
     * @param {array} $data - масив полей пользователя
     */
    public function validateReg($data)
    {
        //проверяем ввод на ошибки
        if (ErrorsValidateForm::errorName($data['name'])) {
            $this->arrErrors['name'] = ErrorsValidateForm::errorName($data['name']);
        }
        if (ErrorsValidateForm::errorEmail($data['email'], true)) { 
            $this->arrErrors['email'] = ErrorsValidateForm::errorEmail($data['email'], true);
        }
        if (ErrorsValidateForm::errorPassword($data['password'])) {
            $this->arrErrors['password'] = ErrorsValidateForm::errorPassword($data['password']);
        }
        if (ErrorsValidateForm::errorDifferntPasswords($data['password'], $data['password2'])) {
            $this->arrErrors['accuracyPassword'] = ErrorsValidateForm::errorDifferntPasswords($data['password'], $data['password2']);
        }
        if (ErrorsValidateForm::errorRules($data['check'])) {
            $this->arrErrors['check'] = ErrorsValidateForm::errorRules($data['check']);
        }
        
        //если ошибок нет
        if (empty($this->arrErrors)) {
            //собираем массив данных для записи в БД
            $dataBD = [
                'full_name' => $data['name'],
                'email' => $data['email'],
                'password' => password_hash($data['password'], PASSWORD_DEFAULT),
            ];
            //создаем новый объект пользователя
            $user = new User();
            //возвращаем сохраненного пользователя из бд
            return ['user' => User::saveUser($user, $dataBD)];
        }

        return ['error' => $this->arrErrors];
    }

    /**
     * валидация полей авторизации
     * @param {string} $email - email пользователя
     * @param {string} $password - email пользователя
     */
    public function validateAuth($email, $password)
    {
        //получаем пользователя по его email
        $currentUser = User::where('email', $email)->first();
        //проверяем ввод на ошибки
        if (ErrorsValidateForm::errorEmail($email)) {
            $this->arrErrors['email'] = ErrorsValidateForm::errorEmail($email);
        }
        if (ErrorsValidateForm::errorPassword($password)) {
            $this->arrErrors['password'] = ErrorsValidateForm::errorPassword($password);
        }
        if (ErrorsValidateForm::errorUserNotFound($currentUser)) {
            $this->arrErrors['currentUser'] = ErrorsValidateForm::errorUserNotFound($currentUser);
        }
        if (ErrorsValidateForm::errorValidatePassword($currentUser, $password)) {
            $this->arrErrors['noPassword'] = ErrorsValidateForm::errorValidatePassword($currentUser, $password);
        }
        //если ошибок нет
        if (empty($this->arrErrors)) {
            //вернем значения полей имени и емайл текущего пользователя
            return ['user' => ['name' => $currentUser->full_name, 'email' => $currentUser->email, 'id' => $currentUser->id, 'group_id' => $currentUser->group_id]];
        }

        return ['error' => $this->arrErrors];
    }

    /**
     * валидация измения профиля
     * @param {array} $data - масив полей пользователя
     * @param {int} $id - идентификатор пользователя
     * @param {string} $email - email пользователя
     */
    public function validateProfile($data, $id, $email) 
    {
        //проверяем ввод на ошибки
        if (ErrorsValidateForm::errorName($data['name'])) {
            $this->arrErrors['name'] = ErrorsValidateForm::errorName($data['name']);
        }
        if (ErrorsValidateForm::errorEmail($data['email'], true, $email)) {
            $this->arrErrors['email'] = ErrorsValidateForm::errorEmail($data['email'], true, $email); 
        }
        if (ErrorsValidateForm::errorMaxSizeImg($data['sizeImg'])) {
            $this->arrErrors['size'] = ErrorsValidateForm::errorMaxSizeImg($data['sizeImg']);
        }
        //если ошибок нет
        if (empty($this->arrErrors)) {
            //собираем массив данных для записи в БД
            $dataBD = [
                'full_name' => $data['name'],
                'email' => $data['email'],
                'subscription' => $data['check'],
                'description' => $data['desc'],
                'avatar' => $data['img'],
            ];
            //ищем пользователя по его id
            $user = User::find($id);
            //возвращаем сохраненного пользователя
            return ['user' => User::saveUser($user, $dataBD)];
        }

        return ['error' => $this->arrErrors];
    }

    /**
     * валидация изменения профиля пользователя через админку
     * @param {string} $name - имя пользователя
     * @param {string} $email - email пользователя
     */
    public function validateAdminUser($name, $email)
    {
        //проверяем ввод на ошибки
        if (ErrorsValidateForm::errorName($name)) {
            $this->arrErrors['name'] = ErrorsValidateForm::errorName($name);
        }
        if (ErrorsValidateForm::errorEmail($email)) {
            $this->arrErrors['email'] = ErrorsValidateForm::errorEmail($email);
        }

        return ['error' => $this->arrErrors];
    }

    /**
     * валидация изменения статьи через админку
     * @param {string} $title - название статьи
     * @param {string} $description - описание статьи
     * @param {string} $text - текст статьи
     */
    public function validateAdminPost($title, $description, $text, $img)
    {
        //проверяем ввод на ошибки
        if (ErrorsValidateForm::errorTitle($title)) {
            $this->arrErrors['name'] = ErrorsValidateForm::errorTitle($title);
        }
        if ($description === null || trim($description) === '') {
            $this->arrErrors['description'] = 'Описание не может быть пустым';
        }
        if ($text === null || trim($text) === '') {
            $this->arrErrors['text'] = 'Текст статьи не может быть пустым';
        }
        if (ErrorsValidateForm::errorMaxSizeImg($img['size'])) {
            $this->arrErrors['size'] = ErrorsValidateForm::errorMaxSizeImg($img['size']);
        }
        if (ErrorsValidateForm::errorEndFile($img)) {
            $this->arrErrors['endFile'] = ErrorsValidateForm::errorEndFile($img);
        }

        return ['error' => $this->arrErrors];
    }

    /**
     * проверка на пустоту
     *  @param {string} $value - значение поля
     */
    public function checkingEmptiness($value) 
    {
        if ($value === null || trim($value) === '') {
            $this->arrErrors['text'] = 'Поле не может быть пустым';
        }

        return ['error' => $this->arrErrors];
    }

    public function validateAdminPage($title, $text, $slug) 
    {
        if (ErrorsValidateForm::errorTitle($title)) {
            $this->arrErrors['name'] = ErrorsValidateForm::errorTitle($title);
        }
        if ($text === null || trim($text) === '') {
            $this->arrErrors['text'] = 'Поле не может быть пустым';
        }
        $pages = Page::select('slug')->get()->toArray();
        foreach ($pages as $page) {
            if ($page['slug'] == $slug) {
                $this->arrErrors['slug'] = 'ЧПУ текущего заголовка совпадает с уже имеющимся!';
            }
        }
        
        return ['error' => $this->arrErrors];
    }

    public function validateAdminSetting($valueSetting) 
    {
        if ($valueSetting === null || trim($valueSetting) === '' || !is_numeric($valueSetting)) {
            $this->arrErrors['text'] = 'Поле должно содержать цифру!';
        }

        return ['error' => $this->arrErrors];
    }
}
