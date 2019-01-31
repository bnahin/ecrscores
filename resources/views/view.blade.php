@extends('layout')
@section('page-title', 'View Scores')


@push('scripts')
    <script>
      $(function () {
        $('table').DataTable()
      })
    </script>
@endpush

@php
    $sbac8 = $data['sbac'][8]->get();
    $sbac8c = $sbac8;
    $sbac11 = $data['sbac'][11]->get();
    $sbac11c = $sbac11;
@endphp

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">SBAC 8</a></li>
                    <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false">SBAC 11</a></li>
                    <li class=""><a href="#tab_3" data-toggle="tab" aria-expanded="false">PSAT 11</a></li>
                    <li class=""><a href="#tab_4" data-toggle="tab" aria-expanded="false">Compare</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">

                        <div class="box box-success">
                            <div class="box-header">
                                <h3 class="box-title">SBAC Grade 8</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <table id="sbac8" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>Last Name</th>
                                        <th>First Name</th>
                                        <th>Math Scale</th>
                                        <th>Communicating and Reasoning</th>
                                        <th>Concepts and Procedures</th>
                                        <th>Problem Solving and Modeling</th>
                                        <th>ELA Scale</th>
                                        <th>Inquiry</th>
                                        <th>Listening</th>
                                        <th>Reading</th>
                                        <th>Writing</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($sbac8 as $score)
                                        <tr>
                                            <td>{{ $score->last_name }}</td>
                                            <td>{{ $score->first_name }}</td>
                                            <td class="">
                                                {!! $score->math_scale ?? "<em>No Score</em>" !!}
                                                <hr style="margin:5px 0">
                                                {!! $score->math_level !!}</td>
                                            <td class="{{ \App\Helpers\SBACDataHelper::getColorFromInt($score->getOriginal('reasoning') ?? -1) }}">
                                                {!! $score->reasoning !!}</td>
                                            <td class="{{ \App\Helpers\SBACDataHelper::getColorFromInt($score->getOriginal('concepts') ?? -1) }}">
                                                {!! $score->concepts !!}</td>
                                            <td class="{{ \App\Helpers\SBACDataHelper::getColorFromInt($score->getOriginal('modeling') ?? -1) }}">
                                                {!! $score->modeling !!}</td>
                                            <td class="">
                                                {!! $score->ela_scale ?? "<em>No Score</em>" !!}
                                                <hr style="margin:5px 0">
                                                {!! $score->ela_level !!}</td>
                                            <td class="{{ \App\Helpers\SBACDataHelper::getColorFromInt($score->getOriginal('inquiry') ?? -1) }}">
                                                {!! $score->inquiry !!}</td>
                                            <td class="{{ \App\Helpers\SBACDataHelper::getColorFromInt($score->getOriginal('listening') ?? -1) }}">
                                                {!! $score->listening !!}</td>
                                            <td class="{{ \App\Helpers\SBACDataHelper::getColorFromInt($score->getOriginal('reading') ?? -1) }}">
                                                {!! $score->reading !!}</td>
                                            <td class="{{ \App\Helpers\SBACDataHelper::getColorFromInt($score->getOriginal('writing') ?? -1) }}">
                                                {!! $score->writing !!}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tr>
                                        <th>Last Name</th>
                                        <th>First Name</th>
                                        <th>Math Scale</th>
                                        <th>Communicating and Reasoning</th>
                                        <th>Concepts and Procedures</th>
                                        <th>Problem Solving and Modeling</th>
                                        <th>ELA Scale</th>
                                        <th>Inquiry</th>
                                        <th>Listening</th>
                                        <th>Reading</th>
                                        <th>Writing</th>
                                    </tr>
                                </table>
                            </div>
                            <!-- /.box-body -->
                        </div>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="tab_2">
                        <table id="sbac11" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Last Name</th>
                                <th>First Name</th>
                                <th>Math Scale</th>
                                <th>Communicating and Reasoning</th>
                                <th>Concepts and Procedures</th>
                                <th>Problem Solving and Modeling</th>
                                <th>ELA Scale</th>
                                <th>Inquiry</th>
                                <th>Listening</th>
                                <th>Reading</th>
                                <th>Writing</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($sbac11 as $score)
                                <tr>
                                    <td>{{ $score->last_name }}</td>
                                    <td>{{ $score->first_name }}</td>
                                    <td class="{{ \App\Helpers\SBACDataHelper::getColorFromInt($score->getOriginal('math_level') ?? -1) }}">
                                        {!! $score->math_scale ?? "<em>No Score</em>" !!}
                                        <hr style="margin:5px 0">
                                        {!! $score->math_level !!}</td>
                                    <td class="{{ \App\Helpers\SBACDataHelper::getColorFromInt($score->getOriginal('reasoning') ?? -1) }}">
                                        {!! $score->reasoning !!}</td>
                                    <td class="{{ \App\Helpers\SBACDataHelper::getColorFromInt($score->getOriginal('concepts') ?? -1) }}">
                                        {!! $score->concepts !!}</td>
                                    <td class="{{ \App\Helpers\SBACDataHelper::getColorFromInt($score->getOriginal('modeling') ?? -1) }}">
                                        {!! $score->modeling !!}</td>
                                    <td class="{{ \App\Helpers\SBACDataHelper::getColorFromInt($score->getOriginal('ela_level') ?? -1) }}">
                                        {!! $score->ela_scale ?? "<em>No Score</em>" !!}
                                        <hr style="margin:5px 0">
                                        {!! $score->ela_level !!}</td>
                                    <td class="{{ \App\Helpers\SBACDataHelper::getColorFromInt($score->getOriginal('inquiry') ?? -1) }}">
                                        {!! $score->inquiry !!}</td>
                                    <td class="{{ \App\Helpers\SBACDataHelper::getColorFromInt($score->getOriginal('listening') ?? -1) }}">
                                        {!! $score->listening !!}</td>
                                    <td class="{{ \App\Helpers\SBACDataHelper::getColorFromInt($score->getOriginal('reading') ?? -1) }}">
                                        {!! $score->reading !!}</td>
                                    <td class="{{ \App\Helpers\SBACDataHelper::getColorFromInt($score->getOriginal('writing') ?? -1) }}">
                                        {!! $score->writing !!}</td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tr>
                                <th>Last Name</th>
                                <th>First Name</th>
                                <th>Math Scale</th>
                                <th>Communicating and Reasoning</th>
                                <th>Concepts and Procedures</th>
                                <th>Problem Solving and Modeling</th>
                                <th>ELA Scale</th>
                                <th>Inquiry</th>
                                <th>Listening</th>
                                <th>Reading</th>
                                <th>Writing</th>
                            </tr>
                        </table>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="tab_3">
                        <table id="psat11" class="table table-bordered table-striped">
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
                            @foreach($data['psat']->where('grade', 11)->get() as $score)
                                <tr>
                                    <td width="15%">{{ $score->first_name }}</td>
                                    <td width="15%">{{ $score->last_name }}</td>
                                    <td width="10%">{{ $score->readwrite }}</td>
                                    <td width="10%">{{ $score->math }}</td>
                                    <td class="success" width="15%">{{ $score->total }}</td>
                                    <td>Period / School (colors)</td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Last Name</th>
                                <th>First Name</th>
                                <th>Reading/Writing</th>
                                <th>Mathematics</th>
                                <th>Total</th>
                                <th>Percentiles</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="tab_4">
                        <!--
                        SBAC 8 vs SBAC 11
                        Filters on both sides
                        If numeric, <br> Difference: +-...
                        -->
                    </div>
                    <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
@endsection