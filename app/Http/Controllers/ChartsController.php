<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChartsController extends Controller
{
    /**
     * Get Pie charts for levels
     * @param string $level Level string (ela|math)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getLevels(string $level)
    {
        $levels = DB::table('sbac_data')
            ->select($level . '_level', DB::raw('COUNT(*) as total'))
            ->where('teacher', Auth::user()->email)
            ->groupBy($level . '_level')
            ->orderBy($level . '_level', 'ASC')
            ->get()->filter(function ($value) use ($level) {
                $levelProp = "{$level}_level";

                return !is_null($value->{$levelProp});
            });

        return response()->json($levels);
    }

    //Bar charts...

    /**
     * Get PSAT Averages Bar Chart - Stacked
     */
    public function getPsatAverages() {

    }

    /**
     * Get SBAC Averages Bar Chart
     */
    public function getSBACAverages() {

    }
}
