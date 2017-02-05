@extends('layouts.app')

@section('styles')
    <link href="/css/core.css" rel="stylesheet">
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Edit Profile</div>
                <div class="panel-body">
                    <div class="showMessage">
                    </div>
                    @if(isset($user))
                        <form class="form-horizontal" role="form" method="POST">
                            {{ csrf_field() }}

                            <div class="form-group required">
                                <label for="name" class="col-md-4 control-label">Name</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name" value="{{ $user->name }}">
                                </div>
                            </div>

                            <div class="form-group required">
                                <label for="name" class="col-md-4 control-label">Lastname</label>

                                <div class="col-md-6">
                                    <input id="lastname" type="text" class="form-control" name="lastname" value="{{ $user->lastname }}">
                                </div>
                            </div>

                            <div class="form-group required">
                                <label for="name" class="col-md-4 control-label">Address</label>

                                <div class="col-md-6">
                                    <textarea id="address" type="text" class="form-control" name="address" rows="3">{{ $user->address }}</textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="pincode" class="col-md-4 control-label">Pincode</label>

                                <div class="col-md-6">
                                    <input id="pincode" type="text" class="form-control" name="pincode" value="{{ $user->pincode }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="phone" class="col-md-4 control-label">Phone</label>

                                <div class="col-md-6">
                                    <input id="phone" type="text" class="form-control" name="phone" value="{{ $user->phone }}">
                                </div>
                            </div>

                            <div class="form-group.required">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="button" id="updateBuyerProfile" class="btn btn-primary">
                                        Update Profile
                                    </button>
                                </div>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src="/js/core.js"></script>
@endsection