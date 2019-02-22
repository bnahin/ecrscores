<?php
/**
 *
 * @author Blake Nahin <blake@zseartcc.org>
 */

namespace App\Helpers;


use App\PSAT;
use App\SBAC;
use Illuminate\Support\Facades\Auth;

final class SBACDataHelper
{
    /**
     * @param int $level
     *
     * @return string
     */
    public static function getLevelFromInt(int $level): string
    {
        switch ($level) {
            case 0:
                return "Standard Not Met";
            case 1:
                return "Near Standard";
            case 2:
                return "Standard Met";
            case 3:
                return "Standard Exceeded";
            default:
                return "<em>Use Legend</em>";
        }
    }

    /**
     * @param string $level
     *
     * @return int
     */
    public static function getIntFromLevel(string $level): int
    {
        switch ($level) {
            case "Standard Not Met":
                return 0;
            case "Near Standard":
                return 1;
            case "Standard Met":
                return 2;
            case "Standard Exceeded":
                return 3;
            default:
                return -1;
        }
    }

    /**
     * @param int $level
     *
     * @return string
     */
    public static function getColorFromInt(int $level): string
    {
        switch ($level) {
            case 0:
                return "danger";
            case 1:
                return "warning";
            case 2:
            case 3:
                return "success";
            default:
                return "info";
        }
    }

    /**
     * Get cell data, most likely for preview popover
     *
     * @param int    $grade  The testing year (8|11)
     * @param string $ssid   The student's SSID.
     * @param array  $fields Fields to display, deliminated by line break
     *
     * @return \Illuminate\Support\Collection|string
     */
    public static function getCellData(int $grade, string $ssid, array $fields)
    {
        $content = "";
        $result = Auth::user()->sbacStudents()
            ->where('grade', $grade)
            ->where('ssid', $ssid);
        if (!$result->exists()) {
            return "<em>No Data</em>";
        }

        for ($i = 0; $i < count($fields); $i++) {
            $content .= $result->pluck($fields[$i])->first();
            if ($i != count($fields) - 1) {
                $content .= "<br>";
            }
        }

        return $content;
    }

    /** Homepage */

    /**
     * @return string
     */
    public static function calculateAverageEla(): string
    {
        $data = Auth::user()->sbacStudents()
            ->where('year', PSAT::max('year'));
        if (!$data->exists()) {
            return "<em>N/A</em>";
        }

        return number_format($data->pluck('ela_scale')->avg());
    }

    /**
     * @return string
     */
    public static function calculateAverageMath(): string
    {
        $data =  Auth::user()->sbacStudents()
            ->where('year', PSAT::max('year'));
        if (!$data->exists()) {
            return "<em>N/A</em>";
        }

        return number_format($data->pluck('math_scale')->avg());
    }
}