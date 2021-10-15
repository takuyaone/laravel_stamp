<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stamp extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date',
        'start_work',
        'end_work',
        'break_start',
        'break_end',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getDate()
    {
        return $this->date;
    }


}
