<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Session;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'password',
        'name',
        'email',
        'phone_number',
        'role',
        'gender',
        'birthday',
        'address',
        'image_url',
    ];

    const ROLE = [
        'ADMIN',
        'TEACHER',
        'STUDENT',
    ];

    const GENDER = [
        'Male',
        'Female',
        'Other',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Relationships
     */

    // n student - n class
    public function classrooms()
    {
        return $this->belongsToMany(Classroom::class, 'classroom_students', 'student_id', 'classroom_id');
    }

    // 1 teacher - n class
    public function classes()
    {
        return $this->hasMany(Classroom::class, 'teacher_id', 'id');
    }

    public function isAdmin()
    {
        return $this->role == 1;
    }

    public function isTeacher()
    {
        return $this->role == 2;
    }

    public function isStudent()
    {
        return $this->role == 3;
    }

    public function roleName()
    {
        if ($this->role == 1) {
            return self::ROLE[0];
        } elseif ($this->role == 2) {
            return self::ROLE[1];
        } elseif ($this->role == 3) {
            return self::ROLE[2];
        }

        return 'UNDEFINED_ROLE';
    }

    public function genderName()
    {
        if ($this->gender == 1) {
            return self::GENDER[0];
        } elseif ($this->gender == 2) {
            return self::GENDER[1];
        } elseif ($this->gender == 3) {
            return self::GENDER[2];
        }

        return 'UNDEFINED_GENDER';
    }

    public function uploadFile($file, $userId)
    {
        if ($file) {
            $path = $file->store('avatars/'.$userId, 's3');

            return env('AWS_S3_BASE_URL', 'https://s3-datn.s3.ap-southeast-2.amazonaws.com/').$path;
        } else {
            return $this->image_url;
        }
    }

    public function setSession()
    {
        Session::put('id', $this->id);
        Session::put('name', $this->name);
        Session::put('email', $this->email);
        Session::put('gender', $this->gender);
        Session::put('phone_number', $this->phone_number);
        Session::put('address', $this->address);
        Session::put('role_name', $this->roleName());
        Session::put('role', $this->role);
        Session::put('birthday', $this->birthday);
        Session::put('image_url', $this->image_url);
    }
}
