<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Homework extends Model
{
    use HasFactory;

    protected $table = 'homeworks';

    protected $fillable = [
        'homework_name',
        'time',
        'end_time',
    ];

    public function questions()
    {
        return $this->belongsToMany(Question::class, 'homework_questions', 'homework_id', 'question_id');
    }

    public function homeworkQuestions()
    {
        return $this->hasMany(HomeworkQuestion::class, 'homework_id', 'id');
    }
}
