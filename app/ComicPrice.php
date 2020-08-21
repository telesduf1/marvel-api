<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComicPrice extends Model
{

    public $timestamps = false;

    public function comic()
    {
        return $this->belongsTo(Comic::class);
    }
}
