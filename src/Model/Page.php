<?php 

namespace App\Model;

use Illuminate\Database\Eloquent\Model; 

class Page extends Model
{
    public $timestamps = false;
    protected $fillable = ['id', 'title', 'text', 'slug'];

    /**
     * получаем преобразованные поля страниц для отображения в админке
     */
    public static function getPageForAdminPanel() 
    {
        
        $pages = [];
        $pagesDB = self::All();
    
        foreach ($pagesDB as $pageDB) {
            $pages[$pageDB->id]['id'] = $pageDB->id;
            $pages[$pageDB->id]['title'] = $pageDB->title;
            $pages[$pageDB->id]['slug'] = $pageDB->slug;
        }
        
        return $pages;
    }

    /**
     * получаем список страниц для отображения в админке с пагинацией
     */
    public static function getPagesForAdminPaginator($start, $countSelect) 
    {
        
        $pages = self::orderBy('id', 'desc')->skip($start)->take($countSelect)->get();
        
        return $pages;
    }
}
