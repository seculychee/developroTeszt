<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommentPost extends Model
{
    protected $table = 'comment_post';

    protected $fillable = [ 'comment_id', 'post_id' ];

}
