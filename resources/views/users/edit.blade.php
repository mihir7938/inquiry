@extends('layouts.app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Inquiry Form</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form method="POST" action="{{route('users.inquiries.update.save')}}" class="form" id="edit-inquiry-form" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{$inquiry->id}}" />
                        @include('shared.alert')
                        @if (count($errors) > 0)
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Edit Inquiry</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="company_name">Company Name*</label>
                                            <input type="text" class="form-control" id="company_name" name="company_name" placeholder="Company Name*" value="{{$inquiry->company_name}}" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label for="contact_person">Contact Person*</label>
                                            <input type="text" class="form-control" id="contact_person" name="contact_person" placeholder="Contact Person*" value="{{$inquiry->contact_person}}">
                                        </div>
                                        <div class="form-group">
                                            <label for="phone">Mobile Number*</label>
                                            <input type="text" class="form-control" id="phone" name="phone" placeholder="Mobile Number*" value="{{$inquiry->phone}}">
                                        </div>
                                        <div class="form-group">
                                            <label for="business">Business*</label>
                                            <select id="business" name="business" class="form-control">
					                            <option value="">Select Business*</option>
					                            @foreach($businesses as $business)
					                                <option value="{{$business->id}}" @if($inquiry->business_id == $business->id) selected @endif>{{$business->name}}</option>
					                            @endforeach
					                        </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="city">City (Eg: GJ-Surat)*</label>
                                            <input type="text" class="form-control" id="city" name="city" placeholder="City (Eg: GJ-Surat)*" value="{{$inquiry->city}}">
                                        </div>
                                        <div class="form-group">
                                            <label for="requirement">Requirement*</label>
                                            <select id="requirement" name="requirement" class="form-control">
					                            <option value="">Select Requirement*</option>
					                            @foreach($requirements as $requirement)
					                                <option value="{{$requirement->id}}" @if($inquiry->requirement_id == $requirement->id) selected @endif>{{$requirement->name}}</option>
					                            @endforeach
					                        </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="status">Status*</label>
                                            <select id="status" name="status" class="form-control">
					                            <option value="">Select Status*</option>
					                            @foreach($statuses as $status)
					                                <option value="{{$status->id}}" @if($inquiry->status_id == $status->id) selected @endif>{{$status->name}}</option>
					                            @endforeach
					                        </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="reff">Reff Name & Contact (Self or Reff)</label>
                                            <input type="text" class="form-control" id="reff" name="reff" placeholder="Reff Name & Contact" value="{{$inquiry->reff}}">
                                        </div>
                                        <div class="form-group">
                                            <label for="user">User</label>
                                            <input type="text" class="form-control" id="user" name="user" value="{{Auth::user()->name}}" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label for="assign">Assign*</label>
                                            <select id="assign" name="assign" class="form-control">
					                            <option value="">Select Assign*</option>
					                            @foreach($users as $user)
					                            	@if($user->isUser())
					                                	<option value="{{$user->id}}" @if($inquiry->assign_id == $user->id) selected @endif>{{$user->name}}</option>
					                                @endif
					                            @endforeach
					                        </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="remarks">Remarks</label>
                                            <textarea class="form-control" id="remarks" name="remarks" rows="4" cols="50" placeholder="Remarks">{{$inquiry->remarks}}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="contact_person">Contact Person*</label>
                                            <input type="text" class="form-control" id="contact_person" name="contact_person" placeholder="Contact Person*" value="{{$inquiry->contact_person}}">
                                        </div>
                                        <div class="form-group">
                                            <label for="followup_date_1">Followup Date</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                                </div>
                                                <input type="text" id="followup_date_1" name="followup_date_1" class="form-control followup_date" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" value="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="followup_remarks_1">Followup Remarks</label>
                                            <textarea class="form-control" id="followup_remarks_1" name="followup_remarks_1" rows="4" cols="50" placeholder="Followup Remarks">{{$inquiry->followup_remarks_1}}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="followup_date_2">Followup Date</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                                </div>
                                                <input type="text" id="followup_date_2" class="form-control followup_date" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="followup_remarks_2">Followup Remarks</label>
                                            <textarea class="form-control" id="followup_remarks_2" name="followup_remarks_2" rows="4" cols="50" placeholder="Followup Remarks">{{$inquiry->followup_remarks_2}}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="image">Image (allowed only JPG,JPEG &amp; PNG files)</label>
                                            <div class="input-group image_div">
                                                <div class="custom-file">             
                                                    <input type="file" class="custom-file-input" id="image" name="image">
                                                    <label class="custom-file-label" for="image">Choose file</label>
                                                </div>              
                                            </div>
                                            @if($inquiry->image)
                                                <img src="{{asset('assets/'.$inquiry->image)}}" width="200px" class="mt-4 d-block" />
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary" id="btnsubmit" name="btnsubmit">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')
<script>
    $(function () {
        $('.followup_date').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
        bsCustomFileInput.init();
        $('#edit-inquiry-form').validate({
            rules:{
                contact_person: {
                    required: true
                },
                phone: {
                    required: true,
                    digits: true,
                    minlength: 10
                },
                business: {
                    required: true
                },
                city: {
                    required: true
                },
                requirement: {
                    required: true
                },
                status: {
                    required: true
                },
                assign: {
                    required: true
                },
                image: {
                    extension: "png|jpg|jpeg",
                    maxsize: 2000000,
                }
            },
            messages:{
                contact_person: {
                    required: "Please enter contact person."
                },
                phone: {
                    required: "Plese enter mobile number.",
                },
                business: {
                    required: "Please select business."
                },
                city: {
                    required: "Please enter city."
                },
                requirement: {
                    required: "Please select requirement."
                },
                status: {
                    required: "Please select status."
                },
                assign: {
                    required: "Please select assign."
                },
                image: {
                    extension: "Please select valid image.",
                    maxsize: "File size must be less than 2MB."
                }
            },
            errorPlacement: function(error, element) {
                if (element.attr("name") == "image" ) {
                    $(".image_div").after(error);
                } else {
                    error.insertAfter(element);
                }
            }
        });
    });
</script>
@endsection