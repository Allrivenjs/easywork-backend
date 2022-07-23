<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['body', 'own_id', 'parent_id'];
    protected $hidden = ['commentable_id', 'commentable_type'];


    /**
     * Interact with the comment own.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */

    protected function sendEventData(): Attribute
    {
        return Attribute::make(
            get: fn () => [
                'own'=> $this->owner()->first(),
                'task'=>$this->commentable()->first(),
                'body'=>$this->body,
                'created_at'=>$this->created_at,
                'updated_at'=>$this->updated_at,
                'replies'=>$this->replies()->get(),
                'id'=>$this->id,
            ],
        );
    }



    public function replies(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Comment::class, 'parent_id')->with(['replies','owner']);
    }

    public function parent(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function owner(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'own_id')->with('profile');
    }

    public function commentable(): \Illuminate\Database\Eloquent\Relations\MorphTo
    {
        return $this->morphTo();
    }




}
