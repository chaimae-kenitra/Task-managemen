<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Employee extends Model
{
    use HasFactory;
 
    public function employees(){
        return $this->hasMany('App\Employee', 'id');
    }
    public function tasks()
    {
        return $this->belongsToMany(Task::class)->withPivot('assigned_date');
    }
  

   
}
