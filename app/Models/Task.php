<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Task extends Model
{
    public function employees()
    {
        return $this->belongsToMany(Employee::class)->withPivot('assigned_date');
    }
}
