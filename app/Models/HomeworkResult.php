<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeworkResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'homework_id',
        'student_id',
        'score',
        'is_finished',
    ];
}
