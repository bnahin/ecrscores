<?php
/**
 *
 * @author Blake Nahin <blake@zseartcc.org>
 */

namespace App\Helpers;


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
}