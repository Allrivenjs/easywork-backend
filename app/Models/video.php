<?php

namespace App\Models;

use Database\Factories\videoFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class video extends Model
{
    use HasFactory;
    protected $fillable=['name','url','description','section_id'];

    /** @return videoFactory */
    protected static function newFactory()
    {
        return videoFactory::new();
    }

    public function sections(){
        return $this->belongsTo(section::class);
    }

}
