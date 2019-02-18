<?php
/**
 *
 * @author Blake Nahin <blake@zseartcc.org>
 */

namespace App\Helpers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class Helper
{
    /**
     * Get full year.
     * ex. 2018-19
     * @param string $shortYear
     *
     * @return string
     */
    public static function getFullYearString(string $shortYear): string
    {
        $year = explode('-', $shortYear)[0];

        $prefix = substr(date('Y'), 0, 2);

        if (intval(substr(date('Y'), 2, 4)) < $year) //Previous century
        {
            $prefix = intval($prefix) - 1;
        }

        //Append prefix only to start of string
        // ex. 2019-20
        return $prefix . $shortYear;
    }

    /**
     * @param string $data
     *
     * @return string
     */
    public static function base64url_encode(string $data): string
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    /**
     * @param string $data
     *
     * @return string
     */
    public static function base64url_decode(string $data): string
    {
        return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
    }

    /**
     * Check if syncing
     * @return bool
     */
    public static function inSync(): bool
    {
        return Cache::has('datasync');
    }

    /**
     * Format Collection for Sparkline value string.
     * @param \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection $collection
     * @param string                                                                  $field
     *
     * @return string
     */
    public static function formatForSparkline($collection, string $field)
    {
        $string = $collection->pluck($field)->map(function ($value) {
            $int = $value;
            if (!filter_var($int, FILTER_VALIDATE_INT) && $int) {
                $int = SBACDataHelper::getIntFromLevel($int);
            }

            return $int;
        })->reject(function ($value) {
            return is_null($value);
        })->implode(',');

        if (!str_contains($field, 'scale') &&
            !in_array($field, ['readwrite', 'math', 'total'])) {
            $arr = [-1 => 0, 0 => 0, 1 => 0, 2 => 0, 3 => 0];
            foreach (explode(",", $string) as $num) {
                if (!isset($arr[$num])) {
                    continue;
                }
                $arr[$num]++;
            }
            $string = implode($arr, ",");
        }

        return $string;
    }

}