<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Imagetest extends Model
{
    protected $table = 'imagetests';
    protected $fillable = ['Name', 'Nummer', 'discripe', 'image'];
    protected $hidden = [];

    
}