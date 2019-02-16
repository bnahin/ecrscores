<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;

/**
 * App\User
 *
 * @property int
 *               $id
 * @property string
 *               $name
 * @property string
 *               $email
 * @property string|null
 *               $email_verified_at
 * @property string
 *               $password
 * @property string|null
 *               $remember_token
 * @property \Illuminate\Support\Carbon|null
 *               $created_at
 * @property \Illuminate\Support\Carbon|null
 *               $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[]
 *                $notifications
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string                                                    $google_id
 * @property string                                                    $first_name
 * @property string                                                    $last_name
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereGoogleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereLastName($value)
 * @property int                                                       $is_admin
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\PSAT[] $psatStudents
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereIsAdmin($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\SBAC[] $sbacStudents
 * @property-read mixed                                                $full_name
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are guarded.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['remember_token'];

    /**
     * PSAT Data.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function psatStudents()
    {
        return $this->hasMany(PSAT::class, 'teacher', 'email');
    }

    /**
     * SBAC Data.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sbacStudents()
    {
        return $this->hasMany(SBAC::class, 'teacher', 'email');
    }

    /**
     * Uppercase full name.
     * @return string
     */
    public function getFullNameAttribute()
    {
        return ucwords("{$this->first_name} {$this->last_name}");
    }

    /**
     * Get combined collection of years that have data.
     * @return \Illuminate\Support\Collection
     */
    public function getYears()
    {
        $sbacYears = $this->sbacStudents()->groupBy('year')->pluck('year');
        $psatYears = $this->psatStudents()->groupBy('year')->pluck('year');

        $years = $sbacYears->flip()->merge($psatYears->flip())->flip(); //Combine collections

        return $years;
    }

    /**
     * Get combined collection of courses that have data
     *
     * @param string $year
     *
     * @return \Illuminate\Support\Collection
     */
    public function getCourses(string $year)
    {
        $sbacCourses = $this->sbacStudents()->where('year', $year)
            ->groupBy('course')->pluck('course');
        $psatCourses = $this->psatStudents()->where('year', $year)
            ->groupBy('course')->pluck('course');

        $courses = $sbacCourses->flip()->merge($psatCourses->flip())->flip(); //Combine collections

        return $courses;
    }

    /**
     * Get student count.
     * @return int
     */
    public function getStudents(): int
    {
        $sbacStudents = $this->sbacStudents()->groupBy('ssid')->pluck('ssid');
        $psatStudents = $this->psatStudents()->groupBy('ssid')->pluck('ssid');

        $students = $sbacStudents->flip()->merge($psatStudents->flip())->flip(); //Combine collections

        return $students->count();
    }
}
