<?php

namespace App\Controllers;

use App\View\View;
use App\Session;
use App\Validate;
use App\Model\Page;

class ProfileController extends AbstractController
{
    public $validate;
    
    public function __construct()
    {
        $this->validate = new Validate();
        //наследуем конструктор абстрактного класса        
        parent::__construct(true);
    }

    /**
     * метод просмотра/изменения профиля
     */
    public function changeProfile()
    {
        if (empty($_POST) || empty($_FILES)) { 
            return new View('profile.lk', [
                'title' => 'Cтраница профиля', 
                'user' => $this->user, 
                'listStaticPages' => Page::select('id', 'title', 'slug')->get()->toArray(),
            ]);        
        }
        
        $dataPhoto = $_FILES['profile-photo'];
        $nameProfile = strip_tags($_POST['name']);
        $emailProfile = strip_tags($_POST['email']);
        $checkboxProfile = 1;

        if ($this->user->subscription == 1 && isset($_POST['checkboxNo'])) {
            $checkboxProfile = 0;
        }

        if ($this->user->subscription == 0 && !isset($_POST['checkboxYes'])) {
            $checkboxProfile = 0;
        }

        $descriptionProfile = strip_tags($_POST['description']);

        //результат обработки фото профиля
        $resultSaveImgProfile = $this->saveImgProfile($dataPhoto, $this->user->id, $this->user->avatar);
       
        //валидация изменений профиля
        $resultValidateProfile = $this->validate->validateProfile(
            [
                'name' => $nameProfile, 
                'email' => $emailProfile, 
                'check' => $checkboxProfile, 
                'desc' => $descriptionProfile,
                'sizeImg' => $dataPhoto['size'],
                'img' => $resultSaveImgProfile['img'],
            ], 
            $this->user->id, 
            $this->user->email
        );
        
        //если есть ошибки
        if (!empty($resultValidateProfile['error']) || !empty($resultSaveImgProfile['error'])) {
            if (!empty($resultValidateProfile['error']) && !empty($resultSaveImgProfile['error'])) {
                $resultValidateProfile['error'] = array_merge($resultValidateProfile['error'], $resultSaveImgProfile['error']);
            } elseif (!empty($resultSaveImgProfile['error'])) {
                $resultValidateProfile['error'] = $resultSaveImgProfile['error'];
            }
            
            return new View('profile.lk', [
                'title' => 'Cтраница профиля',
                'user' => $this->user, 
                'errors' => $resultValidateProfile['error'],
                'listStaticPages' => Page::select('id', 'title', 'slug')->get()->toArray(),
            ]);       
        //иначе записываем в сессию и куки
        } else {
            Session::sessionSave([
                'name' => $resultValidateProfile['user']['name'], 
                'email' => $resultValidateProfile['user']['email'],
                'id' => $resultValidateProfile['user']['id'],
                'group_id' => $resultValidateProfile['user']['group_id'],
            ], false);
            $this->redirect('/lk');
        }
    }

    /**
     * обработка/сохранение фото профиля
     * @param {array} $data - массив полей файла изображения пользователя
     * @param {int} $id - идентификатор пользователя
     * @param {string} $oldAvatar - название файла прежнего аватара
     */
    public function saveImgProfile($data, $id, $oldAvatar)
    {   
        //директория для загрузки
        $uploadPath = $_SERVER['DOCUMENT_ROOT'] . UPLOAD_IMG_PROFILE;
        //получаем расширение загружаемого файла
        $endFile =  substr($data['name'], strrpos($data['name'], '.'));
        //регулярное выражение для расширение загружаемого файла
        $pattern = "/^\.(png|jpg|jpeg|gif)$/";
        //если расширение файла не .jpg или .png
        if (!preg_match($pattern, $endFile) && !empty($data['name'])) {
            //оставляем картинку по умолчанию
            return ['img' => IMG_DEFAULT, 'error' => ['endFile' => 'Формат изображения выбран не верно!']];   
        //если размер файла больше 0 и меньше максимально заданного
        } elseif ($data['size'] > 0 && $data['size'] < MAX_SIZE_IMG) {
            //если директории нет, создаем ее
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            //новое имя файла
            $imgName = 'avatar_' . $id . $endFile;
            //директория с именем файла
            $uploadFile = $uploadPath . $imgName;
            //если файл с таким именем уже существует в этой директории
            if (file_exists($uploadFile)) {
                //удаляем его
                @unlink($uploadFile);
            } 
            //далее перемещаем в директорию загружаемый файл
            if (move_uploaded_file($data['tmp_name'], $uploadFile)) {
                return ['img' => $imgName]; 
            }
        } else {
            return ['img' => $oldAvatar]; 
        }
    }
}
