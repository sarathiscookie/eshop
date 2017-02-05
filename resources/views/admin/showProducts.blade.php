@extends('admin.layouts.app')

@section('title', 'Admin: Products List')

@section('content')
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        <ol class="breadcrumb">
            <li><a href="{{ url('/admin/home') }}">Dashboard</a></li>
            <li class="active">Products</li>
        </ol>

        <div class="row">
            <div class="panel panel-primary">
                <!-- Default panel contents -->
                <div class="panel-heading">Products</div>
                <div class="panel-body">
                    @if (session()->has('deleteSuccess'))
                        <div class="alert alert-success">{{ session()->get('deleteSuccess') }}</div>
                    @endif
                    <a href="{{ url('/admin/products/create') }}" class="btn btn-primary pull-right">Add Product</a>
                    <!-- Table -->
                    <table class="table table-bordered table-hover">
                        <tr>
                            <th>id</th>
                            <th>Product Name</th>
                            <th>Description</th>
                            <th>Stock</th>
                            <th>Price</th>
                            <th>Created</th>
                            <th>Action</th>
                        </tr>
                        @forelse ($products as $product)
                            <tr @if($product->stock == 'no') class="warning" @endif>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->description }}</td>
                                <td>@if ($product->stock == 'no') <span class="label label-danger">Out of stock</span> @else <span class="label label-default">In stock</span> @endif</td>
                                <td>{{ $product->amount }}</td>
                                <td>{{ date('d.m.y H.i', strtotime($product->created_at)) }}</td>
                                <td>{!! Form::open(['method' => 'DELETE' ,'route' => ['destroyProducts', $product->id], 'style' => 'display:inline']) !!}

                                    {!! Form::submit ('Delete', ['class' => 'btn btn-danger']) !!}

                                    {!! Form::close() !!}
                                </td>
                            </tr>
                        @empty
                            <p>No Products</p>
                        @endforelse
                    </table>
                </div>
                <div class="panel-footer">{{ $products->links() }}</div>
            </div>
        </div>
    </div>
@endsection



