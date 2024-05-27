<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentLesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'lesson_id',
        'document_id',
    ];
}
