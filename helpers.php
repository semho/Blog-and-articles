<?php

function array_get(array $array, string $key, $default = null) 
{
    //передаваемый массив
    $result = $array;
    //делим по точке строку в массив
    $arrayKey = explode('.', $key);
    foreach ($arrayKey as $key) {
        //если есть данный ключ в передаваемом массиве
        if (array_key_exists($key, $result)) {
            //сохраняем значение в переменную
            $result = $result[$key];
        } else {
            //иначе возвращаем значение по умолчанию
            return $default;
        }
    }
 
    return $result;
}

function dd(...$params)
{
    echo '<pre>';
    var_dump($params);
    echo '</pre>';
    die;
}

function dump(...$params)
{
    echo '<pre>';
    var_dump($params);
    echo '</pre>';
}
