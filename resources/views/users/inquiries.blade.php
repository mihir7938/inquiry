@extends('layouts.app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <div class="d-flex justify-content-between">
                        <h1 class="m-0">Inquiries</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">All Inquiries</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTableInquiry" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Action</th>
                                            <th>Company</th>
                                            <th>Contact Name</th>
                                            <th>Mobile Number</th>
                                            <th>Assign</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                            <th>Business</th>
                                            <th>Requirement</th>
                                            <th>City</th>
                                            <th>Reff</th>
                                            <th>Remarks</th>
                                            <th>Image</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th></th>
                                            <th>Action</th>
                                            <th>Company</th>
                                            <th>Contact Name</th>
                                            <th>Mobile Number</th>
                                            <th>Assign</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                            <th>Business</th>
                                            <th>Requirement</th>
                                            <th>City</th>
                                            <th>Reff</th>
                                            <th>Remarks</th>
                                            <th>Image</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach($inquiries as $inquiry)
                                            <tr>
                                                <td></td>
                                                <td style="width: 80px;">
                                                    <a href="{{route('users.inquiries.edit', ['id' => $inquiry->id])}}" class="btn btn-outline-primary btn-circle">
                                                        <i class="fas fa-pen"></i>
                                                    </a>
                                                </td>
                                                <td>{{$inquiry->company_name}}</td>
                                                <td>{{$inquiry->contact_person}}</td>
                                                <td>{{$inquiry->phone}}</td>
                                                <td>{{$inquiry->assign->name}}</td>
                                                <td>{{$inquiry->status->name}}</td>
                                                <td>{{Carbon\Carbon::parse($inquiry->inquiry_date)->format('d-m-Y')}}</td>
                                                <td>{{$inquiry->business->name}}</td>
                                                <td>{{$inquiry->requirement->name}}</td>
                                                <td>{{$inquiry->city}}</td>
                                                <td>{{$inquiry->reff}}</td>
                                                <td>{{$inquiry->remarks}}</td>
                                                <td>
                                                    @if($inquiry->image)
                                                        <img src="{{asset('assets/'.$inquiry->image)}}" width="100px" />
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')
<script>
    $(document).ready(function() {
        $('#dataTableInquiry').DataTable({
            "buttons": ["csv", "excel"],
            "destroy": true, 
            "paging": true,
            "lengthChange": false,
            "ordering": true,
            "info": true,
            "responsive": true,
        }).buttons().container().appendTo('#dataTableInquiry_wrapper .col-md-6:eq(0)');
    });
</script>
@endsection