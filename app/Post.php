<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //
    protected $table = 'Posts';
    protected $fillable = ['id', 'dataId', 'eventId', 'uuid','teamId', 'email', 'firstName','lastName','title','company','content','created','updated'];


}
