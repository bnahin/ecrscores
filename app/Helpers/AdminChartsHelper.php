<?php
/**
 *
 * @author Blake Nahin <blake@zseartcc.org>
 */

namespace App\Helpers;


use App\PSAT;
use App\SBAC;
use Illuminate\Support\Facades\DB;

class AdminChartsHelper
{
    public static function getSparkline($examType, $field)
    {
        $result = DB::table($examType . "_data")->where([
            'year' => ($examType === "psat") ? PSAT::max('year')
                : SBAC::max('year')
        ]);
        if ($examType === "psat") {
            $result = $result->whereNotNull('total');
        }

        return Helper::formatForSparkline($result->get(), $field);
    }
}