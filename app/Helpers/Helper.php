<?php
/**
 *
 * @author Blake Nahin <blake@zseartcc.org>
 */

namespace App\Helpers;

use Illuminate\Support\Facades\Cache;

class Helper
{
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

    public static function base64url_encode(string $data): string
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    public static function base64url_decode(string $data): string
    {
        return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
    }

    public static function inSync(): bool {
        return Cache::has('datasync');
    }
}