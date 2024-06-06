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

    public function homework()
    {
        return $this->belongsTo(Homework::class, 'homework_id', 'id');
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id', 'id');
    }
}
