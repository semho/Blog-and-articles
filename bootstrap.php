<?php

define('APP_DIR', '/src/');
//константа пути к шаблонам
define('VIEW_DIR', '/view/');
//константа пути к файлам настройки
define('CONFIG_DIR', '/configs/');
//константа максимального размера аватара профиля
define('MAX_SIZE_IMG', 2097152);
//аватар по умолчанию
define('IMG_DEFAULT', 'avatar.png');
//константа пути к директории загрузки аватаров пользователей
define('UPLOAD_IMG_PROFILE', '/img/users/');
//константа пути к директории загрузки изображения статей
define('UPLOAD_IMG_POSTS', '/img/posts/');
//константа количества записей по умолчению на одной странице
define('COUNT_RECORDS', 20);
//константа количества минимальных записей на одной странице
define('COUNT_RECORDS_MIN', 10);

require_once __DIR__ . '/helpers.php';

require_once __DIR__ . '/vendor/autoload.php';


