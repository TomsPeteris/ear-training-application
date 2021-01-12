<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Exercise
 *
 * @property int $id
 * @property string $type
 * @property integer $accuracy
 * @property \Illuminate\Support\Carbon|null created_at
 * @property \Illuminate\Support\Carbon|null updated_at
 */
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

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * @return HasMany
     */
    public function questions(): HasMany
    {
        return $this->hasMany('App\Models\Question');
    }
}
