<?php

namespace App\Models;

use App\Models\Course;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mentor extends Model
{
    use HasFactory;

    protected $table = 'mentors';

    protected $fillable = [
        'name', 'profile', 'email', 'profession'
    ];

    public function courses(){
        return $this->hasMany('Course');
    }
}
