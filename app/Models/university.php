<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class university extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable=['name'];
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function profiles(){
        return $this->belongsToMany(profile::class);
    }
}
