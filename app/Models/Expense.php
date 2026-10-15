<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = ['description', 'amount', 'activity_id'];

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

    public function expense()
    {
        return $this->belongsTo(Expense::class);
    }
}
