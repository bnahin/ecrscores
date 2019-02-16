<?php

namespace App\Http\Controllers;

use App\Helpers\CourseHelper;
use App\Helpers\Helper;
use App\Helpers\SBACDataHelper;
use App\PSAT;
use App\SBAC;
use Freshbitsweb\Laratables\Laratables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AjaxController extends Controller
{
    public function getTableData(Request $request)
    {
        //Get data according to course, exam
        // Course = base64url(year.course)
        // Exam = type-year

        $request->validate([
            'course' => 'required',
            'exam'   => 'required'
        ]);
        if (!CourseHelper::validCourseData($request->course)) {
            abort(400, "Malformed request");
        }
        $course = explode('.', Helper::base64url_decode($request->course));
        $exam = explode('-', $request->exam);
        if (count($course) !== 2) {
            abort(400, "Malformed request. Course.");
        }
        $courseYear = $course[0];
        $courseName = $course[1];

        if (count($exam) !== 2) {
            abort("Malformed request. Exam.");
        }
        $examType = strtolower($exam[0]);
        $examYear = $exam[1];

        return Laratables::recordsOf($examType === "psat" ? PSAT::class
            : SBAC::class,
            function ($query) use ($examType, $examYear, $courseName, $courseYear) {
                $selections = $query->where('course', $courseName)
                    ->where('grade', $examYear)
                    ->where('year', $courseYear)
                    ->where('teacher', Auth::user()->email);
                if ($examType === "psat") {
                    $selections = $selections->whereNotNull('total');
                }

                return $selections;
            });
    }

    public function getCellData(Request $request)
    {
        $request->validate([
            'grade'  => 'required',
            'ssid'   => 'required',
            'fields' => 'required'
        ]);
        $grade = $request->grade;
        $ssid = $request->ssid;
        $fields = $request->fields;

        return SBACDataHelper::getCellData($request->grade, $request->ssid, $request->fields);
    }
}
