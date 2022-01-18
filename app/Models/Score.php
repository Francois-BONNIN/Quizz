<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    use HasFactory;

    public function user(){
        return $this->belongsToMany(User::class);
    }

    public function quiz(){
        return $this->belongsTo(Quiz::class);
    }
}
