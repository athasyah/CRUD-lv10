<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'start_date', 'end_date', 'budget'];

    public function destinations(){
        return $this->hasMany(Destination::class);
    }

    public function expenses(){
        return $this->hasMany(Expense::class);
    }

    public function companions(){
        return $this->hasMany(Companion::class);
    }

}
