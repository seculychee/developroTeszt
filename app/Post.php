<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'post';

    protected $fillable = [
        'id',
        'slug',
        'author',
        'title',
        'body',
        'comments',
        'created_at',
        'updated_at'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'author');
    }

    public function comment()
    {
        return $this->belongsToMany(Comment::class, 'comment_post');
    }
    public function postPaginator()
    {
        return $this->belongsToMany(PostsPaginator::class, 'posts', 'post_id', 'postpage_data', '', 'data');
    }

}
