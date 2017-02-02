@extends('admin.layouts.app')

@section('title', 'Admin: Dashboard')

@section('styles')
    <link rel="stylesheet" href="/css/dashboard.css">
@endsection

@section('content')
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        <ol class="breadcrumb">
            <li class="active">Dashboard</li>
        </ol>

        <div class="row">
            @if(isset($newUsers))
                <div class="col-md-6">
                    <h2>New 5 Users</h2>
                    <ul class="list-group">
                        @foreach($newUsers as $newUser)
                            <li class="list-group-item">
                                <span class="badge">View</span>
                                {{ $newUser->name }} {{ $newUser->lastname }}
                                <small>({{ date('d.m.y', strtotime($newUser->created_at)) }})</small>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(isset($newProducts))
                <div class="col-md-6">
                    <h2>New 5 Products</h2>
                    <ul class="list-group">
                        @foreach($newProducts as $newProduct)
                            <li class="list-group-item">
                                <span class="badge">View</span>
                                {{ $newProduct->name }} @if($newProduct->stock == 'no') <span class="label label-danger">Out of stock</span> @endif
                                <small>({{ date('d.m.y', strtotime($newProduct->created_at)) }})</small>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('scripts')
@endsection


