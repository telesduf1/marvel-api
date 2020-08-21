<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TextObject extends Model
{

    public $timestamps = false;

    public function comic()
    {
        return $this->belongsTo(Comic::class);
    }
}
