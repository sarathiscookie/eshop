@extends('admin.layouts.app')

@section('title', 'Admin: Create Product')

@section('styles')
<link rel="stylesheet" href="/css/core.css">
@endsection

@section('content')
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <ol class="breadcrumb">
        <li><a href="{{ url('/admin/home') }}">Dashboard</a></li>
        <li><a href="{{ url('/admin/products') }}">Products</a></li>
        <li class="active">Create</li>
    </ol>

    <div class="row">
        <div class="panel panel-primary">
            <!-- Default panel contents -->
            <div class="panel-heading">
                Add Product
            </div>
            <div class="panel-body">
                @if (session()->has('status'))
                <div class="alert alert-success">{{ session()->get('status') }}</div>
                @endif
                <form class="form-horizontal" role="form" method="POST" action="{{ route('storeProducts') }}">
                    {{ csrf_field() }}

                    <div class="form-group required{{ $errors->has('productname') ? ' has-error' : '' }}">
                        <label for="productname" class="col-md-4 control-label">Product Name</label>

                        <div class="col-md-6">
                            <input id="productname" type="text" class="form-control" name="productname" value="{{ old('productname') }}">

                            @if ($errors->has('productname'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('productname') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group required{{ $errors->has('description') ? ' has-error' : '' }}">
                        <label for="description" class="col-md-4 control-label">Description</label>

                        <div class="col-md-6">
                            <textarea id="description" type="text" class="form-control" name="description" rows="3">{{ old('description') }}</textarea>

                            @if ($errors->has('description'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group required{{ $errors->has('stock') ? ' has-error' : '' }}">
                        <label for="stock" class="col-md-4 control-label">Stock</label>

                        <div class="col-md-6">
                            <select id="stock" class="form-control" name="stock">
                                <option value="0">--Select your product status--</option>
                                <option value="yes" @if(old('stock') == 'yes') selected @endif>Yes</option>
                                <option value="no" @if(old('stock') == 'no') selected @endif>No</option>
                            </select>

                            @if ($errors->has('stock'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('stock') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group required{{ $errors->has('amount') ? ' has-error' : '' }}">
                        <label for="amount" class="col-md-4 control-label">Amount</label>

                        <div class="col-md-6">
                            <input id="amount" type="text" class="form-control" name="amount" value="{{ old('amount') }}">

                            @if ($errors->has('amount'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('amount') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group.required">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                Create Product
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@endsection


