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
    /**
     * Get compare table data.
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
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

    /**
     * Get SBAC Previous/Next year data
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Support\Collection|string
     */
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

    /**
     * Get single sparkline.
     * @param \Illuminate\Http\Request $request
     *
     * @return string
     */
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

    /**
     * Get all table sparklines.
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
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
        foreach (DB::getSchemaBuilder()->getColumnListing("{$examType}_data") as $field) {
            if (in_array($field,
                [
                    'id',
                    'teacher',
                    'fname',
                    'lname',
                    'ssid',
                    'course',
                    'grade',
                    'created_at',
                    'updated_at',
                    'year'
                ])) {
                continue;
            }
            if (in_array($field, ['math_scale', 'ela_scale', 'readwrite', 'math', 'total'])) {
                $type = 'box';
            } else {
                $type = 'pie';
            }
            $return[$type][$field] = Helper::formatForSparkline($result->get(), $field);
        }

        return $return;
    }

    /**
     * Get PSAT averages for <th>
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse|string
     */
    public function getPSATAverages(Request $request)
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
        $examYear = $exam[1];

        $data = Auth::user()->psatStudents()->where('year', $courseYear)
            ->where('grade', $examYear)->where('course', $courseName);
        if (!$data->exists()) {
            return "<em>N/A</em>";
        }

        return response()->json([
            'readwrite' => number_format(round($data->pluck('readwrite')->avg())),
            'math'      => number_format(round($data->pluck('math')->avg())),
            'total'     => number_format(round($data->pluck('total')->avg()))
        ]);
    }

    /**
     * Get SBAC averages for <th>
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse|string
     */
    public function getSBACAverages(Request $request)
    {
        $request->validate([
            'course' => 'required'
        ]);
        if (!CourseHelper::validCourseData($request->course)) {
            abort(400, "Malformed request");
        }

        $course = explode('.', Helper::base64url_decode($request->course));
        if (count($course) !== 2) {
            abort(400, "Malformed request. Course.");
        }
        $courseYear = $course[0];
        $courseName = $course[1];

        $data8 = Auth::user()->sbacStudents()
            ->where('year', $courseYear)
            ->where('course', $courseName)
            ->where('grade', 8);
        $data11 = Auth::user()->sbacStudents()
            ->where('year', $courseYear)
            ->where('course', $courseName)
            ->where('grade', 11);
        if (!$data8->exists()) {
            $data8 = null;
        }
        if (!$data11->exists()) {
            $data11 = null;
        }

        return response()->json([
            8  => ($data8) ? [
                'math_scale' => number_format(round($data8
                    ->pluck('math_scale')->avg())),
                'ela_scale'  => number_format(round($data8
                    ->pluck('ela_scale')->avg()))
            ] : [],
            11 => ($data11) ? [
                'math_scale' => number_format(round($data11
                    ->pluck('math_scale')->avg())),
                'ela_scale'  => number_format(round($data11
                    ->pluck('ela_scale')->avg())),
            ] : []
        ]);
    }
}
