@extends('layouts.app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Home</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $total_inquiry }}</h3>
                            <p>Total Inquiry</p>
                        </div>
                        <a href="{{route('admin.inquiries')}}" class="small-box-footer py-3">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-dark">
                        <div class="inner">
                            <h3>{{ $total_pending_inquiry }}</h3>
                            <p>Total Pending Inquiry</p>
                        </div>
                        <a href="{{route('admin.inquiries')}}?status=1" class="small-box-footer py-3">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h3>{{ $total_demo }}</h3>
                            <p>Total Demo</p>
                        </div>
                        <a href="{{route('admin.inquiries')}}?status=2" class="small-box-footer py-3">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $total_followup }}</h3>
                            <p>Total Followup</p>
                        </div>
                        <a href="{{route('admin.inquiries')}}?status=3" class="small-box-footer py-3">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $total_confirmed }}</h3>
                            <p>Total Confirmed</p>
                        </div>
                        <a href="{{route('admin.inquiries')}}?status=4" class="small-box-footer py-3">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $total_cancelled }}</h3>
                            <p>Total Cancelled</p>
                        </div>
                        <a href="{{route('admin.inquiries')}}?status=5" class="small-box-footer py-3">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-dark">
                        <div class="inner">
                            <h3>{{ $total_future_list }}</h3>
                            <p>Total Future List</p>
                        </div>
                        <a href="{{route('admin.inquiries')}}?status=6" class="small-box-footer py-3">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $total_users }}</h3>
                            <p>Total Users</p>
                        </div>
                        <a href="{{route('admin.users')}}" class="small-box-footer py-3">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')
@endsection