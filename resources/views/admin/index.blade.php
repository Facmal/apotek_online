@extends('be.master')
@section('sidebar')
@include('be.sidebar')
@endsection
@section('navbar')
@include('be.navbar')
@endsection
@section('content')

<div class="col-xl-9 stretch-card grid-margin">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between flex-wrap">
                <div>
                    <div class="card-title mb-0">Sales Revenue</div>
                    <h3 class="font-weight-bold mb-0">$32,409</h3>
                </div>
                <div>
                    <div class="d-flex flex-wrap pt-2 justify-content-between sales-header-right">
                        <div class="d-flex mr-5">
                            <button type="button" class="btn btn-social-icon btn-outline-sales">
                                <i class="mdi mdi-inbox-arrow-down"></i>
                            </button>
                            <div class="pl-2">
                                <h4 class="mb-0 font-weight-semibold head-count"> $8,217 </h4>
                                <span class="font-10 font-weight-semibold text-muted">TOTAL SALES</span>
                            </div>
                        </div>
                        <div class="d-flex mr-3 mt-2 mt-sm-0">
                            <button type="button" class="btn btn-social-icon btn-outline-sales profit">
                                <i class="mdi mdi-cash text-info"></i>
                            </button>
                            <div class="pl-2">
                                <h4 class="mb-0 font-weight-semibold head-count"> 2,804 </h4>
                                <span class="font-10 font-weight-semibold text-muted">TOTAL PROFIT</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <p class="text-muted font-13 mt-2 mt-sm-0"> Your sales monitoring dashboard template. <a class="text-muted font-13" href="#"><u>Learn more</u></a>
            </p>
            <div class="flot-chart-wrapper">
                <div id="flotChart" class="flot-chart">
                    <canvas class="flot-base"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
