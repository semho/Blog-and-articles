<?php

namespace App\Controllers;

use App\View\View;
use App\Session;
use App\Validate;
use App\Model\Page;

class LoginController
{
    
    public $validate;

    public function __construct()
    {
        $this->validate = new Validate();
    }
    /**
     * метод авторизации
     */
    public function authorization()
    {
        if (empty($_POST)) { 
            return new View('profile.login', ['title' => 'Авторизация', 'listStaticPages' => Page::select('id', 'title', 'slug')->get()->toArray(),]);
        }

        $email = strip_tags($_POST['email']);
        $password = strip_tags($_POST['password']);
        //валидация полей ввода
        $resultValidate = $this->validate->validateAuth($email, $password);
        //если все ок
        if (!empty($resultValidate['user'])) {
            //записываем сессию и куки
            Session::sessionSave([
                'name' => $resultValidate['user']['name'], 
                'email' => $resultValidate['user']['email'],
                'id' => $resultValidate['user']['id'],
                'group_id' => $resultValidate['user']['group_id'],
            ]);
        }

        return new View('profile.login', [
            'title' => 'Повторная авторизация', 
            'errors' => $resultValidate['error'],
            'listStaticPages' => Page::select('id', 'title', 'slug')->get()->toArray(),
        ]);
    }

    /**
     * метод регистрации
     */
    public function registration()
    {
        if (empty($_POST)) { 
            return new View('profile.reg', ['title' => 'Регистрация', 'listStaticPages' => Page::select('id', 'title', 'slug')->get()->toArray(),]);
        }

        $name = strip_tags($_POST['fullName']);
        $newEmail = strip_tags($_POST['newEmail']);
        $newPassword = strip_tags($_POST['newPassword']);
        $newPassword2 = strip_tags($_POST['newPassword2']);

        if (isset($_POST['checkbox'])) {
            $checkbox = strip_tags($_POST['checkbox']);
        } else {
            $checkbox = 'no';
        }
        
        //валидация полей ввода
        $resultValidate = $this->validate->validateReg([
            'name' => $name, 'email' => $newEmail, 
            'password' => $newPassword, 
            'password2' => $newPassword2, 
            'check' => $checkbox
        ]);
        //если все ок
        if (!empty($resultValidate['user'])) {
            //записываем сессию и куки
            Session::sessionSave([
                'name' => $resultValidate['user']['name'], 
                'email' => $resultValidate['user']['email'],
                'id' => $resultValidate['user']['id'],
                'group_id' => $resultValidate['user']['group_id'],
            ]);
        }

        return new View('profile.reg', [
            'title' => 'Повторная регистрация', 
            'errors' => $resultValidate['error'], 
            'listStaticPages' => Page::select('id', 'title', 'slug')->get()->toArray(),
        ]);
    }
}
