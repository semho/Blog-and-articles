<?php 

namespace App\Model;

use Illuminate\Database\Eloquent\Model; 

class Mailing extends Model
{
    public $timestamps = false;
    protected $fillable = ['id', 'email'];

     /**
     * получаем преобразованные поля подписчиков для отображения в админке
     */
    public static function getSubsrcForAdminPanel() 
    {
        
        $mails = [];
        $mailsDB = self::all();
    
        foreach ($mailsDB as $mailDB) {
            $mails[$mailDB->id]['id'] = $mailDB->id;
            $mails[$mailDB->id]['email'] = $mailDB->email;
        }
        
        return $mails;
    }

     /**
     * получаем записи подписчиков для отображения в админке с пагинацией
     */
    public static function getSubsrcForAdminPaginator($start, $countSelect) 
    {
        
        return self::orderBy('id', 'desc')->skip($start)->take($countSelect)->get();
    }
}
