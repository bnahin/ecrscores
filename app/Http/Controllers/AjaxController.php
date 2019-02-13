<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public function getTableData(Request $request)
    {
        //Validate

        //Get data according to course, exam
        // Course = base64url(year.course)
        // Exam = type-year
    }
}
