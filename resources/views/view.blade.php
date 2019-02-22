@extends('layout')
@section('page-title', 'View Scores')
@section('page-description', \App\Helpers\CourseHelper::splitCourse($course) . " ($year)")

@section('year')
    <li>{{ $year }}</li>
@endsection
@section('course')
    <li class='active'> {{ $course }} </li>
@endsection

@push('scripts')
    <script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('bower_components/jquery-sparkline/dist/jquery.sparkline.min.js') }}"></script>
@endpush

@push('styles')
    <link href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}" rel="stylesheet"/>
@endpush

@php
    $sbac8 = $data['sbac'][8]->get();
    $sbac11 = $data['sbac'][11]->get();
    $psat11 = $data['psat']->where('grade', 11)->get()
@endphp

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#sbac8" data-toggle="tab" aria-expanded="true">
                            SBAC 8
                            <div class="tab-loading sbac8-load">
                                <i class="fa fa-spinner fa-spin"></i>
                            </div>
                        </a>
                    </li>
                    <li class=""><a href="#sbac11" data-toggle="tab" aria-expanded="false">
                            SBAC 11
                            <br>
                            <div class="tab-loading sbac11-load">
                                <i class="fa fa-spinner fa-spin"></i>
                            </div>
                        </a>
                    </li>
                    <li class=""><a href="#psat11" data-toggle="tab" aria-expanded="false">
                            PSAT 11
                            <br>
                            <div class="tab-loading psat11-load">
                                <i class="fa fa-spinner fa-spin"></i>
                            </div>
                        </a>
                    </li>
                    <li class=""><a href="#compare" data-toggle="tab" aria-expanded="false">Compare</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="sbac8">
                        <div class="box box-success">
                            <div class="box-header with-border">
                                <div class="legend-box-container pull-right">
                                    <div class="box legend-box">
                                        <a data-toggle="collapse"
                                           href="#cl1" aria-expanded="false"
                                           aria-controls="collapseExample" class="accordion-toggle collapsed">
                                            <div class="box-header">
                                                <h4 class="text-center">Category Level Legend</h4>
                                            </div>
                                        </a>
                                        <div class="box-body collapse" id="cl1" style="padding-top:0;">
                                            <h5 class="text-center">English and Language Arts Standards</h5>
                                            <div class="row text-center">
                                                <div class="col-xs-3">
                                                    <p class="text-danger">Not Met <br><strong>2288</strong> - 2486</p>
                                                </div>
                                                <div class="col-xs-3">
                                                    <p class="text-yellow">Nearly Met <br> 2487 - 2566</p>
                                                </div>
                                                <div class="col-xs-3">
                                                    <p class="text-green">Standard Met <br>2567 - 2667</p>
                                                </div>
                                                <div class="col-xs-3">
                                                    <p class="text-success">Exceeded
                                                        <br>2668 - <strong>2769</strong></p>
                                                </div>
                                            </div>
                                            <h5 class="text-center">Mathematics Standards</h5>
                                            <div class="row text-center">
                                                <div class="col-xs-3">
                                                    <p class="text-danger">Not Met <br><strong>2265</strong> - 2503</p>
                                                </div>
                                                <div class="col-xs-3">
                                                    <p class="text-yellow">Nearly Met <br> 2504 - 2585</p>
                                                </div>
                                                <div class="col-xs-3">
                                                    <p class="text-green">Standard Met <br>2586 - 2652</p>
                                                </div>
                                                <div class="col-xs-3">
                                                    <p class="text-success">Exceeded
                                                        <br>2653 - <strong>2802</strong></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <h3 class="box-title">SBAC Grade 8 <br></h3>
                                <p class="help-block">Click on table cell to view data for Grade 11.</p>
                                <p class="help-block">Hover over charts for detailed information.</p>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <table id="sbac8-table" class="table table-bordered table-striped static-table">
                                    <thead>
                                    <tr>
                                        <th>Last Name</th>
                                        <th>First Name</th>
                                        <th>Math Scale
                                            <span class="sparklines-box"
                                                  values="{{\App\Helpers\Helper::formatForSparkline($sbac8,'math_scale')}}"></span>
                                            <br><span class="th-normal">Average: </span><span
                                                id="sbac-avg-math_scale-8"></span>
                                        </th>
                                        <th>ELA Scale
                                            <span class="sparklines-box"
                                                  values="{{\App\Helpers\Helper::formatForSparkline($sbac8,'ela_scale')}}"></span>
                                            <br><span class="th-normal">Average: </span><span
                                                id="sbac-avg-ela_scale-8"></span>
                                        </th>
                                        <th>Reading
                                            <span class="sparklines-pie"
                                                  values="{{\App\Helpers\Helper::formatForSparkline($sbac8,'reading')}}"></span>
                                        </th>
                                        <th>Writing
                                            <span class="sparklines-pie"
                                                  values="{{\App\Helpers\Helper::formatForSparkline($sbac8,'writing')}}"></span>
                                        </th>
                                        <th>Listening
                                            <span class="sparklines-pie"
                                                  values="{{\App\Helpers\Helper::formatForSparkline($sbac8,'listening')}}"></span>
                                        </th>
                                        <th>Communicating and Reasoning
                                            <span class="sparklines-pie"
                                                  values="{{\App\Helpers\Helper::formatForSparkline($sbac8,'ela_level')}}"></span>
                                        </th>
                                        <th>Concepts and Procedures
                                            <span class="sparklines-pie"
                                                  values="{{\App\Helpers\Helper::formatForSparkline($sbac8,'concepts')}}"></span>
                                        </th>
                                        <th>Problem Solving and Modeling
                                            <span class="sparklines-pie"
                                                  values="{{\App\Helpers\Helper::formatForSparkline($sbac8,'modeling')}}"></span>
                                        </th>
                                        <th>Inquiry
                                            <span class="sparklines-pie"
                                                  values="{{\App\Helpers\Helper::formatForSparkline($sbac8,'inquiry')}}"></span>
                                        </th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($sbac8 as $score)
                                        <tr>
                                            <td>{{ $score->last_name }}</td>
                                            <td>{{ $score->first_name }}</td>
                                            <td data-grade="11"
                                                data-ssid="{{ $score->ssid }}"
                                                data-fields="math_scale,math_level">{!! $score->math_scale ?? "<em>No Score</em>" !!}
                                                <hr style="margin:5px 0">
                                                {!! $score->math_level !!}
                                            </td>
                                            <td data-grade="11"
                                                data-ssid="{{ $score->ssid }}"
                                                data-fields="ela_scale,ela_level">{!! $score->ela_scale ?? "<em>No Score</em>" !!}
                                                <hr style="margin:5px 0">
                                                {!! $score->ela_level !!}
                                            </td>
                                            <td class="{{ \App\Helpers\SBACDataHelper::getColorFromInt($score->getOriginal('reading') ?? -1) }}"
                                                data-grade="11"
                                                data-ssid="{{ $score->ssid }}"
                                                data-fields="reading">{!! $score->reading !!}
                                            </td>
                                            <td class="{{ \App\Helpers\SBACDataHelper::getColorFromInt($score->getOriginal('writing') ?? -1) }}"
                                                data-grade="11"
                                                data-ssid="{{ $score->ssid }}"
                                                data-fields="writing">{!! $score->writing !!}
                                            </td>
                                            <td class="{{ \App\Helpers\SBACDataHelper::getColorFromInt($score->getOriginal('listening') ?? -1) }}"
                                                data-grade="11"
                                                data-ssid="{{ $score->ssid }}"
                                                data-fields="listening"> {!! $score->listening !!}
                                            </td>
                                            <td class="{{ \App\Helpers\SBACDataHelper::getColorFromInt($score->getOriginal('reasoning') ?? -1) }}"
                                                data-grade="11"
                                                data-ssid="{{ $score->ssid }}"
                                                data-fields="reasoning">{!! $score->reasoning !!}
                                            </td>
                                            <td class="{{ \App\Helpers\SBACDataHelper::getColorFromInt($score->getOriginal('concepts') ?? -1) }}"
                                                data-grade="11"
                                                data-ssid="{{ $score->ssid }}"
                                                data-fields="concepts">{!! $score->concepts !!}
                                            </td>
                                            <td class="{{ \App\Helpers\SBACDataHelper::getColorFromInt($score->getOriginal('modeling') ?? -1) }}"
                                                data-grade="11"
                                                data-ssid="{{ $score->ssid }}"
                                                data-fields="modeling">{!! $score->modeling !!}
                                            </td>
                                            <td class="{{ \App\Helpers\SBACDataHelper::getColorFromInt($score->getOriginal('inquiry') ?? -1) }}"
                                                data-grade="11"
                                                data-ssid="{{ $score->ssid }}"
                                                data-fields="inquiry">{!! $score->inquiry !!}
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.box-body -->
                            <div class="overlay sbac8-load">
                                <i class="fa fa-spinner fa-spin"></i>
                            </div>
                        </div>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="sbac11">
                        <div class="box box-success">
                            <div class="box-header with-border">
                                <div class="legend-box-container pull-right">
                                    <div class="box legend-box">
                                        <a data-toggle="collapse"
                                           href="#cl2" aria-expanded="false"
                                           aria-controls="collapseExample" class="accordion-toggle collapsed">
                                            <div class="box-header">
                                                <h4 class="text-center">Category Level Legend</h4>
                                            </div>
                                        </a>
                                        <div class="box-body collapse" id="cl2" style="padding-top:0;">
                                            <h5 class="text-center">English and Language Arts Standards</h5>
                                            <div class="row text-center">
                                                <div class="col-xs-3">
                                                    <p class="text-danger">Not Met <br><strong>2299</strong> - 2492</p>
                                                </div>
                                                <div class="col-xs-3">
                                                    <p class="text-yellow">Nearly Met <br> 2493 - 2582</p>
                                                </div>
                                                <div class="col-xs-3">
                                                    <p class="text-green">Standard Met <br>2583 - 2681</p>
                                                </div>
                                                <div class="col-xs-3">
                                                    <p class="text-success">Exceeded
                                                        <br>2682 - <strong>2795</strong></p>
                                                </div>
                                            </div>
                                            <h5 class="text-center">Mathematics Standards</h5>
                                            <div class="row text-center">
                                                <div class="col-xs-3">
                                                    <p class="text-danger">Not Met <br><strong>2280</strong> - 2542</p>
                                                </div>
                                                <div class="col-xs-3">
                                                    <p class="text-yellow">Nearly Met <br> 2543 - 2627</p>
                                                </div>
                                                <div class="col-xs-3">
                                                    <p class="text-green">Standard Met <br>2628 - 2717</p>
                                                </div>
                                                <div class="col-xs-3">
                                                    <p class="text-success">Exceeded
                                                        <br>2718 - <strong>2862</strong></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <h3 class="box-title">SBAC Grade 11</h3>
                                <p class="help-block">Click on table cell to view data for Grade 8.</p>
                                <p class="help-block">Hover over charts for detailed information.</p>
                            </div>
                            <div class="box-body">
                                <table id="sbac11-table" class="table table-bordered table-striped static-table">
                                    <thead>
                                    <tr>
                                        <th>Last Name</th>
                                        <th>First Name</th>
                                        <th>Math Scale
                                            <span class="sparklines-box"
                                                  values="{{\App\Helpers\Helper::formatForSparkline($sbac11,'math_scale')}}"></span>
                                            <br><span class="th-normal">Average: </span><span
                                                id="sbac-avg-math_scale-11"></span>
                                        </th>
                                        <th>ELA Scale
                                            <span class="sparklines-box"
                                                  values="{{\App\Helpers\Helper::formatForSparkline($sbac11,'ela_scale')}}"></span>
                                            <br><span class="th-normal">Average: </span><span
                                                id="sbac-avg-ela_scale-11"></span>
                                        </th>
                                        <th>Reading
                                            <span class="sparklines-pie"
                                                  values="{{\App\Helpers\Helper::formatForSparkline($sbac11,'reading')}}"></span>
                                        </th>
                                        <th>Writing
                                            <span class="sparklines-pie"
                                                  values="{{\App\Helpers\Helper::formatForSparkline($sbac11,'writing')}}"></span>
                                        </th>
                                        <th>Listening
                                            <span class="sparklines-pie"
                                                  values="{{\App\Helpers\Helper::formatForSparkline($sbac11,'listening')}}"></span>
                                        </th>
                                        <th>Communicating and Reasoning
                                            <span class="sparklines-pie"
                                                  values="{{\App\Helpers\Helper::formatForSparkline($sbac11,'ela_level')}}"></span>
                                        </th>
                                        <th>Concepts and Procedures
                                            <span class="sparklines-pie"
                                                  values="{{\App\Helpers\Helper::formatForSparkline($sbac11,'concepts')}}"></span>
                                        </th>
                                        <th>Problem Solving and Modeling
                                            <span class="sparklines-pie"
                                                  values="{{\App\Helpers\Helper::formatForSparkline($sbac11,'modeling')}}"></span>
                                        </th>
                                        <th>Inquiry
                                            <span class="sparklines-pie"
                                                  values="{{\App\Helpers\Helper::formatForSparkline($sbac11,'inquiry')}}"></span>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($sbac11 as $score)
                                        <tr>
                                            <td>{{ $score->last_name }}</td>
                                            <td>{{ $score->first_name }}</td>
                                            <td class="{{ \App\Helpers\SBACDataHelper::getColorFromInt($score->getOriginal('ela_level') ?? -1) }}"
                                                data-grade="8"
                                                data-ssid="{{ $score->ssid }}"
                                                data-fields="ela_scale,ela_level"> {!! $score->ela_scale ?? "<em>No Score</em>" !!}
                                                <hr style="margin:5px 0">
                                                {!! $score->ela_level !!}</td>
                                            <td class="{{ \App\Helpers\SBACDataHelper::getColorFromInt($score->getOriginal('math_level') ?? -1) }}"
                                                data-grade="8"
                                                data-ssid="{{ $score->ssid }}"
                                                data-fields="math_scale,math_level">{!! $score->math_scale ?? "<em>No Score</em>" !!}
                                                <hr style="margin:5px 0">
                                                {!! $score->math_level !!}</td>
                                            <td class="{{ \App\Helpers\SBACDataHelper::getColorFromInt($score->getOriginal('reading') ?? -1) }}"
                                                data-grade="8"
                                                data-ssid="{{ $score->ssid }}"
                                                data-fields="reading">{!! $score->reading !!}</td>
                                            <td class="{{ \App\Helpers\SBACDataHelper::getColorFromInt($score->getOriginal('writing') ?? -1) }}"
                                                data-grade="8"
                                                data-ssid="{{ $score->ssid }}"
                                                data-fields="writing">{!! $score->writing !!}</td>
                                            <td class="{{ \App\Helpers\SBACDataHelper::getColorFromInt($score->getOriginal('listening') ?? -1) }}"
                                                data-grade="8"
                                                data-ssid="{{ $score->ssid }}"
                                                data-fields="listening">
                                                {!! $score->listening !!}</td>
                                            <td class="{{ \App\Helpers\SBACDataHelper::getColorFromInt($score->getOriginal('reasoning') ?? -1) }}"
                                                data-toggle="popover" data-title="Result in SBAC 8"
                                                data-grade="8"
                                                data-ssid="{{ $score->ssid }}"
                                                data-fields="reasoning">{!! $score->reasoning !!}</td>
                                            <td class="{{ \App\Helpers\SBACDataHelper::getColorFromInt($score->getOriginal('concepts') ?? -1) }}"
                                                data-grade="8"
                                                data-ssid="{{ $score->ssid }}"
                                                data-fields="concepts">{!! $score->concepts !!}</td>
                                            <td class="{{ \App\Helpers\SBACDataHelper::getColorFromInt($score->getOriginal('modeling') ?? -1) }}"
                                                data-grade="8"
                                                data-ssid="{{ $score->ssid }}"
                                                data-fields="modeling"> {!! $score->modeling !!}</td>
                                            <td class="{{ \App\Helpers\SBACDataHelper::getColorFromInt($score->getOriginal('inquiry') ?? -1) }}"
                                                data-grade="8"
                                                data-ssid="{{ $score->ssid }}"
                                                data-fields="inquiry">
                                                {!! $score->inquiry !!}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="overlay sbac11-load">
                                <i class="fa fa-spinner fa-spin"></i>
                            </div>
                        </div>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="psat11">
                        <div class="box box-success">
                            <div class="box-header with-border">
                                <h3 class="box-title">PSAT Grade 11</h3>
                                <p class="help-block">Click on box-and-whsisker plot for detailed information.</p>
                            </div>
                            <div class="box-body">
                                <table id="psat11-table" class="table table-bordered table-striped static-table">
                                    <input type="hidden" id="psat11-course" value="{{ $courseSerialized }}">
                                    <input type="hidden" id="past11-exam" value="psat-11">
                                    <thead>
                                    <tr>
                                        <th width="15%">Last Name</th>
                                        <th width="15%">First Name</th>
                                        <th width="10%">Reading/Writing
                                            <span class="sparklines-box"
                                                  values="{{\App\Helpers\Helper::formatForSparkline($psat11,'readwrite')}}"></span>
                                            <br><span class="th-normal">Average:</span> <span
                                                id="th-avg-readwrite"></span>
                                        </th>
                                        <th width="10%">Mathematics
                                            <span class="sparklines-box"
                                                  values="{{\App\Helpers\Helper::formatForSparkline($psat11,'math')}}"></span>
                                            <br><span class="th-normal">Average:</span> <span id="th-avg-math"></span>
                                        </th>
                                        <th class="success" width="15%">Total<br>
                                            <span class="sparklines-box"
                                                  values="{{\App\Helpers\Helper::formatForSparkline($psat11,'total')}}"></span>
                                            <br><span class="th-normal">Average:</span> <span id="th-avg-total"></span>
                                        </th>
                                        <th>Percentiles</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($psat11 as $score)
                                        <tr>
                                            <td width="15%">{{ $score->first_name }}</td>
                                            <td width="15%">{{ $score->last_name }}</td>
                                            <td width="10%">{!! $score->readwrite ?? "<em>No Score</em>" !!}</td>
                                            <td width="10%">{!! $score->math ?? "<em>No Score</em>" !!}</td>
                                            <td class="success"
                                                width="15%">{!! $score->total ?? "<em>No Score</em>" !!}</td>
                                            <td>
                                                <div class="row">
                                                    <div class="col-xs-4"><strong rel="tooltip"
                                                                                  title='Among your students in Period {{\App\Helpers\CourseHelper
                                                                                                                ::getPeriodFromCourse($course)}}.'>
                                                            Period</strong><br>
                                                        {!! \App\Helpers\PSATHelper::getPercentile($score, 'period'). "%" !!}
                                                    </div>
                                                    <div class="col-xs-4">
                                                        <strong rel="tooltip"
                                                                title="Among your students across all periods.">Students</strong><br>
                                                        {!! \App\Helpers\PSATHelper::getPercentile($score, 'teacher'). "%" !!}
                                                    </div>
                                                    <div class="col-xs-4">
                                                        <strong rel="tooltip"
                                                                title="Among students in all classes.">School</strong><br>
                                                        {!! \App\Helpers\PSATHelper::getPercentile($score, 'school'). "%" !!}
                                                    </div>
                                                </div>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="overlay psat11-load">
                                <i class="fa fa-spinner fa-spin"></i>
                            </div>
                        </div>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="compare">
                        <!--
                        SBAC 8 vs SBAC 11
                        Filters on both sides
                        If numeric, <br> Difference: +-...
                        -->
                        <div class="box box-info">
                            <div class="box-header with-border">
                                <h3 class="box-title">Compare Scores</h3>
                            </div>
                            <div class="box-body">
                                <div class="row" id="compare-container">
                                    <div class="col-lg-6" id="col-1">
                                        <div class="row compare-row sticker" id="compare-row-1">
                                            <div class="col-xs-6">
                                                <label class="control-label" for="courseselect-1">
                                                    Course:
                                                </label>
                                                <br>
                                                <select class="form-control select2-course compare-select"
                                                        id="courseselect-1"
                                                        style="width:100%;">
                                                    <option value="" data-label="-- Select Course --" data-col="1"
                                                            selected>-- Select
                                                        Course --
                                                    </option>
                                                    @foreach(Auth::user()->getYears() as $year)
                                                        <optgroup
                                                            label=" {{ \App\Helpers\Helper::getFullYearString($year) }}">
                                                            @foreach(Auth::user()->getCourses($year) as $course)
                                                                <option
                                                                    value="{{ \App\Helpers\Helper::base64url_encode("$year.$course") }}"
                                                                    data-label="[{{\App\Helpers\Helper::getFullYearString($year)}}] {{$course}}"
                                                                    data-col="1">
                                                                    {{ $course }}
                                                                </option>
                                                            @endforeach
                                                        </optgroup>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-xs-6">
                                                <label class="control-label" for="examselect-1">
                                                    Exam:
                                                </label>
                                                <br>
                                                <select class="form-control select2-exam compare-select"
                                                        id="examselect-1"
                                                        style="width:100%;">
                                                    <option value="" data-label="-- Select Exam --" data-col="1"
                                                            selected>-- Select
                                                        Exam --
                                                    </option>
                                                    <option value="sbac-8"
                                                            data-col="1">SBAC 8th Grade
                                                    </option>
                                                    <option value="sbac-11"
                                                            data-col="1">SBAC 11th Grade
                                                    </option>
                                                    <option value="psat-11"
                                                            data-col="1">PSAT 11th Grade
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <!--SBAC Filter Box -->
                                        <div id="filter-box-1" data-controls="sbac-compare-1"
                                             class="filter-box-container" style="display: none;">
                                            <div class="box filter-box">
                                                <div class="box-body">
                                                    <h4>Filter Columns / Statistics</h4>
                                                    <div class="row filter-row">
                                                        <div class="col-xs-4">
                                                            <div class="form-check">
                                                                @php $id = abs(crc32( uniqid())) @endphp
                                                                <input class="form-check-input" type="checkbox"
                                                                       value="math_scale"
                                                                       id="mathscale-{{$id}}" checked>
                                                                <label class="form-check-label" for="mathscale-{{$id}}">
                                                                    Math Scale <span id="sl-math_scale-1"></span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                @php $id = abs(crc32(uniqid())) @endphp
                                                                <input class="form-check-input" type="checkbox"
                                                                       value="math_level"
                                                                       id="mathlevel-{{$id}}" checked>
                                                                <label class="form-check-label" for="mathlevel-{{$id}}">
                                                                    Math Level <span id="sl-math_level-1"></span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                @php $id = abs(crc32(uniqid())) @endphp
                                                                <input class="form-check-input" type="checkbox"
                                                                       value="ela_scale"
                                                                       id="elascale-{{$id}}" checked>
                                                                <label class="form-check-label" for="elascale-{{$id}}">
                                                                    ELA Scale <span id="sl-ela_scale-1"></span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                @php $id = abs(crc32(uniqid())) @endphp
                                                                <input class="form-check-input" type="checkbox"
                                                                       value="ela_level"
                                                                       id="elalevel-{{$id}}" checked>
                                                                <label class="form-check-label" for="elalevel-{{$id}}">
                                                                    ELA Level <span id="sl-ela_level-1"></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-4">
                                                            <div class="form-check">
                                                                @php $id = abs(crc32(uniqid())) @endphp
                                                                <input class="form-check-input" type="checkbox"
                                                                       value="modeling"
                                                                       id="modeling-{{$id}}">
                                                                <label class="form-check-label" for="modeling-{{$id}}">
                                                                    <span rel="tooltip"
                                                                          title="Problem Solving and Modeling">Problem Solving</span>
                                                                    <span id="sl-modeling-1"></span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                @php $id = abs(crc32(uniqid())) @endphp
                                                                <input class="form-check-input" type="checkbox"
                                                                       value="reasoning"
                                                                       id="reasoning-{{$id}}">
                                                                <label class="form-check-label" for="reasoning-{{$id}}">
                                                                    <span rel="tooltip"
                                                                          title="Communicating and Reasoning">Reasoning</span>
                                                                    <span id="sl-reasoning-1"></span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                       value="concepts"
                                                                       id="concepts-{{$id}}">
                                                                <label class="form-check-label" for="concepts-{{$id}}">
                                                                <span rel="tooltip"
                                                                      title="Concepts/Procedures">Concepts</span>
                                                                    <span id="sl-concepts-1"></span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                @php $id = abs(crc32(uniqid())) @endphp
                                                                <input class="form-check-input" type="checkbox"
                                                                       value="inquiry"
                                                                       id="inquiry-{{$id}}">
                                                                <label class="form-check-label" for="inquiry-{{$id}}">
                                                                    Inquiry <span id="sl-inquiry-1"></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-4">
                                                            @php $id = abs(crc32(uniqid())) @endphp
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                       value="listening"
                                                                       id="listening-{{$id}}">
                                                                <label class="form-check-label" for="listening-{{$id}}">
                                                                    Listening <span id="sl-listening-1"></span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                @php $id = abs(crc32(uniqid())) @endphp
                                                                <input class="form-check-input" type="checkbox"
                                                                       value="reading"
                                                                       id="reading-{{$id}}">
                                                                <label class="form-check-label" for="reading-{{$id}}">
                                                                    Reading <span id="sl-reading-1"></span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                @php $id = abs(crc32(uniqid())) @endphp
                                                                <input class="form-check-input" type="checkbox"
                                                                       value="writing"
                                                                       id="writing-{{$id}}">
                                                                <label class="form-check-label" for="writing-{{$id}}">
                                                                    Writing <span id="sl-writing-1"></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- PSAT Data Box -->
                                        <div id="column-box-1" class="filter-box-container" style="display:none">
                                            <div class="box filter-box">
                                                <div class="box-body">
                                                    <h4>Column Statistics</h4>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <p>
                                                                <strong>Reading and Writing</strong>
                                                                <br>
                                                                <span id="sl-readwrite-1"></span>
                                                                <br>
                                                                Average: <span id="avg-readwrite-1"></span>
                                                            </p>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <p>
                                                                <strong>Mathematics</strong>
                                                                <br>
                                                                <span id="sl-math-1"></span><br>
                                                                Average: <span id="avg-math-1"></span>
                                                            </p>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <p>
                                                                <strong>Total Score</strong>
                                                                <br>
                                                                <span id="sl-total-1"></span><br>
                                                                Average: <span id="avg-total-1"></span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="table-responsive">
                                            <table id="sbac-compare-1"
                                                   class="table table-bordered table-striped compare-table">
                                                <thead>
                                                <tr>
                                                    <th>Last Name</th>
                                                    <th>First Name</th>
                                                    <th>Math Scale</th>
                                                    <th>Math Level</th>
                                                    <th>ELA Scale</th>
                                                    <th>ELA Level</th>
                                                    <th>Problem Solving and Modeling</th>
                                                    <th>Communicating and Reasoning</th>
                                                    <th>Concepts and Procedures</th>
                                                    <th>Inquiry</th>
                                                    <th>Listening</th>
                                                    <th>Reading</th>
                                                    <th>Writing</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="table-responsive">
                                            <table id="psat-compare-1"
                                                   class="table table-bordered table-striped compare-table">
                                                <thead>
                                                <tr>
                                                    <th width="15%">Last Name</th>
                                                    <th width="15%">First Name</th>
                                                    <th width="10%">Reading/Writing</th>
                                                    <th width="10%">Mathematics</th>
                                                    <th class="success" width="15%">Total</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-lg-6" id="col-2">
                                        <div class="row compare-row sticker" id="compare-row-2">
                                            <div class="col-xs-6">
                                                <label class="control-label" for="courseselect-2">
                                                    Course:
                                                </label>
                                                <br>
                                                <select class="form-control select2-course compare-select"
                                                        id="courseselect-2"
                                                        style="width:100%;">
                                                    <option value="" data-label="-- Select Course --"
                                                            data-col="2"
                                                            selected>-- Select
                                                        Course --
                                                    </option>
                                                    @foreach(Auth::user()->getYears() as $year)
                                                        <optgroup
                                                            label=" {{ \App\Helpers\Helper::getFullYearString($year) }}">
                                                            @foreach(Auth::user()->getCourses($year) as $course)
                                                                <option
                                                                    value="{{ \App\Helpers\Helper::base64url_encode("$year.$course") }}"
                                                                    data-label="[{{\App\Helpers\Helper::getFullYearString($year)}}] {{$course}}"
                                                                    data-col="2">
                                                                    {{ $course }}
                                                                </option>
                                                            @endforeach
                                                        </optgroup>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-xs-6">
                                                <label class="control-label" for="examselect-2">
                                                    Exam:
                                                </label>
                                                <br>
                                                <select class="form-control select2-exam compare-select"
                                                        id="examselect-2"
                                                        style="width:100%;">
                                                    <option value="" data-label="-- Select Exam --" data-col="2"
                                                            selected>-- Select
                                                        Exam --
                                                    </option>
                                                    <option value="sbac-8"
                                                            data-col="2">SBAC 8th Grade
                                                    </option>
                                                    <option value="sbac-11"
                                                            data-col="2">SBAC 11th Grade
                                                    </option>
                                                    <option value="psat-11"
                                                            data-col="2">PSAT 11th Grade
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <!-- SBAC Filter Box -->
                                        <div id="filter-box-2" data-controls="sbac-compare-2"
                                             class="filter-box-container" style="display: none;">
                                            <div class="box filter-box">
                                                <div class="box-body">
                                                    <h4>Filter Columns / Statistics</h4>
                                                    <div class="row filter-row">
                                                        <div class="col-xs-4">
                                                            <div class="form-check">
                                                                @php $id = abs(crc32( uniqid())) @endphp
                                                                <input class="form-check-input" type="checkbox"
                                                                       value="math_scale"
                                                                       id="mathscale-{{$id}}" checked>
                                                                <label class="form-check-label"
                                                                       for="mathscale-{{$id}}">
                                                                    Math Scale <span
                                                                        id="sl-math_scale-2"></span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                @php $id = abs(crc32(uniqid())) @endphp
                                                                <input class="form-check-input" type="checkbox"
                                                                       value="math_level"
                                                                       id="mathlevel-{{$id}}" checked>
                                                                <label class="form-check-label"
                                                                       for="mathlevel-{{$id}}">
                                                                    Math Level <span
                                                                        id="sl-math_level-2"></span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                @php $id = abs(crc32(uniqid())) @endphp
                                                                <input class="form-check-input" type="checkbox"
                                                                       value="ela_scale"
                                                                       id="elascale-{{$id}}" checked>
                                                                <label class="form-check-label"
                                                                       for="elascale-{{$id}}">
                                                                    ELA Scale <span id="sl-ela_scale-2"></span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                @php $id = abs(crc32(uniqid())) @endphp
                                                                <input class="form-check-input" type="checkbox"
                                                                       value="ela_level"
                                                                       id="elalevel-{{$id}}" checked>
                                                                <label class="form-check-label"
                                                                       for="elalevel-{{$id}}">
                                                                    ELA Level <span id="sl-ela_level-2"></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-4">
                                                            <div class="form-check">
                                                                @php $id = abs(crc32(uniqid())) @endphp
                                                                <input class="form-check-input" type="checkbox"
                                                                       value="modeling"
                                                                       id="modeling-{{$id}}">
                                                                <label class="form-check-label"
                                                                       for="modeling-{{$id}}">
                                                                    <span rel="tooltip"
                                                                          title="Problem Solving and Modeling"> Problem Solving</span>
                                                                    <span id="sl-modeling-2"></span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                @php $id = abs(crc32(uniqid())) @endphp
                                                                <input class="form-check-input" type="checkbox"
                                                                       value="reasoning"
                                                                       id="reasoning-{{$id}}">
                                                                <label class="form-check-label"
                                                                       for="reasoning-{{$id}}">
                                                                    <span rel="tooltip"
                                                                          title="Communicating and Reasoning">Reasoning</span>
                                                                    <span id="sl-reasoning-2"></span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                       value="concepts"
                                                                       id="concepts-{{$id}}">
                                                                <label class="form-check-label"
                                                                       for="concepts-{{$id}}">
                                                                            <span rel="tooltip"
                                                                                  title="Concepts/Procedures">Concepts</span>
                                                                    <span id="sl-concepts-2"></span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                @php $id = abs(crc32(uniqid())) @endphp
                                                                <input class="form-check-input" type="checkbox"
                                                                       value="inquiry"
                                                                       id="inquiry-{{$id}}">
                                                                <label class="form-check-label"
                                                                       for="inquiry-{{$id}}">
                                                                    Inquiry <span id="sl-inquiry-2"></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-4">
                                                            @php $id = abs(crc32(uniqid())) @endphp
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                       value="listening"
                                                                       id="listening-{{$id}}">
                                                                <label class="form-check-label"
                                                                       for="listening-{{$id}}">
                                                                    Listening <span id="sl-listening-2"></span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                @php $id = abs(crc32(uniqid())) @endphp
                                                                <input class="form-check-input" type="checkbox"
                                                                       value="reading"
                                                                       id="reading-{{$id}}">
                                                                <label class="form-check-label"
                                                                       for="reading-{{$id}}">
                                                                    Reading <span id="sl-reading-2"></span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                @php $id = abs(crc32(uniqid())) @endphp
                                                                <input class="form-check-input" type="checkbox"
                                                                       value="writing"
                                                                       id="writing-{{$id}}">
                                                                <label class="form-check-label"
                                                                       for="writing-{{$id}}">
                                                                    Writing <span id="sl-writing-2"></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- PSAT Data Box -->
                                        <div id="column-box-2" class="filter-box-container" style="display:none">
                                            <div class="box filter-box">
                                                <div class="box-body">
                                                    <h4>Column Statistics</h4>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <p>
                                                                <strong>Reading and Writing</strong>
                                                                <br>
                                                                <span id="sl-readwrite-2"></span>
                                                                <br>
                                                                Average: <span id="avg-readwrite-2"></span>
                                                            </p>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <p>
                                                                <strong>Mathematics</strong>
                                                                <br>
                                                                <span id="sl-math-2"></span><br>
                                                                Average: <span id="avg-math-2"></span>
                                                            </p>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <p>
                                                                <strong>Total Score</strong>
                                                                <br>
                                                                <span id="sl-total-2"></span><br>
                                                                Average: <span id="avg-total-2"></span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="table-responsive">
                                            <table id="sbac-compare-2"
                                                   class="table table-bordered table-striped compare-table">
                                                <thead>
                                                <tr>
                                                    <th>Last Name</th>
                                                    <th>First Name</th>
                                                    <th>Math Scale</th>
                                                    <th>Math Level</th>
                                                    <th>ELA Scale</th>
                                                    <th>ELA Level</th>
                                                    <th>Problem Solving and Modeling</th>
                                                    <th>Communicating and Reasoning</th>
                                                    <th>Concepts and Procedures</th>
                                                    <th>Inquiry</th>
                                                    <th>Listening</th>
                                                    <th>Reading</th>
                                                    <th>Writing</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="table-responsive">
                                            <table id="psat-compare-2"
                                                   class="table table-bordered table-striped compare-table">
                                                <thead>
                                                <tr>
                                                    <th width="15%">Last Name</th>
                                                    <th width="15%">First Name</th>
                                                    <th width="10%">Reading/Writing</th>
                                                    <th width="10%">Mathematics</th>
                                                    <th class="success" width="15%">Total</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
    </div>
@endsection