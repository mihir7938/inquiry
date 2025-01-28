@extends('layouts.app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <div class="d-flex justify-content-between">
                        <h1 class="m-0">Users</h1>
                        <a href="{{route('admin.users.add')}}" class="btn btn-primary">Add New User</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    @include('shared.alert')
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">All Users</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th width="100">Action</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Mobile Number</th>
                                            <th>Role</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Action</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Mobile Number</th>
                                            <th>Role</th>
                                            <th>Status</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach($users as $user)
                                            <tr>
                                                <td class="text-center">
                                                    <a href="{{route('admin.users.edit', ['id' => $user->id])}}" class="btn btn-outline-primary btn-circle">
                                                        <i class="fas fa-pen"></i>
                                                    </a>
                                                    @if($user->isUser())
                                                        <a href="{{route('admin.users.delete', ['id' => $user->id])}}" class="btn btn-outline-danger btn-circle">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
                                                    @endif
                                                </td>
                                                <td>{{$user->name}}</td>
                                                <td>{{$user->email}}</td>
                                                <td>{{$user->phone}}</td>
                                                <td>{{$user->role->name}}</td>
                                                <td>{{($user->status == 1) ? 'Active' : 'Not Active'}}</td>
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