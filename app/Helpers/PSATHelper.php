<?php
/**
 *
 * @author Blake Nahin <blake@zseartcc.org>
 */

namespace App\Helpers;


use App\PSAT;
use Illuminate\Support\Facades\Auth;

class PSATHelper
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
        string $mode = 'period',
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

        return ($others) ?
            self::getPercentile($total, $others->pluck('total')) : "N/A";
    }

    /**
     * Get actual percentile.
     *
     * @param $total
     * @param $others
     *
     * @return float
     */
    private static function getPercentile($total, $others)
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
}