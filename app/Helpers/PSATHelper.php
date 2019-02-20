<?php
/**
 *
 * @author Blake Nahin <blake@zseartcc.org>
 */

namespace App\Helpers;


use App\PSAT;
use Illuminate\Support\Facades\Auth;

final class PSATHelper
{
    /**
     * Calculate Percentile
     *
     * @param string $ssid
     * @param int    $total
     * @param string $year
     * @param string $mode   (school|teacher|period)
     * @param string $teacher
     * @param string $course If period mode is specified
     *
     * @return float|string
     */
    public static function calcTotalPercentile(
        string $ssid,
        int $total,
        string $year,
        string $mode = 'school',
        string $teacher = "",
        string $course = ""
    ) {
        $others = null;
        switch ($mode) {
            case 'school':
                $others = PSAT::where('ssid', '<>', $ssid)
                    ->where('year', $year)->get();
                break;
            case 'teacher':
                $others = PSAT::where('ssid', '<>', $ssid)
                    ->where('year', $year)
                    ->where('teacher', $teacher)->get();
                break;
            case 'period':
                $others = PSAT::where('ssid', '<>', $ssid)
                    ->where('year', $year)
                    ->where('teacher', $teacher)
                    ->where('course', $course)->get();
                break;
        }

        return ($others && count($others)) ?
            self::calcPercentile($total, $others->pluck('total')) : "N/A";
    }

    /**
     * Calculate actual percentile.
     *
     * @param $total
     * @param $others
     *
     * @return float
     */
    private static function calcPercentile($total, $others)
    {
        $numAbove = 0;
        foreach ($others as $otherScore) {
            if ($otherScore > $total) {
                $numAbove++;
            }
        }
        $percentAbove = $numAbove / count($others) * 100;
        $percentile = round(100 - $percentAbove);

        return $percentile;
    }

    /**
     * Get pre-calculated percentile.
     *
     * @param \App\PSAT $psat
     * @param string    $type
     *
     * @return string
     */
    public static function getPercentile(PSAT $psat, string $type): string
    {
        $model = $psat->percentiles()->where('type', $type);
        if (!$model->exists()) {
            return "<em>N/A</em>";
        }
        $percent = $model->get('percent');
        if (!$percent || $percent === null) {
            return "<em>N/A</em>";
        }

        return $percent;

    }

    /**
     * Calculate average total score.
     * @return string
     */
    public static function calculateAverageTotal(): string
    {
        $data = Auth::user()->psatStudents()
            ->where('year', PSAT::max('year'));
        if (!$data->exists()) {
            return "<em>N/A</em>";
        }

        return number_format($data->pluck('total')->avg());
    }
}