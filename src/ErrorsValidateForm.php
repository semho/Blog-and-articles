<?php 

namespace App;

use App\Model\User;

final class ErrorsValidateForm 
{
    /**
     * запись ошибки на email
     * @param {string} $email - email пользователя
     * @param {bool} $reg - флаг регистрации
     * @param {string} $currentEmail - вводимый email
     */
    public static function errorEmail($email, $reg = null, $currentEmail = null)
    {
        $patternEmail = '/^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/';
        if (!preg_match($patternEmail, $email)) return 'Не верный формат email';

        if ($reg) {
            $findUser =  User::where('email', $email)->first();
            if ($findUser && $findUser->email !== $currentEmail) return 'Такой электронный адрес уже занят';
        }

        return false;
    }
    
    /**
     * запись ошибки на пароль
     * @param {string} $password - password пользователя
     */
    public static function errorPassword($password)
    {
        $len = mb_strlen($password);
        if ($len < 6) return 'Пароль должен быть минимум 6 символов';

        return false;
    }
    
    /**
     * запись ошибки на отсутствие пользователя в 
     * @param {obj} $user - эземпляр класса User
     */
    public static function errorUserNotFound($user)
    {
        if (!$user) return 'Текущий пользователь не найден';

        return false;
    }
    
    /**
     * запись ошибки на несовпадения паролей
     * @param {string} $user - user пользователя
     * @param {string} $password - password пользователя
     */
    public static function errorValidatePassword($user, $password)
    {
        if ($user && !password_verify($password, $user->password)) return 'Пароль введен не верно';

        return false;
    }
    
    /**
     * запись ошибки на имя
     * @param {string} $name - name пользователя
     */
    public static function errorName($name, $default = null)
    {
        $patternName = '/^[a-zA-Zа-яА-ЯёЁ\'][a-zA-Z-а-яА-ЯёЁ\' ][a-zA-Z-а-яА-ЯёЁ\' ]+[a-zA-Zа-яА-ЯёЁ\']?$/u';
        //валидация имени
        if (!preg_match($patternName, $name)) {
            if ($default !== null) {
                return $default;
            } else {
                return 'Не верный формат имени';
            }
        }
    
        return false;
    }

      /**
     * запись ошибки на заголовок
     * @param {string} $title - заголовок
     */
    public static function errorTitle($title, $default = null)
    {
        $patternName = '/^[a-zA-Zа-яА-ЯёЁ0-9\'][a-zA-Z-а-яА-ЯёЁ0-9\' ][a-zA-Z-а-яА-ЯёЁ0-9\' ]+[a-zA-Zа-яА-ЯёЁ0-9\']?$/u';
        //валидация имени
        if (!preg_match($patternName, $title)) {
            if ($default !== null) {
                return $default;
            } else {
                return 'Не верный формат заголовка, либо он пустой';
            }
        }
    
        return false;
    }
    
    /**
     * проверка на совпадения значений паролей
     * @param {string} $password - пароль пользователя
     * @param {string} $password2 - повторный пароль пользователя
     */
    public static function errorDifferntPasswords($password, $password2)
    {
        if ($password !== $password2) return 'Подтверждение пароля не верно';
        
        return false;
    }
    
    /**
     * запись ошибки на непринятие согласия с правилами сайта
     * @param {bool} $check - чекбокс
     */
    public static function errorRules($check)
    {
        if ($check !== 'yes') return 'Правила сайта не приняты';
        
        return false;
    }
    
    /**
     * запись ошибки на превышение размера фотографии
     * @param {string} $img - текущий размер фото
     */
    public static function errorMaxSizeImg($img)
    {
        if ($img > MAX_SIZE_IMG) return 'Изображение превышает ' . MAX_SIZE_IMG . ' МБ';

        return false;
    }

    /**
     * запись ошибки неверного формата файла изображения
     * @param {array} $data - массив с данными файла
     */
    public static function errorEndFile($data)
    {
        //регулярное выражение для расширение загружаемого файла
        $pattern = "/^\.(png|jpg|jpeg|gif)$/";
        //получаем расширение загружаемого файла
        $endFile =  substr($data['name'], strrpos($data['name'], '.'));

        if (!preg_match($pattern, $endFile) && !empty($data['name'])) {
            return 'Формат изображения выбран не верно!';
        } 
    }
}
