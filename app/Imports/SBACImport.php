<?php

namespace App\Imports;

use App\SBAC;
use Maatwebsite\Excel\Concerns\ToModel;

class SBACImport implements ToModel
{
    private $email;
    private $grade;
    private $year;

    /**
     * SBACImport constructor.
     *
     * @param string $email Teacher email
     * @param int    $grade Student grade level
     * @param string $year  Year of student data
     *
     */
    public function __construct(string $email, int $grade, string $year)
    {
        $this->email = $email;
        $this->grade = $grade;
        $this->year = $year;
    }

    /**
     * @param array $row The Excel sheet row.
     *
     * @return \App\SBAC|null
     * @throws \Exception
     */
    public function model(array $row)
    {
        if (!isset($row[0])) {
            //Header row
            return null;
        }
        if (str_contains($row[3], ["REG ROOM", "SERVICE", "TUTOR", "HOME"])) {
            return null;
        }

        //Split name
        $pieces = explode(',', $row[1]);
        $lname = $pieces[0];
        $fname = $pieces[1] ?? "";

        //Add to database buffer
        if ($this->grade != 8) {
            return new SBAC([
                'teacher' => $this->email,
                'fname'   => $fname,
                'lname'   => $lname,
                'ssid'    => $row[2],
                'course'  => $row[3],

                'math_scale' => static::parseLevel($row[4]),
                'math_level' => static::parseLevel($row[5]),
                'reasoning'  => static::parseLevel($row[6]),
                'concepts'   => static::parseLevel($row[7]),
                'modeling'   => static::parseLevel($row[8]),
                'ela_scale'  => static::parseLevel($row[9]),
                'ela_level'  => static::parseLevel($row[10]),
                'inquiry'    => static::parseLevel($row[11]),
                'listening'  => static::parseLevel($row[12]),
                'reading'    => static::parseLevel($row[13]),
                'writing'    => static::parseLevel($row[14]),

                'grade' => $this->grade,
                'year'  => $this->year
            ]);
        } else {
            return new SBAC([
                'teacher' => $this->email,
                'fname'   => $fname,
                'lname'   => $lname,
                'ssid'    => $row[2],
                'course'  => $row[3],

                'math_scale' => static::parseLevel($row[13]),
                'math_level' => static::parseLevel($row[15]),
                'reasoning'  => static::parseLevel($row[18]),
                'concepts'   => static::parseLevel($row[16]),
                'modeling'   => static::parseLevel($row[17]),
                'ela_scale'  => static::parseLevel($row[5]),
                'ela_level'  => static::parseLevel($row[7]),
                'inquiry'    => static::parseLevel($row[11]),
                'listening'  => static::parseLevel($row[10]),
                'reading'    => static::parseLevel($row[8]),
                'writing'    => static::parseLevel($row[9]),

                'grade' => $this->grade,
                'year'  => $this->year
            ]);
        }
    }

    /**
     * Create integer representation on level text
     *
     * @param string|null $level Level text to parse
     *
     * @return int|string
     */
    private static function parseLevel($level)
    {
        if (intval($level)) {
            //Is a number
            return $level;
        }
        switch (rtrim(preg_replace('/\./', '', $level))) {
            case 'Standard Not Met' :
                $return = 0;
                break;
            case 'Near Standard' :
                $return = 1;
                break;
            case 'Standard Met' :
                $return = 2;
                break;
            case 'Standard Exceeded' :
                $return = 3;
                break;
            default:
                //NS
                $return = null;
                break;
        }

        return $return;
    }
}