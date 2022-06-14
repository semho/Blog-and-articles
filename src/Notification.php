<?php

namespace App;

use App\Model\Post;
use App\Model\Mailing;
use App\Model\User;
use App\Model\Log;

class Notification 
{

    /**
     * добавляем лог в базу данных
     * @param {string} $to - получатели письма
     * @param {string} $subject - тема письма
     * @param {string} $message - тело письма
     * @param {string} $headers - заголовки
     */
    private function addLog($to, $subject, $message, $headers) 
    {
        $today = date("Y.m.d H:i:s "); 

        $log = new Log();
        $log->date = $today;
        $log->recipients = $to;
        $log->subject = $subject;
        $log->message = $message;
        $log->headers = $headers;
        $log->save();
        
    }
    
    /**
     * метод формирует письмо
     *  @param {int} $id - id новой статьи
     */
    public function SendTo($id)
    {
        $article = Post::find($id);

        $recipients = Mailing::select('email')->get()->toArray();
        $subscribers = User::where('subscription', 1)->select('email')->get()->toArray();
        $arrayEmails = array_merge($recipients, $subscribers);
        
        $arrayTo = [];

        foreach ($arrayEmails as $mail) {
            $arrayTo[] = $mail['email'];
        }
        // несколько получателей
        $to = implode(', ', $arrayTo);
        // тема письма
        $subject = "На сайте добавлена новая запись: \"" . $article->name . "\"";

        // текст письма
        $message = "
        <html>
            <head>
                <title>$article->name</title>
            </head>
            <body>
                <table>
                    <tr>
                        <td>Новая статья: \"$article->name\"</td>
                    </tr>
                    <tr>
                        <td>$article->description</td>
                    </tr>
                    <tr>
                        <td>
                            <a href='http://localhost:8080/posts/$article->id'>Читать</a>
                        </td>
                    </tr>
                    <tr style='height:20px'><td></td></tr>
                    <tr style='border-bottom:1px dotted grey'>
                        <td colspan='100%'></td>
                    </tr>
                    <tr style='height:20px'><td></td></tr>
                    <tr>
                        <td>
                            <a href='http://localhost:8080/unsubscribe'>Отписаться от рассылки</a>
                        </td>
                    </tr>
                </table>
            </body>
        </html>
        ";

        // Для отправки HTML-письма должен быть установлен заголовок Content-type
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

        // Отправляем
        // mail($to, $subject, $message, $headers);

        $this->addLog($to, $subject, $message, $headers);
    }

}
