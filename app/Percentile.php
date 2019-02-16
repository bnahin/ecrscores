<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Percentile extends Model
{
    protected $dates = ['created_at', 'updated_at'];

    protected $guarded = [];

    public function psatData()
    {
        $this->belongsTo(PSAT::class);
    }
}
