<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'questionable_type',
        'questionable_id',
        'answer',
        'direction',
        'type',
        'root',
        'exercise_id'
    ];

    public function exercise()
    {
        return $this->belongsTo('App\Models\Exercise');
    }

    public function note()
    {
        return $this->belongsTo('App\Models\Note');
    }

    public function questionable()
    {
        return $this->morphTo();
    }
}
