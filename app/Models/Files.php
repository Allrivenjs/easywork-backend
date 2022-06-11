<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Files extends Model
{
    use HasFactory;
    protected $fillable = ['url', 'mime','originalName'];
    protected $visible = ['url', 'mime','originalName'];
    protected $dates = [
        'created_at',
        'updated_at'
    ];
    public function getCreatedAtAttribute($value){
        return Carbon::parse($value)->diffForHumans();
    }

    public function getUpdatedAtAttribute($value){
        return Carbon::parse($value)->diffForHumans();
    }


    public function fileables(){
        return $this->morphTo();
    }
}
