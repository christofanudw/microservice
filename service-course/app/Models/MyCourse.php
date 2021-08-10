<?php

namespace App\Models;

use App\Models\Course;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MyCourse extends Model
{
    use HasFactory;

    protected $table = 'my_courses';

    protected $fillable = [
        'course_id', 'user_id'
    ];

    public function course(){
        return $this->belongsTo('Course');
    }
}
