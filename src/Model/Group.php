<?php 

namespace App\Model;

use Illuminate\Database\Eloquent\Model; 

class Group extends Model
{
    public $timestamps = false;
    protected $fillable = ['id', 'name'];
}
