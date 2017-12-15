<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comment';

    protected $fillable = ['id', 'author', 'body', 'created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo('App\User', 'author');
    }
    public function post()
    {
        return $this->belongsToMany(Post::class, 'comment_post', 'comment_id' , '', 'id');
    }


}
