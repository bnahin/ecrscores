@extends('layout')

@section('page-title', 'ECRCHS Scores Application - Homepage')

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.bundle.min.js"
            integrity="sha256-MZo5XY1Ah7Z2Aui4/alkfeiq3CopMdV/bbkc/Sh41+s=" crossorigin="anonymous"></script>
@endpush

@section('content')
    <p>Welcome to the ECR Scores interface. To begin analyzing your students' scores, select an academic year and course
        on the left sidebar.</p>
    <hr>
    <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-red"><i class="fa fa-pencil"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Average PSAT Total</span>
                    <span
                        class="info-box-number">{!! \App\Helpers\PSATHelper::calculateAverageTotal() !!}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="fa fa-calculator"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Average SBAC Math</span>
                    <span
                        class="info-box-number">{!! \App\Helpers\SBACDataHelper::calculateAverageMath() !!}</span>

                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>

        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>

        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-green"><i class="fa fa-book"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Average SBAC ELA</span>
                    <span
                        class="info-box-number">{!! \App\Helpers\SBACDataHelper::calculateAverageEla() !!}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-yellow"><i class="ion ion-ios-people-outline"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Students</span>
                    <span class="info-box-number">{{ number_format(\App\Helpers\AuthHelper::countStudents()) }}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
    </div>
    <div class="row">
        <div class="col-md-6" style="padding-right:5px;">
            <div class="box box-default">
                <div class="box-header"><h5>PSAT Averages</h5></div>
                <div class="box-body">
                    <canvas id="psat-averages"></canvas>
                </div>
                <div class="overlay">
                    <i class="fa fa-spinner fa-spin"></i>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-default">
                <div class="box-header"><h5>SBAC Math Levels</h5></div>
                <div class="box-body">
                    <canvas id="math-levels"></canvas>
                </div>
                <div class="overlay">
                    <i class="fa fa-spinner fa-spin"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="box box-default">
                <div class="box-header"><h5>SBAC Averages</h5></div>
                <div class="box-body">
                    <canvas id="sbac-averages"></canvas>
                </div>
                <div class="overlay">
                    <i class="fa fa-spinner fa-spin"></i>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-default">
                <div class="box-header"><h5>SBAC ELA Levels</h5></div>
                <div class="box-body">
                    <canvas id="ela-levels"></canvas>
                </div>
                <div class="overlay">
                    <i class="fa fa-spinner fa-spin"></i>
                </div>
            </div>
        </div>
    </div>
@endsection