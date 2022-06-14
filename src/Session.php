<?php 

namespace App;

final class Session 
{
    /**
	 * Открыта ли сессия
	 */
	private static $started = false;

    /**
	 * Безопасное открытие сессии
	 */
	private static function safeSessionStart()
	{
		$name = session_name();
		$cookie_session = false;
        
		if (ini_get('session.use_cookies') && isset($_COOKIE[$name])) {
			$cookie_session = true;
			$sessid = $_COOKIE[$name];
		} elseif (!ini_get('session.use_only_cookies') && isset($_GET[$name])) {
			$sessid = $_GET[$name];
		} else {
			return @session_start();
		}
		
		if (is_array($sessid) || !preg_match('/^[a-zA-Z0-9,-]+$/', $sessid)) {
			if ($cookie_session) {
				setcookie($name, '', 1);
				unset($_COOKIE[$name]);
				if (!ini_get('session.use_only_cookies') && isset($_GET[$name])) {
                    unset($_GET[$name]);
				}
				return @session_start();
			}
			
			return false;
		}
		
		return @session_start();
	}
 
	/**
	 * Открыть сессию
	 */
	public static function init()
	{
		if (!self::$started) {
			if (self::safeSessionStart()) {
				self::$started = true;
            }
		}
	}
	
	/**
	 * Открыта ли сессия
	 */
	public static function isStarted()
	{
		return self::$started;
	}
	
	/**
	 * Завершить сессию
	 */
	public static function close()
	{
		if (self::$started) {
			session_write_close();
			self::$started = false;
		}
	}
	
	/**
	 * Получить значение ключа с именем $name из сессии
	 * Если ключ отсутствует, будет возвращено значение $default_value
	 * @param {string} $name - название сессии
	 * @param {string} $default_value - любое переданное значение, по умочанию null
	 */
	public static function get($name, $default_value = null)
	{
		return isset($_SESSION[$name]) && !is_array($_SESSION[$name]) ? $_SESSION[$name] : $default_value;
	}
	
	/**
	 * Установить значение ключа с именем $name в $value
	 * @param {string} $name - название сессии
	 * @param {string} $value - значение сессии
	 */
	public static function set($name, $value)
	{
		$_SESSION[$name] = $value;
	}
	
	/**
	 * Удалить ключ с именем $name из сессии
	 * @param {string} $name - название сессии
	 */
	public static function remove($name)
	{
		unset($_SESSION[$name]);
	}
    
	/**
	 * Полностью очищаем все данные пользователя
	 */
    public static function destroyAll() 
    {
        session_destroy();
    }
    
    /**
	 *   Устанавливаем куки  
     * @param {string} $name - название куки
     * @param {string} $value - значение куки
     */
    public static function setCookie($name, $value)
    {
        setcookie($name, $value, time()+60*60*24*30, '/');
    }
	
    /**
     * Получаем куки
     * @param {string} $name - название куки
     */
    public static function getCookie($name)
    {
		if (isset($_COOKIE[$name])) return $_COOKIE[$name];
    }

    /**
     * Удалаяем куки
	 * @param {string} $name - название куки
     */
    public static function removeCookie($name)
    {
        setcookie($name, null);
    }

	/**
	 * устанавливаем сессию, записываем куку и отправляемся на главную
     * @param {arrayt} $data - массив полей пользователя
     * @param {bool} $isIndex по умолчанию переходит на главную после записи кук и сесии
     */
	public static function sessionSave($data, $isIndex = true)
    {
        //если сессия уже стартовала
        if (self::isStarted()) {
            //устанавливаем названия сессий
            self::set('email', $data['email']);
            self::set('name', $data['name']);
            self::set('id', $data['id']);
			self::set('group_id', $data['group_id']);
            //устанавливаем куку
            self::setCookie('email', $data['email']);
            if ($isIndex) {
                header('Location: /');
                die();   
            }
        }
    }

	/**
	 * разлогирование сессии
    */
	public static function logout()
    {
        if (self::isStarted()) {
            self::destroyAll();
            header('Location: /');
            die();
        }
    }
}
