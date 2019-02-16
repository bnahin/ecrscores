<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Percentile
 *
 * @property int $id
 * @property int $psat_data_id
 * @property string $type
 * @property int $percent
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Percentile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Percentile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Percentile query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Percentile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Percentile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Percentile wherePercent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Percentile wherePsatDataId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Percentile whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Percentile whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Percentile extends Model
{
    protected $dates = ['created_at', 'updated_at'];

    protected $guarded = [];

    public function psatData()
    {
        $this->belongsTo(PSAT::class);
    }
}
