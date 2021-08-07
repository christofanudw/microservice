<?php

namespace App\Models;

use App\Models\Mentor;
use App\Models\Chapter;
use App\Models\CourseImage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory;
    
    protected $table = 'courses';
    
    protected $fillable = [
        'name', 'certificate', 'thumbnail', 'type',
        'status', 'price', 'level', 'description', 'mentor_id'
    ];

    public function mentor(){
        return $this->belongsTo('Mentor');
    }

    public function chapters(){
        return $this->hasMany('Chapter')->orderBy('id', 'ASC');;
    }

    public function courseImages(){
        return $this->hasMany('CourseImage')->orderBy('id', 'DESC');
    }
}
