<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public $timestamps = false;
    protected $fillable = ['id', 'text', 'date', 'is_check', 'user_id', 'post_id'];

    /**
     * метод получения всех коментарий к конкретной статье с данными пользователей оставивших комментарии
     * @param {int} $articleId - идентификатор статьи
     * @param {bool} $all - выбрать все статьи?
     * @param {int} $idUser - идентификатор пользователя
     */
    public static function getComments($articleId, $all = false, $idUser = false)
    {
        //получаем все утержденные комментарии к данной стратье
        $comments = Comment::where('post_id', $articleId)->where('is_check', 1)->get()->toArray();
        if ($all) {
            //все утвержденные и неутвержденные комментарии к данной статье
            $comments = Comment::where('post_id', $articleId)->get()->toArray();
        }

        if ($idUser) {
            //неутвержденные комментарии к статье текущего пользователя, находящиеся на модерации
            $commentsUser = Comment::where('post_id', $articleId)->where('user_id', $idUser)->where('is_check', 0)->get()->toArray();
            //объединяем все утвержденные комментариями с неутвержденными записями текущего пользователя
            $comments = array_merge($comments, $commentsUser);
        }

        //новая переменная массив
        $fullComments = [];
        //перебираем коментарии
        foreach ($comments as $comment) {
            //получаем id юзера, который оставил коммент
            $userId = $comment['user_id'];    
            //по id получаем все поля пользователя в БД
            $user = User::find($userId)->toArray();
            //создаем новое поля в комментариях с данными о пользователе
            $comment['user'] = $user;
            //добавляем все в новый массив
            $fullComments[] = $comment;
        }

        return $fullComments;
    }

    /**
     * метод преобразовывает поля таблицы комментариев в удобный вид для отображения в админке
     */
    public static function getCommentsForAdmin()
    {
        $comments = [];
        $commentsDB = self::join(
            'users', 'comments.user_id', '=', 'users.id')
            ->join('posts', 'comments.post_id', '=', 'posts.id')
            ->select('comments.id as comment_id', 'comments.text', 'comments.is_check', 'users.id as user_id', 'users.email', 'posts.id as post_id', 'posts.name as post_name')
            ->orderBy('comments.id', 'asc')->take(COUNT_RECORDS)->get();

        foreach ($commentsDB as $commentDB) {
            $comments[$commentDB->comment_id]['id'] = $commentDB->comment_id;
            $comments[$commentDB->comment_id]['text'] = $commentDB->text;
            $comments[$commentDB->comment_id]['post'] = $commentDB->post_name;
            $comments[$commentDB->comment_id]['email'] = $commentDB->email;
        
            if ($commentDB->is_check == 1) {
                $comments[$commentDB->comment_id]['is_check'] = 'Да';
            } else {
                $comments[$commentDB->comment_id]['is_check'] = 'Нет';
            }
        }

        return $comments;
    }

    /**
     * метод преобразовывает поля таблицы комментариев в удобный вид для отображения в админке c пагинацией
     */
    public static function getCommentsForAdminPaginator($start, $countSelect)
    {
        $comments = [];
        $commentsDB = self::join(
            'users', 'comments.user_id', '=', 'users.id')
            ->join('posts', 'comments.post_id', '=', 'posts.id')
            ->select('comments.id as comment_id', 'comments.text', 'comments.is_check', 'users.id as user_id', 'users.email', 'posts.id as post_id', 'posts.name as post_name')
            ->orderBy('comments.id', 'desc')->skip($start)->take($countSelect)->get();
            
        foreach ($commentsDB as $commentDB) {
            $comments[$commentDB->comment_id]['id'] = $commentDB->comment_id;
            $comments[$commentDB->comment_id]['text'] = $commentDB->text;
            $comments[$commentDB->comment_id]['post'] = $commentDB->post_name;
            $comments[$commentDB->comment_id]['email'] = $commentDB->email;
        
            if ($commentDB->is_check == 1) {
                $comments[$commentDB->comment_id]['is_check'] = 'Да';
            } else {
                $comments[$commentDB->comment_id]['is_check'] = 'Нет';
            }
        }

        return $comments;
    }

    /**
     * метод преобразовывает поля таблицы конкретного комментари в удобный вид для отображения в админке
     */
    public static function getCommentForAdmin($id)
    {
        $comment = self::find($id);
        $user = User::where('id', $comment->user_id)->get(['id', 'email'])->first();
        $post = Post::where('id', $comment->post_id)->get(['id', 'name'])->first();

        return ['comment' => $comment, 'author' => $user, 'post' => $post];
    }
}
