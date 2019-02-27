<?php

namespace App\Imports;

use App\PSAT;
use Maatwebsite\Excel\Concerns\ToModel;

class PSATImport implements ToModel
{
    private $email;
    private $grade;
    private $year;

    /**
     * PSATImport constructor.
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
     * @return \App\PSAT|null
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
        return new PSAT([
            'teacher'   => $this->email,
            'fname'     => $fname,
            'lname'     => $lname,
            'ssid'      => $row[2],
            'course'    => $row[3],
            'readwrite' => static::parseScore($row[4]),
            'math'      => static::parseScore($row[5]),
            'total'     => static::parseScore($row[6]),
            'grade'     => $this->grade,
            'year'      => $this->year
        ]);
    }

    /**
     * Parse score string
     *
     * @param string|null $score
     *
     * @return string|null
     */
    private static function parseScore($score)
    {
        return $score === "NS" ? null : $score;
    }
}
