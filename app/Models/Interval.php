<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interval extends Model
{
    use HasFactory;

    const ASCENDING_DIRECTION = 'ascending';
    const DESCENDING_DIRECTION = 'descending';
    const DIRECTIONS = [self::ASCENDING_DIRECTION, self::DESCENDING_DIRECTION];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'distance',
    ];

    public function questions()
    {
        return $this->morphMany('App\Models\Question', 'questionable');
    }
}
