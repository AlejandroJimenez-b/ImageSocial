<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $table = 'favorites';

    public function user() {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function images() {
        return $this->belongsTo('App\Models\Image', 'image_id');
    }

}
