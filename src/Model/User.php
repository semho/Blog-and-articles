<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public $timestamps = false;
    protected $fillable = ['id', 'full_name', 'avatar', 'email', 'password', 'group_id', 'subscription', 'description'];
    
    /**
     * сохраняем нового пользователя в БД (либо изменяем данные пользователя в БД) и возвращаем его имя,емайл,группу 
     * @param {obj} $user - экземпляр класса User
     * @param {array} $data - массив полей пользователя
     */
    public static function saveUser($user, $data)
    {
        $user->fill($data);
        //записываем в БД
        $user->save();
        if ($user->id) {
            return ['name' => $user->full_name, 'email' => $user->email, 'id' => $user->id, 'group_id' => $user->group_id];
        }
    }
    
    /**
     * получаем преобразованные поля пользователей для отображения в админке в разделе пользователи
     */
    public static function getUserForAdminPanel() {
        
        $users = [];
        $usersDB = self::join('groups', 'users.group_id', '=', 'groups.id')->get(['users.*', 'groups.name as group']);
    
        foreach ($usersDB as $userDB) {
            $users[$userDB->id]['id'] = $userDB->id;
            $users[$userDB->id]['full_name'] = $userDB->full_name;
            $users[$userDB->id]['email'] = $userDB->email;
            $users[$userDB->id]['group'] = $userDB->group;
            if ($userDB->subscription == 1) {
                $users[$userDB->id]['subscription'] = 'Подписан';
            } else {
                $users[$userDB->id]['subscription'] = 'Нет';
            }
        }

        return $users;
    }

    /**
     * получаем преобразованные поля пользователей для отображения в админке в разделе пользователи для пагинации
     */
    public static function getUsersForAdminPaginator($start, $countSelect) {
        
        $users = [];
        $usersDB = self::join('groups', 'users.group_id', '=', 'groups.id')
            ->select('users.*', 'groups.name as group')
            ->orderBy('users.id', 'desc')->skip($start)->take($countSelect)->get();
        
    
        foreach ($usersDB as $userDB) {
            $users[$userDB->id]['id'] = $userDB->id;
            $users[$userDB->id]['full_name'] = $userDB->full_name;
            $users[$userDB->id]['email'] = $userDB->email;
            $users[$userDB->id]['group'] = $userDB->group;
            if ($userDB->subscription == 1) {
                $users[$userDB->id]['subscription'] = 'Подписан';
            } else {
                $users[$userDB->id]['subscription'] = 'Нет';
            }
        }

        return $users;
    }

    /**
     * получаем преобразованные поля пользователей для отображения в админке в разделе подписки
     */
    public static function getUserMailForAdminPanel() {
        
        $users = [];
        $usersDB = self::where('subscription', 1)->get(['id', 'email']);
    
        foreach ($usersDB as $userDB) {
            $users[$userDB->id]['id'] = $userDB->id;
            $users[$userDB->id]['email'] = $userDB->email;
        }

        return $users;
    }
}
