<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChartsController extends Controller
{
    /**
     * Get Pie charts for levels
     *
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

    /**
     * Get Average charts
     *
     * @param string $exam
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAverages(string $exam): JsonResponse {
        switch($exam) {
            case "psat": return $this->getPsatAverages();
            case "sbac": return $this->getSBACAverages();
        }
    }

    /**
     * Get PSAT Averages Bar Chart - Stacked
     */
    private function getPsatAverages()
    {
        $years = [];
        $math = [];
        $reading = [];

        $tYears = Auth::user()->getYears();
        foreach ($tYears as $year) {
            $years[] = Helper::getFullYearString($year);

            $students = Auth::user()->psatStudents()
                ->where('year', $year);
            if (!$students->exists()) {
                continue;
            }

            $math[] = round($students->pluck('math')->avg());
            $reading[] = round($students->pluck('readwrite')->avg());
        }

        return response()->json(['math' => $math, 'reading' => $reading, 'years' => $years]);
    }

    /**
     * Get SBAC Averages Bar Chart
     */
    private function getSBACAverages()
    {
        $years = [];
        $math = [];
        $ela = [];

        $tYears = Auth::user()->getYears();
        foreach ($tYears as $year) {
            $years[] = Helper::getFullYearString($year);

            $students = Auth::user()->sbacStudents()
                ->where('year', $year);
            if (!$students->exists()) {
                continue;
            }

            $math[] = round($students->pluck('math_scale')->avg());
            $ela[] = round($students->pluck('ela_scale')->avg());
        }

        return response()->json(['math' => $math, 'ela' => $ela, 'years' => $years]);
    }
}
