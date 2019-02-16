<?php
/**
 *
 * @author Blake Nahin <blake@zseartcc.org>
 */

namespace App\Helpers;


use Illuminate\Support\Facades\Auth;

final class CourseHelper
{

    public static function validCourseData(string $data): bool
    {
        $pieces = explode('.', Helper::base64url_decode($data));
        $year = $pieces[0];
        $yearPieces = explode('-', $year);
        $course = $pieces[1] ?? null;

        return $course && count($yearPieces) == 2 &&
            filter_var($yearPieces[0], FILTER_VALIDATE_INT)
            && filter_var($yearPieces[1], FILTER_VALIDATE_INT);
    }

    public static function getScoresFromCourse(string $year, string $course): array
    {
        $data = array();
        if (!Auth::check()) {
            return $data;
        }

        $data['psat'] = Auth::user()->psatStudents()->where(
            ['year' => $year, 'course' => $course]);
        $data['sbac'][8] = Auth::user()->sbacStudents()->where(
            ['year' => $year, 'course' => $course, 'grade' => 8]);
        $data['sbac'][11] = Auth::user()->sbacStudents()->where(
            ['year' => $year, 'course' => $course, 'grade' => 11]);

        return $data;
    }

    /**
     * Split course string into period and class name.
     *
     * @param string $course
     *
     * @return string Full course string.
     */
    public static function splitCourse(string $course): string
    {
        $pieces = explode('-', $course);
        if (count($pieces) != 2) {
            return $course;
        }

        return "Period " . $pieces[0] . " - " . $pieces[1];
    }
}