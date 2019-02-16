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
                    <li class="active"><a href="#sbac8" data-toggle="tab" aria-expanded="true">SBAC 8</a><br></li>
                    <li class=""><a href="#sbac11" data-toggle="tab" aria-expanded="false">SBAC 11</a></li>
                    <li class=""><a href="#psat11" data-toggle="tab" aria-expanded="false">PSAT 11</a></li>
                    <li class=""><a href="#compare" data-toggle="tab" aria-expanded="false">Compare</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="sbac8">

                        <div class="box box-success">
                            <div class="box-header with-border">
                                <h3 class="box-title">SBAC Grade 8 <br></h3>
                                <p class="help-block">Click on table cell to view data for Grade 11.</p>
                                <p class="help-block">Hover over charts for detailed information.</p>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <table id="sbac8" class="table table-bordered table-striped static-table">
                                    <thead>
                                    <tr>
                                        <th>Last Name</th>
                                        <th>First Name</th>
                                        <th>Math Scale
                                            <span class="sparklines-box"
                                                  values="{{\App\Helpers\Helper::formatForSparkline($sbac8,'math_scale')}}"></span>
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
                                        <th>ELA Scale
                                            <span class="sparklines-box"
                                                  values="{{\App\Helpers\Helper::formatForSparkline($sbac8,'ela_scale')}}"></span>
                                        </th>
                                        <th>Inquiry
                                            <span class="sparklines-pie"
                                                  values="{{\App\Helpers\Helper::formatForSparkline($sbac8,'inquiry')}}"></span>
                                        </th>
                                        <th>Listening
                                            <span class="sparklines-pie"
                                                  values="{{\App\Helpers\Helper::formatForSparkline($sbac8,'listening')}}"></span>
                                        </th>
                                        <th>Reading
                                            <span class="sparklines-pie"
                                                  values="{{\App\Helpers\Helper::formatForSparkline($sbac8,'reading')}}"></span>
                                        </th>
                                        <th>Writing
                                            <span class="sparklines-pie"
                                                  values="{{\App\Helpers\Helper::formatForSparkline($sbac8,'writing')}}"></span>
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
                                            <td data-grade="11"
                                                data-ssid="{{ $score->ssid }}"
                                                data-fields="ela_scale,ela_level">{!! $score->ela_scale ?? "<em>No Score</em>" !!}
                                                <hr style="margin:5px 0">
                                                {!! $score->ela_level !!}
                                            </td>
                                            <td class="{{ \App\Helpers\SBACDataHelper::getColorFromInt($score->getOriginal('inquiry') ?? -1) }}"
                                                data-grade="11"
                                                data-ssid="{{ $score->ssid }}"
                                                data-fields="inquiry">{!! $score->inquiry !!}
                                            </td>
                                            <td class="{{ \App\Helpers\SBACDataHelper::getColorFromInt($score->getOriginal('listening') ?? -1) }}"
                                                data-grade="11"
                                                data-ssid="{{ $score->ssid }}"
                                                data-fields="listening"> {!! $score->listening !!}
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
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.box-body -->
                        </div>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="sbac11">
                        <div class="box box-success">
                            <div class="box-header with-border">
                                <h3 class="box-title">SBAC Grade 11</h3>
                                <p class="help-block">Click on table cell to view data for Grade 8.</p>
                                <p class="help-block">Hover over charts for detailed information.</p>
                            </div>
                            <div class="box-body">
                                <table id="sbac11" class="table table-bordered table-striped static-table">
                                    <thead>
                                    <tr>
                                        <th>Last Name</th>
                                        <th>First Name</th>
                                        <th>Math Scale
                                            <span class="sparklines-box"
                                                  values="{{\App\Helpers\Helper::formatForSparkline($sbac11,'math_scale')}}"></span>
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
                                        <th>ELA Scale
                                            <span class="sparklines-box"
                                                  values="{{\App\Helpers\Helper::formatForSparkline($sbac11,'ela_scale')}}"></span>
                                        </th>
                                        <th>Inquiry
                                            <span class="sparklines-pie"
                                                  values="{{\App\Helpers\Helper::formatForSparkline($sbac11,'inquiry')}}"></span>
                                        </th>
                                        <th>Listening
                                            <span class="sparklines-pie"
                                                  values="{{\App\Helpers\Helper::formatForSparkline($sbac11,'listening')}}"></span>
                                        </th>
                                        <th>Reading
                                            <span class="sparklines-pie"
                                                  values="{{\App\Helpers\Helper::formatForSparkline($sbac11,'reading')}}"></span>
                                        </th>
                                        <th>Writing
                                            <span class="sparklines-pie"
                                                  values="{{\App\Helpers\Helper::formatForSparkline($sbac11,'writing')}}"></span>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($sbac11 as $score)
                                        <tr>
                                            <td>{{ $score->last_name }}</td>
                                            <td>{{ $score->first_name }}</td>
                                            <td class="{{ \App\Helpers\SBACDataHelper::getColorFromInt($score->getOriginal('math_level') ?? -1) }}"
                                                data-grade="8"
                                                data-ssid="{{ $score->ssid }}"
                                                data-fields="math_scale,math_level">{!! $score->math_scale ?? "<em>No Score</em>" !!}
                                                <hr style="margin:5px 0">
                                                {!! $score->math_level !!}</td>
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
                                            <td class="{{ \App\Helpers\SBACDataHelper::getColorFromInt($score->getOriginal('ela_level') ?? -1) }}"
                                                data-grade="8"
                                                data-ssid="{{ $score->ssid }}"
                                                data-fields="ela_scale,ela_level"> {!! $score->ela_scale ?? "<em>No Score</em>" !!}
                                                <hr style="margin:5px 0">
                                                {!! $score->ela_level !!}</td>
                                            <td class="{{ \App\Helpers\SBACDataHelper::getColorFromInt($score->getOriginal('inquiry') ?? -1) }}"
                                                data-grade="8"
                                                data-ssid="{{ $score->ssid }}"
                                                data-fields="inquiry">
                                                {!! $score->inquiry !!}</td>
                                            <td class="{{ \App\Helpers\SBACDataHelper::getColorFromInt($score->getOriginal('listening') ?? -1) }}"
                                                data-grade="8"
                                                data-ssid="{{ $score->ssid }}"
                                                data-fields="listening">
                                                {!! $score->listening !!}</td>
                                            <td class="{{ \App\Helpers\SBACDataHelper::getColorFromInt($score->getOriginal('reading') ?? -1) }}"
                                                data-grade="8"
                                                data-ssid="{{ $score->ssid }}"
                                                data-fields="reading">{!! $score->reading !!}</td>
                                            <td class="{{ \App\Helpers\SBACDataHelper::getColorFromInt($score->getOriginal('writing') ?? -1) }}"
                                                data-grade="8"
                                                data-ssid="{{ $score->ssid }}"
                                                data-fields="writing">{!! $score->writing !!}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
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
                                <table id="psat11" class="table table-bordered table-striped static-table">
                                    <thead>
                                    <tr>
                                        <th width="15%">Last Name</th>
                                        <th width="15%">First Name</th>
                                        <th width="10%">Reading/Writing
                                            <span class="sparklines-box"
                                                  values="{{\App\Helpers\Helper::formatForSparkline($psat11,'readwrite')}}"></span>
                                        </th>
                                        <th width="10%">Mathematics
                                            <span class="sparklines-box"
                                                  values="{{\App\Helpers\Helper::formatForSparkline($psat11,'math')}}"></span>
                                        </th>
                                        <th class="success" width="15%">Total<br>
                                            <span class="sparklines-box"
                                                  values="{{\App\Helpers\Helper::formatForSparkline($psat11,'total')}}"></span>
                                        </th>
                                        <th>Percentiles</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($psat11 as $score)
                                        <tr>
                                            <td width="15%">{{ $score->first_name }}</td>
                                            <td width="15%">{{ $score->last_name }}</td>
                                            <td width="10%">{{ $score->readwrite }}</td>
                                            <td width="10%">{{ $score->math }}</td>
                                            <td class="success" width="15%">{{ $score->total }}</td>
                                            <td>
                                                <div class="row">
                                                    <div class="col-xs-4"><strong rel="tooltip"
                                                                                  title='Among your students in Period {{\App\Helpers\CourseHelper
                                                                                                                ::getPeriodFromCourse($course)}}.'>
                                                            Period</strong><br>
                                                        {{ \App\Helpers\PSATHelper::calcTotalPercentile(
                                                            $score->ssid,
                                                            $score->total,
                                                            $score->year,
                                                            'period',
                                                            Auth::user()->email,
                                                             $course) }}%
                                                    </div>
                                                    <div class="col-xs-4">
                                                        <strong rel="tooltip"
                                                                title="Among your students across all periods.">Students</strong><br>
                                                        {{ \App\Helpers\PSATHelper::calcTotalPercentile(
                                                            $score->ssid,
                                                            $score->total,
                                                            $score->year,
                                                            'teacher',
                                                            Auth::user()->email) }}
                                                        %
                                                    </div>
                                                    <div class="col-xs-4">
                                                        <strong rel="tooltip" title="Among students in all classes.">School</strong><br>
                                                        {{ \App\Helpers\PSATHelper::calcTotalPercentile(
                                                            $score->ssid,
                                                            $score->total,
                                                            $score->year, 'school') }}%
                                                    </div>
                                                </div>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
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
                                    <div class="col-lg-6">
                                        <div class="row compare-row">
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
                                        <div id="filter-box-1" style="display: none;">
                                            @include('partials.filterbox')
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
                                                    <th>Communicating and Reasoning</th>
                                                    <th>Concepts and Procedures</th>
                                                    <th>Problem Solving and Modeling</th>
                                                    <th>ELA Scale</th>
                                                    <th>ELA Level</th>
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
                                                    <th>Percentiles</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="row compare-row">
                                            <div class="col-xs-6">
                                                <label class="control-label" for="courseselect-2">
                                                    Course:
                                                </label>
                                                <br>
                                                <select class="form-control select2-course compare-select"
                                                        id="courseselect-2"
                                                        style="width:100%;">
                                                    <option value="" data-label="-- Select Course --" data-col="2"
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
                                        <div id="filter-box-2" style="display: none;">
                                            @include('partials.filterbox')
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
                                                    <th>Communicating and Reasoning</th>
                                                    <th>Concepts and Procedures</th>
                                                    <th>Problem Solving and Modeling</th>
                                                    <th>ELA Scale</th>
                                                    <th>ELA Level</th>
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
                                                    <th>Percentiles</th>
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