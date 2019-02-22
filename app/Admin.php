<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Admin
 *
 * @property int                             $id
 * @property string                          $fname
 * @property string                          $lname
 * @property string                          $email
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin whereFname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin whereLname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read mixed $full_name
 */
class Admin extends Model
{
    protected $guarded = [];

    protected $dates = ['created_at', 'updated_at'];

    public function getFullNameAttribute()
    {
        return ucwords("{$this->fname} {$this->lname}");
    }
}
