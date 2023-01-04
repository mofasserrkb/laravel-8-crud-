@extends('products.layout')
@section('content')

<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Laravel 8 CRUD </h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-success" href="{{ route('products.create') }}"> Create New Product</a>

        </div>
    </div>
</div>

@if (session()->has('success'))
    <div class="alert alert-success">
        <p></p>
        {{ session()->get('success') }}
    </div>
@endif

<table class="table table-bordered">
    <tr>
        <th>No</th>
        <th>Image</th>
        <th>Name</th>
        <th>Details</th>
        <th width="280px">Action</th>
    </tr>
    @foreach ($products as $key=> $product)
    <tr>

        <td>{{++$key}}</td>

        <td><img src="{{asset('/images/'.$product->image )}}" width="100px"></td>

        <td>{{ $product->name }}</td>

        <td>{{ $product->detail }}</td>
        <td>
            {{-- {{ route('products.destroy',$product->id) }} --}}
            <form action="{{ route('products.destroy',$product->id) }}" method="POST">
                {{-- {{ route('products.show',$product->id) }} --}}
                <a class="btn btn-info" href="{{ route('products.show',$product->id) }}">Show</a>
                {{-- {{ route('products.edit',$product->id) }} --}}
                <a class="btn btn-primary" href="{{ route('products.edit',$product->id) }}">Edit</a>

                @csrf
                @method('DELETE')

                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>

{{-- {!! $products->links() !!} --}}


@endsection
