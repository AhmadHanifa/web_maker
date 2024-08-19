<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'employees';
    protected $fillable = ['name', 'company_id', 'description'];
    protected $hidden = [];

    
    public function test267()
    {
        return $this->belongsTo(Test267::class);
    }
        
}