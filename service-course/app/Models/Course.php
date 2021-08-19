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

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];
    
    protected $fillable = [
        'name', 'certificate', 'thumbnail', 'type',
        'status', 'price', 'level', 'description', 'mentor_id'
    ];

    public function mentor(){
        return $this->belongsTo(Mentor::class);
    }

    public function chapters(){
        return $this->hasMany(Chapter::class)->orderBy('id', 'ASC');;
    }

    public function courseImages(){
        return $this->hasMany(CourseImage::class)->orderBy('id', 'DESC');
    }
}
