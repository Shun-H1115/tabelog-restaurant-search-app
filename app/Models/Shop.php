<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Shop extends Model
{
    use HasFactory;

    public function reviews() {
        return $this->hasMany(Reviews::class);
    }

    public function favorites() {
        return $this->hasMany(Favorites::class);
    }
}
