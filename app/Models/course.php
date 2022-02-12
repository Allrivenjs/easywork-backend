<?php

namespace App\Models;

use Database\Factories\coursesFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class course extends Model
{
    use HasFactory;
    /** @return coursesFactory */
    protected static function newFactory()
    {
        return coursesFactory::new();
    }
    protected $fillable = ['name','slug','description','owner'];

    public function sections(){
        return $this->hasMany(section::class);
    }

    public function owner(){
        return $this->belongsTo(User::class);
    }
}
