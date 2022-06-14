<?php 

namespace App\Model;

use Illuminate\Database\Eloquent\Model; 

class Log extends Model
{
    public $timestamps = false;
    protected $fillable = ['id', 'date', 'recipients', 'subject', 'message', 'headers'];
}
