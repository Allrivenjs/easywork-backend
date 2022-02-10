<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Files extends Model
{
    use HasFactory;
    protected $fillable = ['url'];
    protected $dates = [
        'created_at',
        'updated_at'
    ];

    public function fileables(){
        return $this->morphTo();
    }
}
