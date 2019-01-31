<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * App\PSAT
 *
 * @property int $id
 * @property \App\User $teacher
 * @property string $fname
 * @property string $lname
 * @property int $ssid
 * @property string $course
 * @property string $readwrite
 * @property string $math
 * @property string $total
 * @property int $grade
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PSAT newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PSAT newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PSAT query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PSAT whereCourse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PSAT whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PSAT whereFname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PSAT whereGrade($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PSAT whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PSAT whereLname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PSAT whereMath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PSAT whereReadwrite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PSAT whereSsid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PSAT whereTeacher($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PSAT whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PSAT whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $year
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PSAT whereYear($value)
 */
class PSAT extends Model
{
    /**
     * Database table name
     * @var string $table
     */
    protected $table = 'psat_data';

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

    public function getFirstNameAttribute() {
        return ucwords($this->fname);
    }

    public function getLastNameAttribute() {
        return ucwords($this->lname);
    }
}
