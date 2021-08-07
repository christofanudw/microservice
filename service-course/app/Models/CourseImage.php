<?php

namespace App\Models;

use App\Models\Course;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CourseImage extends Model
{
    use HasFactory;

    protected $table = 'course_images';

    protected $fillable = [
        'course_id', 'image'
    ];

    public function course(){
        return $this->belongsTo('Course');
    }
}
