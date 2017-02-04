@extends('admin.layouts.app')

@section('title', 'Admin: Users List')

@section('content')
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        <ol class="breadcrumb">
            <li><a href="{{ url('/admin/home') }}">Dashboard</a></li>
            <li class="active">Users</li>
        </ol>

        <div class="row">
            <div class="panel panel-primary">
                <!-- Default panel contents -->
                <div class="panel-heading">
                    Users
                </div>
                <div class="panel-body">
                    @if (session()->has('deleteSuccess'))
                        <div class="alert alert-success">{{ session()->get('deleteSuccess') }}</div>
                    @endif
                    <a href="{{ url('/admin/users/create') }}" class="btn btn-primary pull-right">Add User</a>
                    <!-- Table -->
                    <table class="table table-bordered table-hover">
                        <tr>
                            <th>id</th>
                            <th>Name</th>
                            <th>Latname</th>
                            <th>Address</th>
                            <th>Pincode</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Created</th>
                            <th>Action</th>
                        </tr>
                        @forelse ($users as $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $user->name }} @if($user->roleID == 2) <span class="label label-default">{{ $user->role }}</span> @else <span class="label label-info">{{ $user->role }}</span> @endif</td>
                                <td>{{ $user->lastname }}</td>
                                <td>{{ $user->address }}</td>
                                <td>{{ $user->pincode }}</td>
                                <td>{{ $user->phone }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ date('d.m.y H.i', strtotime($user->created_at)) }}</td>
                                <td>
                                    {!! Form::open(['method' => 'DELETE' ,'route' => ['destroyUsers', $user->id], 'style' => 'display:inline']) !!}

                                    {!! Form::submit ('Delete', ['class' => 'btn btn-danger']) !!}

                                    {!! Form::close() !!}

                                </td>
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
    <script src="/js/core.js"></script>
@endsection


