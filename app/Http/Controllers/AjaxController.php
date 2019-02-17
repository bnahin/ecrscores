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
use Illuminate\Support\Facades\DB;

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

    public function getSparkline(Request $request)
    {
        $request->validate([
            'course' => 'required',
            'exam'   => 'required',
            'field'  => 'required'
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

        $result = DB::table($examType . "_data")->where([
            'teacher' => Auth::user()->email,
            'grade'   => $examYear,
            'course'  => $courseName,
            'year'    => $courseYear
        ]);
        if ($examType === "psat") {
            $result = $result->whereNotNull('total');
        }
        $field = $request->field;

        return Helper::formatForSparkline($result->get(), $field);
    }

    public function getAllSparklines(Request $request)
    {
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

        $result = DB::table($examType . "_data")->where([
            'teacher' => Auth::user()->email,
            'grade'   => $examYear,
            'course'  => $courseName,
            'year'    => $courseYear
        ]);
        if ($examType === "psat") {
            $result = $result->whereNotNull('total');
        }

        $return = ['box' => [], 'pie' => []];
        foreach (DB::getSchemaBuilder()->getColumnListing('sbac_data') as $field) {
            if (in_array($field,
                ['id', 'teacher', 'fname',
                    'lname', 'ssid', 'course', 'grade',
                    'created_at', 'updated_at', 'year'])) {
                continue;
            }
            if (in_array($field, ['math_scale', 'ela_scale'])) {
                $type = 'box';
            } else {
                $type = 'pie';
            }
            $return[$type][$field] = Helper::formatForSparkline($result->get(), $field);
        }

        return $return;
    }
}
