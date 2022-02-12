<?php

namespace App\Models;

use Database\Factories\sectionsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class section extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'course_id'];

    /** @return sectionsFactory */
    protected static function newFactory()
    {
        return sectionsFactory::new();
    }

    public function course(){
        return $this->belongsTo(course::class);
    }

    public function videos(){
        return $this->hasMany(video::class);
    }
}
