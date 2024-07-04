<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'teacher_id',
        'room_id',
        'fee',
    ];
    /**
     * Relationships
     */

    // 1 teacher - n classroom
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id', 'id');
    }

    // n student - n class
    public function classrooms()
    {
        return $this->belongsToMany(User::class, 'classroom_students', 'classroom_id', 'student_id');
    }

    // n student - n class
    public function students()
    {
        return $this->belongsToMany(User::class, 'classroom_students', 'classroom_id', 'student_id');
    }

    // 1 class - 1 room
    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id', 'id');
    }

    // 1 class - n lesson
    public function lessons()
    {
        return $this->hasMany(Lesson::class, 'classroom_id', 'id');
    }

    // 1 class - n exam
    public function exams()
    {
        return $this->hasMany(Exam::class, 'classroom_id', 'id');
    }

    public function classroomStudents()
    {
        return $this->hasMany(ClassroomStudent::class, 'classroom_id', 'id');
    }

    public function countStudent()
    {
        return count($this->students);
    }

    public function revenue()
    {
        return count($this->students) * $this->fee;
    }

    public function countFinished()
    {
        $countFinished = 0;
        foreach ($this->lessons as $lesson) {
            if ($lesson->end_time <= Carbon::now()) {
                $countFinished += 1;
            }
        }

        return $countFinished;
    }
    
    public function percentFinished()
    {
        $percentFinished = 0;
        $percentFinished = $this->countFinished()/ (count($this->lessons)) * 100;

        return $percentFinished;
    }

    public function isFinished()
    {
        foreach ($this->lessons as $lesson) {
            if ($lesson->end_time >= Carbon::now()) {
                return false;
            }
        }

        return true;
    }

    public function countHomework() {
        $countHomework = 0;

        foreach ($this->lessons as $lesson) {
            $countHomework += count($lesson->homeworks);
        }

        return $countHomework;
    }

    public function countDocument() {
        $countDocument = 0;

        foreach ($this->lessons as $lesson) {
            $countDocument += count($lesson->documents);
        }

        return $countDocument;
    }
}
