<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Imagepro extends Model
{
    protected $table = 'imagepros';
    protected $fillable = ['Name', 'image', 'discripe', 'numer'];
    protected $hidden = [];

    
}