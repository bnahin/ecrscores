<?php
/**
 *
 * @author Blake Nahin <blake@zseartcc.org>
 */

namespace App\Helpers;


use Illuminate\Support\Facades\Auth;

class AuthHelper
{
    public static function countStudents()
    {
        return Auth::user()->getStudents();
    }
}