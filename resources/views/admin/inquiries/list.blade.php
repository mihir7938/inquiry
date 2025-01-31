<div class="card">
    <div class="card-header">
        <h3 class="card-title">All Inquiries</h3>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTableInquiry" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Company</th>
                        <th>Contact Name</th>
                        <th>Mobile Number</th>
                        <th>User</th>
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
                        <th>Company</th>
                        <th>Contact Name</th>
                        <th>Mobile Number</th>
                        <th>User</th>
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
                            <td>{{$inquiry->company_name}}</td>
                            <td>{{$inquiry->contact_person}}</td>
                            <td>{{$inquiry->phone}}</td>
                            <td>{{$inquiry->user->name}}</td>
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