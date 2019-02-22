<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\ScoreRange
 *
 * @property int $id
 * @property int $year
 * @property string $type
 * @property int $level
 * @property int $min
 * @property int $max
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ScoreRange newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ScoreRange newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ScoreRange query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ScoreRange whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ScoreRange whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ScoreRange whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ScoreRange whereMax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ScoreRange whereMin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ScoreRange whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ScoreRange whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ScoreRange whereYear($value)
 * @mixin \Eloquent
 */
class ScoreRange extends Model
{
    protected $guarded = [];
}
