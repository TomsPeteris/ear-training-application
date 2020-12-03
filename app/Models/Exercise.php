<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    use HasFactory;

    const INTERVAL_TYPE = 'interval';
    const CHORD_TYPE = 'chord';
    const MIX_TYPE = 'mix';
    const TYPES = [self::INTERVAL_TYPE, self::CHORD_TYPE, self::MIX_TYPE];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'type',
        'accuracy'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function questions()
    {
        return $this->hasMany('App\Models\Question');
    }
}
