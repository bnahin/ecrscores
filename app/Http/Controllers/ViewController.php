<?php

namespace App\Http\Controllers;

use App\Helpers\CourseHelper;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ViewController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function course(string $data)
    {
        if (!CourseHelper::validCourseData($data)) {
            abort(400, "Malformed request");
        }

        $pieces = explode('.', Helper::base64url_decode($data));
        $year = $pieces[0];
        $course = $pieces[1];
        $courseSerialized = $data;
        $sidebarYear = $year;

        $data = CourseHelper::getScoresFromCourse($year, $course);

        return view('view', compact('data', 'course', 'year', 'sidebarYear', 'courseSerialized'));
    }
}
