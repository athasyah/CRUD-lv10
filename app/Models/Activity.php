<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'time', 'cost', 'destination_id'];

    public function destination(){
        return $this->belongsTo(Destination::class);
    }

    public function expense(){
        return $this->hasMany(Expense::class);
    }
}
