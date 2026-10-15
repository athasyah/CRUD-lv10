<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'country','trip_id'];

    public function trip(){
        return $this->belongsTo(Trip::class);
    }

    public function activities(){
        return $this->hasMany(Activity::class);
    }

    public function expenses(){
        return $this->hasMany(Expense::class);
    }
}
