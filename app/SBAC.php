<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\SBAC
 *
 * @property int $id
 * @property \App\User $teacher
 * @property string $fname
 * @property string $lname
 * @property int $ssid
 * @property string $course
 * @property int|null $math_scale
 * @property int|null $math_level
 * @property int|null $reasoning
 * @property int|null $concepts
 * @property int|null $modeling
 * @property int|null $ela_scale
 * @property int|null $ela_level
 * @property int|null $inquiry
 * @property int|null $listening
 * @property int|null $reading
 * @property int|null $writing
 * @property int $grade
 * @property string $year
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SBAC newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SBAC newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SBAC query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SBAC whereConcepts($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SBAC whereCourse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SBAC whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SBAC whereElaLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SBAC whereElaScale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SBAC whereFname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SBAC whereGrade($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SBAC whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SBAC whereInquiry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SBAC whereListening($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SBAC whereLname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SBAC whereMathLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SBAC whereMathScale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SBAC whereModeling($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SBAC whereReading($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SBAC whereReasoning($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SBAC whereSsid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SBAC whereTeacher($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SBAC whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SBAC whereWriting($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SBAC whereYear($value)
 * @mixin \Eloquent
 */
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
