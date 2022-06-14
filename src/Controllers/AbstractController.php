<?php

namespace App\Controllers;

use App\Session;
use App\Model\User;
use App\View\View;

abstract class AbstractController
{
    public $user;

    /**
     * определяем авторизированного пользователя
     */
    public function __construct($answer = false)
    {
        if (Session::isStarted() && !empty(Session::get('email'))) {
            $this->user = User::where('email', Session::get('email'))->first();
        }

        if ($answer && !$this->user) {
            return new View('errors/error', ['message' => 'Пользователь не найден', 'code' => 401]);
        } 
    }

    /**
     * метод редиректа
     */
    public function redirect($path)
    {
        header("Location: $path");
        die();  
    }

    /**
     * метод определения группы админа
     */
    public function isAdmin(): bool
    {
        if (isset($this->user) && $this->user->group_id == 1) {
            
            return true;
        }

        return false;
    }

     /**
      * метод определения группы менеждера
      */
    public function isManager(): bool
    {
        if (isset($this->user) && $this->user->group_id == 1 || isset($this->user) && $this->user->group_id == 2) {
            
            return true;
        }

        return false;
    }

    /**
     * метод определяет группу авторизированного пользователя
     */
    public function isAuthUser(): bool
    {
        if (isset($this->user) && $this->user->group_id == 3) {
            
            return true;
        }

        return false;
    }
}
