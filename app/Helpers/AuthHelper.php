<?php
/**
 *
 * @author Blake Nahin <blake@zseartcc.org>
 */

namespace App\Helpers;


use App\PSAT;
use App\SBAC;
use Illuminate\Support\Facades\Auth;

final class AuthHelper
{
    public static function countStudents()
    {
        return Auth::user()->getStudents();
    }

    /**
     * Get teachers.
     */
    public static function getTeachers()
    {
        $sbacTeachers = SBAC::groupBy('teacher')->orderBy('teacher')->pluck('teacher');
        $psatTeachers = PSAT::groupBy('teacher')->orderBy('teacher')->pluck('teacher');

        $teachers = $sbacTeachers->flip()->merge($psatTeachers->flip())->flip(); //Combine collections

        return $teachers;
    }
}