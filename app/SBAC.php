<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SBAC extends Model
{
    /**
     * Database table name
     * @var string $table
     */
    protected $table = 'sbac_data';

    /**
     * Specify columns that are date formatted
     * @var array $dates
     */
    protected $dates = ['created_at', 'updated_at'];

    /**
     * Allow mass column assignment
     * @var array $guarded
     */
    protected $guarded = [];

    public function teacher() {
        return $this->belongsTo(User::class, 'email', 'email');
    }
}
