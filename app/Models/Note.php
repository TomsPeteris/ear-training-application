<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sound'
    ];

    public function questions()
    {
        return $this->hasMany('App\Models\Question');
    }

    public function getSoundPath()
    {
        return $this->sound ? asset('storage/'.$this->sound) : null;
    }
}
