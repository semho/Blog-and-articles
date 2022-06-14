<?php 

namespace App\Model;

use Illuminate\Database\Eloquent\Model; 

class Post extends Model
{
    /**
     * Связанная с моделью таблица.
     *
     * @var string
     */
    protected $table = 'posts';
    /**
     * Определяет необходимость отметок времени для модели.
     *
     * @var bool
     */
    public $timestamps = false;
    protected $fillable = ['id', 'name', 'description', 'text', 'img', 'date'];

    /**
     * получаем преобразованные поля статей для отображения в админке
     */
    public static function getPostForAdminPanel() 
    {
        
        $posts = [];
        $postsDB = self::All();
    
        foreach ($postsDB as $postDB) {
            $posts[$postDB->id]['id'] = $postDB->id;
            $posts[$postDB->id]['full_name'] = $postDB->name;
            $posts[$postDB->id]['description'] = $postDB->description;
            $posts[$postDB->id]['date'] = $postDB->date;
        }
        
        return $posts;
    }

    /**
     * получаем все статьи для отображения в админке с пагинацией
     */
    public static function getPostsForAdminPaginator($start, $countSelect)
    {
        $posts = self::orderBy('id', 'desc')->skip($start)->take($countSelect)->get();

        return $posts;
    }
}
