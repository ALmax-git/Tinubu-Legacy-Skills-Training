<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;
    protected $fillable = [
        'first_name',
        'surname',
        'last_name',
        'state',
        'lga',
        'address',
        'phone_number',
        'student_photo',
        'dob',
        'gender',
        'school_id',
        'school_class_id',
        'mentors_name',
        'mentors_address',
        'mentors_phone',
        'fathers_name',
        'fathers_address',
        'fathers_phone_number'
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class);
    }
}
