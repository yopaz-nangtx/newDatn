<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LessonHomework extends Model
{
    protected $table = 'lesson_homeworks';

    use HasFactory;

    protected $fillable = [
        'lesson_id',
        'homework_id',
    ];
}
