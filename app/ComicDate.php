<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComicDate extends Model
{

    public $timestamps = false;

    public function comic()
    {
        return $this->belongsTo(Comic::class);
    }
}
