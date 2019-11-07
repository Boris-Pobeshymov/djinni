<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RedirectLinks extends Model
{
    protected $fillable = ['user_id', 'old_slug', 'slug', 'status'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
}
