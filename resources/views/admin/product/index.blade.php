@extends('layouts.admin')

@section('content')
    <div class="page-content">
            <div class="intro-section">
                <a href="{{route('products.create')}}" class="btn-success btn">Add New</a></h2>
                <div class="aside-button">
                    <form class="form-inline" role="form">
                        <input type="text" name="search_key" class="form-control" id="search" placeholder="Search" value=" {{$search_key}} ">
                        <button type="submit" class="btn-search" value="Search"></button>
                    </form>
                    <a href="/admin/products?search_reset=1" class="reload-btn btn-default btn"></a>
                </div>
            </div>
            <table class="table-striped table table-responsive">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Title</th>
                    <th>Price</th>
                    <th>Image</th>
                    <th class="fx-action-links text-center">Actions</th>
                </tr>
                </thead>
                <tbody>
                    @each('admin.product.product', $products, 'product', 'admin.product.empty')
                </tbody>
            </table>
        </div>

        {{$products->links()}}

@endsection
