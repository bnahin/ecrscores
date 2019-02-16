<?php
/**
 *
 * @author Blake Nahin <blake@zseartcc.org>
 */

namespace App\Helpers;


use Illuminate\Support\Facades\Auth;

final class SBACDataHelper
{
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
                return "<em>No Score</em>";
        }
    }

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
     * @param int    $year   The test year.
     * @param string $ssid   The student's SSID.
     * @param array  $fields Fields to display, deliminated by line break
     *
     * @return \Illuminate\Support\Collection|string
     */
    public static function getCellData(int $year, string $ssid, ...$fields)
    {
        $content = "";
        $result = Auth::user()->sbacStudents()
            ->where('grade', $year)
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
}