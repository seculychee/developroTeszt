<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BasicError extends Model
{
    protected $table = 'basic_error';

    protected $fillable = [ 'code', 'message' ];

}
