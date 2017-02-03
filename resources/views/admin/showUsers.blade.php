@extends('admin.layouts.app')

@section('title', 'Admin: Users List')

@section('styles')
    <link rel="stylesheet" href="/css/dashboard.css">
@endsection

@section('content')
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        <ol class="breadcrumb">
            <li><a href="{{ url('/admin/home') }}">Dashboard</a></li>
            <li class="active">Users</li>
        </ol>

        <div class="row">
            <div class="panel panel-primary">
                <!-- Default panel contents -->
                <div class="panel-heading">Users</div>
                <div class="panel-body">
                    <!-- Table -->
                    <table class="table table-bordered table-hover">
                        <tr>
                            <th>id</th>
                            <th>Name</th>
                            <th>Latname</th>
                            <th>Pincode</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Created</th>
                            <th>Action</th>
                        </tr>
                        @forelse ($users as $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->lastname }}</td>
                                <td>{{ $user->pincode }}</td>
                                <td>{{ $user->phone }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ date('d.m.y H.i', strtotime($user->created_at)) }}</td>
                                <td><button type="button" class="btn btn-danger btn-xs">Delete</button></td>
                            </tr>
                        @empty
                            <p>No users</p>
                        @endforelse
                    </table>
                </div>
                <div class="panel-footer">{{ $users->links() }}</div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection


